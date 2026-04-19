@props(['appointment'])

<div class="flex flex-col h-full w-full bg-secondary bg-opacity-30 overflow-y-auto animate-fade-in-up">
    <div class="p-6 border-b border-edge">
        <div class="flex justify-between items-start mb-2">
            <h2 class="text-xl md:text-2xl font-black text-gray-900 uppercase leading-tight">
                {{ $appointment->scheduled_at->format('l, F d, Y') }}
            </h2>
            <button id="close-detail" class="text-danger hover:scale-110 transition-transform p-1">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                </svg>
            </button>
        </div>
        <p class="text-sm md:text-md font-medium text-gray-700">
            {{ $appointment->patient_full_name }} |
            @if($appointment->dentist)
                Dr. {{ $appointment->dentist->first_name }} {{ $appointment->dentist->last_name }}
            @else
                N/A
            @endif
        </p>
    </div>

    <div class="divide-y divide-dotted divide-edge divide-opacity-50">
        <div class="px-6 py-4">
            <p class="text-2xl font-bold text-gray-900">
                @if($appointment->dentist)
                    Dr. {{ $appointment->dentist->first_name }} {{ $appointment->dentist->last_name }}
                @else
                    N/A
                @endif
            </p>
            <p class="text-xs text-gray-900">Dentist</p>
        </div>

        <div class="px-6 py-4">
            <p class="text-base font-bold text-gray-900">{{ $appointment->slot ?? 'N/A' }}</p>
            <p class="text-xs text-gray-900">Slot</p>
        </div>

        <div class="px-6 py-4">
            <p class="text-base font-bold text-gray-900">{{ $appointment->status }}</p>
            <p class="text-xs text-gray-900">Status</p>
        </div>
    </div>

    <div class="px-6 py-6 border-t border-edge">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Remarks</h3>
        <p class="text-sm text-gray-900 leading-relaxed">
            {{ $appointment->remarks ?? 'No specific remarks for this appointment.' }}
        </p>
    </div>

    <div class="px-6 py-6 border-t border-edge mt-auto">
        <div class="flex gap-4 items-center">
            <img
                src="{{ $appointment->patient?->image_url }}"
                alt="Image of {{ $appointment->patient_full_name }}"
                class="w-16 h-16 md:w-20 md:h-20 bg-white border border-edge shrink-0 object-cover"
            >
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $appointment->patient_full_name }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-1 mt-1 text-[11px] text-gray-600">
                    <p class="truncate"><span class="font-semibold text-gray-900">Age:</span> {{ $appointment->patient?->age ?? 'N/A' }} y.o.</p>
                    <p class="truncate"><span class="font-semibold text-gray-900">P:</span> {{ $appointment->patient?->contact_no ?? 'N/A' }}</p>
                    <p class="truncate"><span class="font-semibold text-gray-900">DOB:</span> {{ $appointment->patient?->date_of_birth?->format('M/d/Y') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <a href="{{ route('appointments.view', $appointment->appointment_id) }}" class="w-full mt-6 md:mt-8 bg-primary hover:bg-opacity-90 text-white py-3 md:py-4 px-6 rounded-sm font-bold text-sm flex items-center justify-center gap-2 transition-all">
            VIEW APPOINTMENT <span class="text-lg">→</span>
        </a>
    </div>
</div>
