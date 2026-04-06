@php
    $sexOptions = ['Male', 'Female'];
    $maritalStatusOptions = ['Single', 'Married', 'Widowed', 'Separated'];
@endphp

<x-forms.container
    action="{{ $action }}"
    method="POST"
    class="flex flex-col gap-4 w-full md:w-2/3 p-4 md:p-8 font-mono"
    enctype="multipart/form-data"
>
    @method($method ?? 'POST')

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded p-3">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li class="text-red-500 text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Patient Photo --}}
    <div class="flex flex-col gap-2">
        <label for="image_filename" class="font-bold text-sm md:text-base">Patient Photo (Optional)</label>
        <div class="flex items-center gap-4">
            @if($patient->image_filename)
                <img src="{{ $patient->image_url }}"
                     alt="Current photo"
                     class="w-20 h-20 rounded-full object-cover border border-border"
                >
            @endif
            <div class="w-full flex flex-col gap-1">
                <input
                    type="file"
                    name="image_filename"
                    id="image_filename"
                    accept=".jpg,.jpeg,.png"
                    class="w-full border border-border bg-white rounded-sm px-4 py-2 file:mr-4 file:py-1 file:px-2 file:rounded-sm file:bg-secondary file:text-xs hover:file:bg-secondary/80 file:cursor-pointer"
                >
                <small class="text-gray-500">Max File Size: 10MB</small>
            </div>
        </div>
    </div>

    {{-- First Name --}}
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <label for="first_name" class="font-bold text-sm md:text-base">First Name</label>
        <x-forms.input
            type="text"
            name="first_name"
            id="first_name"
            value="{{ old('first_name', $patient->first_name) }}"
            required
            variant="form"
        />
    </div>

    {{-- Last Name --}}
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <label for="last_name" class="font-bold text-sm md:text-base">Last Name</label>
        <x-forms.input
            type="text"
            name="last_name"
            id="last_name"
            value="{{ old('last_name', $patient->last_name) }}"
            required
            variant="form"
        />
    </div>

    {{-- Birthdate, Sex, Marital Status Row --}}
    <div class="flex flex-col md:flex-row items-stretch gap-4 md:gap-6 w-full">
        <div class="flex flex-col gap-1 w-full md:flex-1">
            <label for="date_of_birth" class="font-bold text-sm md:text-base">Birthdate</label>
            <x-forms.input
                type="date"
                name="date_of_birth"
                id="date_of_birth"
                max="{{ now()->format('Y-m-d') }}"
                value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}"
                required
                variant="form"
                class="w-full"
            />
        </div>
        <div class="flex flex-col gap-1 w-full md:flex-1">
            <label for="sex" class="font-bold text-sm md:text-base">Sex</label>
            <x-forms.select name="sex" id="sex" variant="form" class="w-full">
                <option value="" disabled {{ old('sex', $patient->sex) ? '' : 'selected' }}>Select Sex</option>
                @foreach ($sexOptions as $option)
                    <option
                        value="{{ $option }}"
                        {{ old('sex', $patient->sex) === $option ? 'selected' : '' }}
                    >
                        {{ $option }}
                    </option>
                @endforeach
            </x-forms.select>
        </div>
        <div class="flex flex-col gap-1 w-full md:flex-1">
            <label for="marital_status" class="font-bold text-sm md:text-base">Marital Status</label>
            <x-forms.select name="marital_status" id="marital_status" variant="form" class="w-full">
                <option value="" disabled {{ old('marital_status', $patient->marital_status) ? '' : 'selected' }}>Select Marital Status</option>
                @foreach ($maritalStatusOptions as $option)
                    <option value="{{ $option }}"
                        {{ old('marital_status', $patient->marital_status) === $option ? 'selected' : '' }}
                    >
                        {{ $option }}
                    </option>
                @endforeach
            </x-forms.select>
        </div>
    </div>

    {{-- Address --}}
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <label for="address" class="font-bold text-sm md:text-base">Address</label>
        <x-forms.input
            type="text"
            name="address"
            id="address"
            value="{{ old('address', $patient->address) }}"
            required
            variant="form"
        />
    </div>

    {{-- Occupation --}}
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <label for="occupation" class="font-bold text-sm md:text-base">Occupation</label>
        <x-forms.input
            type="text"
            name="occupation"
            id="occupation"
            value="{{ old('occupation', $patient->occupation) }}"
            variant="form"
        />
    </div>

    {{-- Guardian Name --}}
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <label for="guardian_name" class="font-bold text-sm md:text-base">Guardian Name (Optional)</label>
        <x-forms.input
            type="text"
            name="guardian_name"
            id="guardian_name"
            value="{{ old('guardian_name', $patient->guardian_name) }}"
            variant="form"
        />
    </div>

    {{-- Contact Number --}}
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <label for="contact_no" class="font-bold text-sm md:text-base">Contact Number</label>
        <x-forms.input
            type="text"
            name="contact_no"
            id="contact_no"
            value="{{ old('contact_no', $patient->contact_no) }}"
            pattern="^09[0-9]{9}$"
            required
            variant="form"
        />
    </div>

    <x-ui.button
        type="submit"
        variant="primary"
        class="px-1 py-3 rounded-xl mt-4"
    >
        {{ $submitLabel }}
    </x-ui.button>
</x-forms.container>
