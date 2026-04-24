<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Ledger;

class TransactionController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');
        $status = $request->input('status', 'Pending');
        $sort = $request->query('sort', 'desc') === 'asc' ? 'asc' : 'desc';

        $query = Ledger::with(['appointmentProcedure.appointment.patient', 'latestTransaction'])
            ->where('charged_price', '>', 0);

        if ($search) {
            $query->whereHas('appointmentProcedure.appointment.patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        if ($status && $status !== 'All') {
            if ($status === 'Pending') {
                $query->whereHas('latestTransaction', fn ($q) =>
                    $q->where('running_balance', '>', 0)
                );
            } elseif ($status === 'Completed') {
                $query->whereHas('latestTransaction', fn ($q) =>
                    $q->where('running_balance', '<=', 0)
                );
            }
        }

        $ledgers = $query->orderBy('created_at', $sort)->paginate(10);

        if (request()->ajax()) {
            return response()->view('components.transactions.list', ['ledgers' => $ledgers])
                ->header('X-Has-More', $ledgers->hasMorePages() ? '1' : '0');
        }

        return view('pages.transactions', compact('ledgers'));
    }

    public function create()
    {
        return view('pages.transactions.create');
    }

    public function show(Ledger $ledger)
    {
        $ledger->loadMissing([
            'appointmentProcedure.appointment.patient',
            'appointmentProcedure.dentalProcedure',
            'latestTransaction',
        ]);

        if (request()->ajax()) {
            return view('pages.transactions.partials.details', compact('ledger'));
        }

        return view('pages.transactions', [
            'ledgers' => Ledger::where('charged_price', '>', 0)->latest()->paginate(10),
            'selectedLedger' => $ledger
        ]);
    }

    public function store(StoreTransactionRequest $request) {
        $ledger = Ledger::with('transactions')->find($request->ledger_id);

        $totalCharges = $ledger->transactions->sum('debit_amount');
        $totalPayments = $ledger->transactions->sum('credit_amount');

        $remaining = $totalCharges - $totalPayments;

        $isPayment = $request->type === 'Payment';
        $amount = (float) $request->credit_amount;

        $newBalance = $isPayment ? $remaining - $amount : $remaining;

        if ($isPayment && $amount > $remaining) {
            return back()->withErrors([
                'credit_amount' => 'Payment exceeds remaining balance.'
            ])->withInput();
        }

        if ($isPayment && $remaining <= 0) {
            return back()->withErrors([
                'credit_amount' => 'This ledger is already paid in full.'
            ])->withInput();
        }

        Transaction::create([
            'ledger_id' => $ledger->ledger_id,
            'type' => $request->type,
            'debit_amount' => !$isPayment ? $amount : 0.00,
            'credit_amount' => $isPayment ? $amount : 0.00,
            'running_balance' => $newBalance,
            'mode_of_payment' => $isPayment ? $request->mode_of_payment : null,
        ]);

        return back()->with('success', 'Transaction added successfully.');
    }

    public function update(Request $request, Transaction $transaction) {
        $request->validate([
            'credit_amount' => 'required|numeric|min:0.00'
        ]);

        $ledger = $transaction->ledger()->with('transactions')->first();
        $totalPaid = $ledger->transactions
            ->where('type', 'Payment')
            ->where('transaction_id', '!=', $transaction->transaction_id)
            ->sum('credit_amount');
        $remainingBalance = $ledger->charged_price - $totalPaid;
        $newBalance = $remainingBalance - (float) $request->credit_amount;

        $transaction->update([
            'credit_amount' => $request->credit_amount,
            'running_balance' => $newBalance,
        ]);

        return response()->json([
            'credit_amount' => $transaction->credit_amount,
            'running_balance' => $transaction->running_balance,
            'message' => 'Transaction updated successfully.'
        ]);
    }
}
