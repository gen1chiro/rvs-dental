<div class="w-full px-12 py-10">
    {{-- Header --}}
    <div class="flex justify-between items-end mb-4">
        <h1 class="text-6xl text-gray-900 tracking-tight">Add Appointment</h1>
        <a href="{{ route('appointments.index') }}"
           class="bg-secondary/50 hover:bg-secondary text-primary px-6 py-3 rounded-xl text-xs font-mono uppercase tracking-widest transition-colors flex items-center gap-2 border border-primary/20">
            Return to Appointment List
        </a>
    </div>

    <hr class="border-gray-300 mb-12">

    {{-- Main Form Container --}}
    <x-forms.container
        action="{{ $action }}"
        method="POST"
        class="flex flex-col gap-4 w-full"
    >
        @method($method ?? 'POST')
        @php
            $status = ['Scheduled', 'Completed', 'Cancelled', 'No Show'];
            $slots = ['Morning (9AM-12PM)', 'Afternoon (1PM-6PM)'];
        @endphp

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 max-w-6xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li class="text-red-500 text-sm font-mono">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Row: Patient Name --}}
        <div class="flex items-center gap-8 max-w-6xl w-full">
            <label for="patient_name" class="w-64 font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Patient</label>
            <div class="flex-1">
                <x-forms.patient-search :patientId="$appointment->patient_id" :patientName="$appointment->patient?->full_name" />
            </div>
        </div>

        {{-- Row: Dentist --}}
        <div class="flex items-center gap-8 max-w-6xl w-full">
            <label for="dentist_id" class="w-64 font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Dentist</label>
            <div class="flex-1">
                <x-ui.dentist-dropdown :selected="$appointment->dentist_id"/>
            </div>
        </div>

        {{-- Row: Date and Slot --}}
        <div class="flex items-center gap-8 max-w-6xl w-full">
            <label for="scheduled_at" class="w-64 font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Date</label>
            <div class="flex-1 flex flex-col md:flex-row gap-8">
                <div class="flex-1">
                    <x-forms.input
                        type="date"
                        name="scheduled_at"
                        id="scheduled_at"
                        min="{{ now()->format('Y-m-d') }}"
                        value="{{ old('scheduled_at', $appointment->scheduled_at?->format('Y-m-d')) }}"
                        required
                        variant="form"
                        class="w-full bg-white border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-lg"
                    />
                </div>
                <div class="flex items-center gap-4 flex-1">
                    <label for="slot" class="font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Slot</label>
                    <div class="flex-1">
                        <x-forms.select name="slot" id="slot" variant="form" class="w-full bg-white border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-lg">
                            <option value="" disabled {{ old('slot', $appointment->slot) ? '' : 'selected' }}>Select Slot</option>
                            @foreach ($slots as $slotOption)
                                @php $slotValue = strtok($slotOption, ' ') @endphp
                                <option value="{{ $slotValue }}"
                                    {{ old('slot', $appointment->slot) === $slotValue ? 'selected' : '' }}
                                >
                                    {{ $slotOption }}
                                </option>
                            @endforeach
                        </x-forms.select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row: Status --}}
        <div class="flex items-center gap-8 max-w-6xl w-full">
            <label for="status" class="w-64 font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Status</label>
            <div class="flex-1">
                <x-forms.select name="status" id="status" variant="form" class="w-full bg-white border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-lg">
                    <option value="" disabled {{ old('status', $appointment->status) ? '' : 'selected' }}>Select Status</option>
                    @foreach ($status as $option)
                        <option value="{{ $option }}"
                            {{ old('status', $appointment->status) === $option ? 'selected' : '' }}
                        >
                            {{ $option }}
                        </option>
                    @endforeach
                </x-forms.select>
            </div>
        </div>

        {{-- Row: Remarks --}}
        <div class="flex items-start gap-8 max-w-6xl w-full">
            <label for="remarks" class="w-64 font-mono font-bold text-sm text-gray-800 uppercase tracking-tight pt-3">Remarks</label>
            <div class="flex-1">
                <textarea
                    name="remarks"
                    id="remarks"
                    rows="8"
                    placeholder="Enter remarks here..."
                    class="w-full bg-white rounded-lg border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary p-4 outline-none font-mono"
                >{{ old('remarks', $appointment->remarks) }}</textarea>
            </div>
        </div>

        {{-- Row: Submit Button --}}
        <div class="flex justify-end mt-8 max-w-6xl w-full">
            <x-ui.button
                type="submit"
                variant="primary"
                class="px-10 py-4 rounded-xl text-lg transition-all"
            >
                {{ $submitLabel }}
            </x-ui.button>
        </div>
    </x-forms.container>
</div>
