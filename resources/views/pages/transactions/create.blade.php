@extends('layouts.layout')

@php
    $paymentMode = ['Cash', 'GCash', 'Card'];
@endphp

@section('content')
<div class="w-full h-full px-2 pb-2 md:px-4 md:pb-4 grid grid-cols-12 gap-4 overflow-hidden">
    {{-- Patient and Appointment Panel --}}
    <div id="patient-search-container" class="h-content col-span-12 md:h-full md:col-span-5 lg:col-span-4 font-sans bg-white border border-edge rounded-xl shadow-sm flex flex-col overflow-hidden">
        <div class="flex flex-col w-full bg-gray-50 p-4 border-b border-edge">
            <h2 class="text-lg font-mono font-bold text-gray-800 uppercase tracking-tight">Patients & Appointments</h2>
            <p class="text-[10px] font-mono text-gray-500 uppercase tracking-widest">Search first, then select appointment</p>
        </div>
        
        <div class="flex-1 overflow-y-auto">
            <div class="p-4 space-y-6">
                {{-- Search Section --}}
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-mono font-bold text-gray-800 uppercase tracking-widest">Search Patient</label>
                    <x-forms.patient-search />
                </div>

                {{-- Patient Info --}}
                <div id="patient-info-container" class="animate-fade-in-up"></div>

                {{-- Appointments Section --}}
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-mono font-bold text-gray-800 uppercase tracking-widest">Appointments</label>
                    <div id="appointment-container" class="flex flex-col gap-3 w-full">
                        <p class="text-xs text-gray-500 font-mono italic uppercase tracking-widest">Select a patient to see appointments</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ledger Record Panel --}}
    <div class="h-content md:h-full col-span-12 md:col-span-7 lg:col-span-8 flex flex-col overflow-hidden bg-white border border-edge rounded-xl shadow-sm">
        <div class="flex justify-between items-center p-4 bg-gray-50 border-b border-edge">
            <h1 class="text-xl font-mono font-bold text-gray-800 uppercase tracking-tight">New Transaction</h1>
            <a href="{{ route('transactions.index') }}" class="bg-secondary/50 hover:bg-secondary text-primary px-4 py-2 rounded-xl text-[10px] font-mono uppercase tracking-widest transition-colors flex items-center gap-2 border border-primary/20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Return to List
            </a>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="p-6 space-y-8">
                {{-- Ledger Table --}}
                <div class="flex flex-col gap-4">
                    <h3 class="text-sm font-mono font-bold text-gray-800 uppercase tracking-tight border-l-4 border-primary pl-2">Procedures & Charges</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-edge">
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest">Procedure</th>
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest">Ledger</th>
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody id="ledger-info-table" class="divide-y divide-edge divide-dotted">
                                {{-- Dynamically populated --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Transaction Table --}}
                <div class="flex flex-col gap-4">
                    <h3 class="text-sm font-mono font-bold text-gray-800 uppercase tracking-tight border-l-4 border-tertiary pl-2">Transaction History</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-edge">
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest">Description</th>
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest">Mode</th>
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest text-right">Debit</th>
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest text-right">Credit</th>
                                    <th class="py-3 text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest text-right">Balance</th>
                                </tr>
                            </thead>
                            <tbody id="transaction-info-table" class="divide-y divide-edge divide-dotted">
                                {{-- Dynamically populated --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Form Section --}}
            <div class="px-6 pb-6 mt-4">
                <x-forms.container action="{{ route('transactions.store') }}" method="POST" class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                    {{-- Totals --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl bg-white border border-edge shadow-sm">
                            <p class="text-[10px] font-mono font-bold text-gray-500 uppercase tracking-widest mb-1">Total Charged</p>
                            <p id="total-charged" class="text-xl font-bold text-gray-900 font-mono tracking-tight">₱0.00</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white border border-edge shadow-sm">
                            <p class="text-[10px] font-mono font-bold text-gray-500 uppercase tracking-widest mb-1">Total Paid</p>
                            <p id="total-paid" class="text-xl font-bold text-green-600 font-mono tracking-tight">₱0.00</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white border border-edge shadow-sm">
                            <p class="text-[10px] font-mono font-bold text-gray-500 uppercase tracking-widest mb-1">Remaining Balance</p>
                            <p id="remaining-balance" class="text-xl font-bold text-danger font-mono tracking-tight">₱0.00</p>
                        </div>
                    </div>

                    {{-- Record Payment --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                        {{-- Select Procedure (Ledger) --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-mono font-bold text-gray-800 uppercase tracking-widest">Select Procedure</label>
                            <div class="relative group">
                                <select 
                                    id="ledger-selector"
                                    name="ledger_id"
                                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-mono focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none cursor-pointer pr-10"
                                    required
                                >
                                    <option value="" disabled selected>Choose procedure</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{-- Credit Amount --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-mono font-bold text-gray-800 uppercase tracking-widest">Credit Amount</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold font-mono">₱</span>
                                <input 
                                    type="number" 
                                    step="0.01"
                                    name="credit_amount"
                                    id="credit-amount"
                                    class="w-full bg-white border border-gray-300 rounded-lg pl-8 pr-4 py-2.5 font-mono text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    placeholder="0.00"
                                    required
                                >
                            </div>
                        </div>
                        {{-- Payment Mode --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-mono font-bold text-gray-800 uppercase tracking-widest">Payment Mode</label>
                            <div class="relative group">
                                <select 
                                    name="mode_of_payment"
                                    id="mode-of-payment"
                                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-mono focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none cursor-pointer pr-10"
                                    required
                                >
                                    @foreach ($paymentMode as $mode)
                                        <option value="{{ $mode }}">{{ $mode }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{-- Pay in Full Button --}}
                        <div class="flex items-end">
                            <button 
                                type="button"
                                id="pay-full-btn"
                                class="w-full bg-white border border-primary/30 text-primary font-mono font-bold text-[10px] uppercase tracking-widest rounded-lg px-4 py-3 hover:bg-primary hover:text-white transition-all duration-200"
                            >
                                Pay in full
                            </button>
                        </div>
                    </div>
                    
                    {{-- Submit --}}
                    <div class="flex justify-end mt-8 pt-6 border-t border-edge border-dotted">
                        <x-ui.button
                            type="submit"
                            variant="primary"
                            class="px-10 py-4 rounded-xl text-lg transition-all shadow-lg shadow-primary/20"
                        >
                            Record Transaction
                        </x-ui.button>
                    </div>
                </x-forms.container>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/transactions/create.js'])
@endpush
