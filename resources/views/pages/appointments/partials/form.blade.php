<x-forms.container
    action="{{ $action }}"
    method="POST"
    class="flex flex-col gap-2 w-1/4"
>
    @method($method ?? 'POST')
    @php
        $status = ['Schedules', 'Completed', 'Cancelled', 'No Show'];
    @endphp
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded p-3">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li class="text-red-500 text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex gap-2 items-center">
        <input type="text" name="patient_name" id="patient_name">
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="10.5" cy="10.5" r="7.5"/>
            <path d="M21 21l-5.2-5.2"/>
            </svg>
        </a>
    </div>

    <x-ui.dentist-dropdown />

    <div class="flex flex-col gap-1 w-full md:flex-1">
        <label for="scheduled_at" class="font-bold text-sm md:text-base">Appointment Date</label>
        <x-forms.input
            type="date"
            name="scheduled_at"
            id="scheduled_at"
            min="{{ now()->format('Y-m-d') }}"
            value="{{ old('scheduled_at', $appointment->scheduled_at?->format('Y-m-d')) }}"
            required
            variant="form"
            class="w-full"
        />
    </div>

    <div class="flex flex-col gap-1 w-full md:flex-1">
        <label for="status" class="font-bold text-sm md:text-base">Status</label>
        <x-forms.select name="status" id="status" variant="form" class="w-full">
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

    <div class="flex flex-col gap-1 w-full md:flex-1">
        <label for="status" class="font-bold text-sm md:text-base">Additional Remarks</label>
        <textarea name="remarks" id="remarks" placeholder="Enter remarks here">
            {{ old('remarks', $appointment->remarks) }}
        </textarea>
    </div>

    <x-ui.button 
        type="submit" 
        variant="primary" 
        class="px-1 py-3"
    >
        {{ $submitLabel }}
    </x-ui.button>
</x-forms.container>