@extends('layouts.layout')

@section('content')
    <div class="w-full h-full px-4 pb-4 grid grid-cols-12 gap-4 h-content">
        <!-- Transaction List -->
        <div id="transaction-container" data-url="{{ route('transactions.index') }}" class="col-span-12 md:col-span-7 lg:col-span-8 flex flex-col overflow-hidden border border-border rounded-xl bg-white shadow-sm">
            <x-transactions.toolbar />
            <div id="transaction-list" class="flex-1 overflow-y-auto divide-y divide-border/50">
                @forelse ($transactions as $transaction)
                    <x-transactions.item :transaction="$transaction" />
                @empty
                    <div class="p-10 text-center text-muted italic">
                        No transactions found.
                    </div>
                @endforelse
                <div id="infinite-scroll-trigger"
                     data-has-more="{{ $transactions->hasMorePages() ? '1' : '0' }}"
                     class="py-4 text-center border-t border-border/50">
                    @if($transactions->hasMorePages())
                        <div class="animate-pulse text-muted text-sm">Loading more transactions...</div>
                    @else
                        <span class="text-sm italic text-muted">No more transactions.</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div id="transaction-detail-container" class="hidden md:flex col-span-12 md:col-span-5 lg:col-span-4 border border-border rounded-xl bg-white overflow-hidden flex-col shadow-sm">
            <div id="transaction-detail-content" class="h-full flex flex-col items-center justify-center text-center">
                <div class="p-8">
                    <p class="font-mono text-primary uppercase tracking-widest text-sm">
                        Click on transaction<br>to display info
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/transactions/index.js'])
@endpush
