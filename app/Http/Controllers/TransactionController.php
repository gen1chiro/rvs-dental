<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');
        $status = $request->input('status', 'Pending');
        $sort = $request->query('sort', 'desc') === 'asc' ? 'asc' : 'desc';

        $query = Transaction::with(['ledger.appointmentProcedure.appointment.patient'])
            ->where('credit_amount', '>', 0);

        if ($search) {
            $query->whereHas('ledger.appointmentProcedure.appointment.patient', function ($q) use ($search) {
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
                $query->where('running_balance', '>', 0);
            } elseif ($status === 'Completed') {
                $query->where('running_balance', '<=', 0);
            }
        }

        $transactions = $query->orderBy('created_at', $sort)->paginate(10);

        if (request()->ajax()) {
            return response()->view('components.transactions.list', ['transactions' => $transactions])
                ->header('X-Has-More', $transactions->hasMorePages() ? '1' : '0');
        }

        return view('pages.transactions', compact('transactions'));
    }

    public function create()
    {
        return view('pages.transactions.create');
    }

    public function show(Transaction $transaction)
    {
        $transaction->loadMissing([
            'ledger.appointmentProcedure.appointment.patient',
            'ledger.appointmentProcedure.dentalProcedure'
        ]);

        if (request()->ajax()) {
            return view('pages.transactions.partials.details', compact('transaction'));
        }

        return view('pages.transactions', [
            'transactions' => Transaction::where('credit_amount', '>', 0)->latest()->paginate(10),
            'selectedTransaction' => $transaction
        ]);
    }
}
