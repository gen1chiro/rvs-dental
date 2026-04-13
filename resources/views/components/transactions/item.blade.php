@props(['transaction'])

<div
    class="transaction-row flex justify-between items-start px-6 py-5 hover:bg-gray-50 [&.active]:bg-secondary cursor-pointer transition animate-fade-in-up"
    data-transaction-id="{{ $transaction->transaction_id }}"
>
    <div class="flex flex-col gap-1">
        <h3 class="font-bold text-lg text-black capitalize">
            {{ $transaction->patient?->first_name }} {{ $transaction->patient?->last_name }}
        </h3>
        <p class="text-sm text-gray-900">
            {{ number_format($transaction->credit_amount, 2) }}
            <span class="uppercase">[{{ $transaction->mode_of_payment }}]</span>
            — {{ $transaction->created_at->format('D d/m/y H:i') }}
        </p>
    </div>
    <div class="flex flex-col items-end gap-2">
        <span class="text-[10px] uppercase tracking-wider {{ $transaction->running_balance > 0 ? 'text-danger' : 'text-success' }}">
            {{ $transaction->running_balance > 0 ? 'Pending' : 'Completed' }}
        </span>
    </div>
</div>
