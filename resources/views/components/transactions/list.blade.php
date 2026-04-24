@props(['ledgers'])

@foreach ($ledgers as $ledger)
    <x-transactions.item :ledger="$ledger" />
@endforeach
