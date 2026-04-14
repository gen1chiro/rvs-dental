@extends('layouts.layout')

@section('content')
<div class="p-12">
    <h1 class="text-3xl font-bold mb-4">Add Transaction</h1>
    <p class="text-gray-600 font-mono italic">this is the add transaction page</p>
    
    <div class="mt-8">
        <a href="{{ route('transactions.index') }}" class="text-primary hover:underline font-mono">
            &larr; Back to Transactions
        </a>
    </div>
</div>
@endsection
