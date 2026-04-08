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

    <x-ui.dentist-dropdown :selected="old('dentist_id', $appointment->dentist_id)" />
    
    <div class="flex flex-col gap-1 w-full md:flex-1">
        <label for="scheduled_at" class="font-bold text-sm md:text-base">Enter Schedule Slot</label>
        <x-forms.input
            type="datetime-local"
            name="scheduled_at"
            id="scheduled_at"
            min="{{ now()->format('Y-m-d\TH:i') }}"
            value="{{ old('scheduled_at', $appointment->scheduled_at?->format('Y-m-d\TH:i')) }}"
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

    <textarea name="remarks" id="remarks" placeholder="Enter remarks here">
        {{ old('remarks', $appointment->remarks) }}
    </textarea>

    <x-ui.button 
        type="submit" 
        variant="primary" 
        class="px-1 py-3"
    >
        {{ $submitLabel }}
    </x-ui.button>
</x-forms.container>