@props(['transactions'])

@foreach ($transactions as $transaction)
    <x-transactions.item :transaction="$transaction" />
@endforeach
