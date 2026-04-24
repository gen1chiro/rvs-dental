@props(['ledger'])
@php
    /** @var \App\Models\Ledger $ledger */
    $patient = $ledger->appointmentProcedure?->appointment?->patient;
    //butang ko lng di kay para daw transaction man gyapon
    $transaction = $ledger->latestTransaction;
@endphp

<div class="flex flex-col h-full w-full bg-secondary bg-opacity-30 overflow-y-auto animate-fade-in-up">
    <!-- Header Section -->
    <div class="p-6 border-b border-edge">
        <div class="flex justify-between items-start mb-2">
            <h2 class="text-xl md:text-2xl font-black text-gray-900 uppercase leading-tight">
                {{ $patient->first_name }} {{ $patient->last_name }}
            </h2>
            <button id="close-transaction-detail" class="text-danger hover:scale-110 transition-transform p-1">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                </svg>
            </button>
        </div>
        <p class="text-sm md:text-md font-medium text-gray-700 font-mono uppercase tracking-wider">
            #ID{{ str_pad($transaction->ledger_id, 7, '0', STR_PAD_LEFT) }}
        </p>
    </div>

    <!-- Transaction Info -->
    <div class="divide-y divide-dotted divide-edge divide-opacity-50">
        <!-- Date -->
        <div class="px-6 py-4">
            <p class="text-base font-bold text-gray-900">
                {{ $transaction->created_at->format('F d, Y H:i | l') }}
            </p>
            <p class="text-xs text-gray-900">Transaction Date</p>
        </div>

        <!-- Amount -->
        <div class="px-6 py-4">
            <p class="text-base font-bold text-gray-900 uppercase">
                PHP {{ number_format($transaction->credit_amount, 2) }}
            </p>
            <p class="text-xs text-gray-900">Amount</p>
        </div>

        <!-- Payment Method -->
        <div class="px-6 py-4">
            <p class="text-base font-bold text-gray-900 capitalize">
                {{ $transaction->mode_of_payment }}
            </p>
            <p class="text-xs text-gray-900">Payment Method</p>
        </div>

        <!-- Status -->
        <div class="px-6 py-4">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 font-normal rounded-full {{ $transaction->running_balance > 0 ? 'bg-danger' : 'bg-success' }}"></span>
                <p class="text-base text-gray-900 font-bold capitalize">
                    {{ $transaction->running_balance > 0 ? 'Pending' : 'Completed' }}
                </p>
            </div>
            <p class="text-xs text-gray-900">Status</p>
        </div>
    </div>

    <!-- Patient Card & Action -->
    <div class="px-6 py-6 border-t border-edge mt-auto">
        <div class="flex gap-4 items-center">
            <img
                src="{{ $patient->image_url }}"
                alt="Image of {{ $patient->first_name }}"
                class="w-16 h-16 md:w-20 md:h-20 bg-white border border-edge shrink-0 object-cover"
            >
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-1 mt-1 text-[11px] text-gray-600">
                    <p class="truncate"><span class="font-semibold text-gray-900">Age:</span> {{ $patient->age }} y.o.</p>
                    <p class="truncate"><span class="font-semibold text-gray-900">P:</span> {{ $patient->contact_no }}</p>
                    <p class="truncate"><span class="font-semibold text-gray-900">DOB:</span> {{ $patient->date_of_birth->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <a
            href="{{ route('patients.show', $patient->patient_id) }}"
            class="w-full mt-6 md:mt-8 bg-primary hover:bg-opacity-90 text-white py-3 md:py-4 px-6 rounded-sm font-bold text-sm flex items-center justify-center gap-2 transition-all uppercase tracking-widest"
        >
            VIEW FULL INFO <span class="text-lg">→</span>
        </a>
    </div>
</div>
