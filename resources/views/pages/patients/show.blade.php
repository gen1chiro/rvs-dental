@extends('layouts.layout')

@section('content')
    <div class="w-full h-full px-4 pb-4 grid grid-cols-12 gap-4">
        <div id="patient-info" data-patient-id="{{ $patient->patient_id }}" class="h-content col-span-12 md:h-full md:col-span-5 lg:col-span-4 font-sans border border-border rounded-xl flex bg-secondary flex-col overflow-hidden">
            <div class="flex-1 overflow-auto">
                <p class="font-bold text-3xl p-4 border-b border-border">
                    <span>{{ $patient->first_name }}</span>
                    <span>{{ $patient->last_name }}</span>
                </p>
                <div class="flex flex-col gap-4 p-4 border-b border-border">
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col gap-2">
                            <p class="font-bold text-xl">Basic Information</p>
                            <p class="text-xs">Age: {{ $patient->age }}</p>
                            <p class="text-xs">Sex: {{ $patient->sex }}</p>
                            <p class="text-xs">DOB: {{ $patient->date_of_birth->format('F d, Y') }}</p>
                        </div>
                        <img
                            src="{{ $patient->image_url }}"
                            alt="Image of {{ $patient->first_name }} {{ $patient->last_name }}"
                            class="w-25 bg-white aspect-square object-cover"
                        >
                    </div>
                    <div class="text-xs flex flex-col gap-2">
                        <p>Address: {{ $patient->address }}</p>
                        <p>Occupation: {{ $patient->occupation }}</p>
                        <p>Parent/Guardian Name: {{ $patient->guardian_name ?? 'none' }}</p>
                        <p>Contact No: {{ $patient->contact_no }}</p>
                        <p>Civil Status: {{ $patient->marital_status }}</p>
                    </div>
                </div>
                <div class="p-4 flex flex-col gap-4">
                    <p class="font-bold text-xl">Appointments & Transactions</p>
                    <div class="flex gap-8">
                        <div class="flex flex-col gap-4">
                            <div>
                                <p id="last-appointment-value" class="text-2xl font-bold">Loading...</p>
                                <p class="text-xs">Last Completed Appointment</p>
                            </div>
                            <div>
                                <p id="next-appointment-value" class="text-2xl font-bold">Loading...</p>
                                <p class="text-xs">Next Appointment</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div>
                                <p id="deficiency-value" class="text-2xl font-bold">Loading...</p>
                                <p class="text-xs">Deficiency</p>
                            </div>
                            <div>
                                <p id="total-payment-value" class="text-2xl font-bold">Loading...</p>
                                <p class="text-xs">Full Payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('patients.edit', $patient) }}" class="hover:cursor-pointer inline-flex items-center justify-center px-4 py-4 font-sans text-sm transition-colors duration-200 bg-primary text-white hover:bg-primary/90 w-full shrink-0">
                UPDATE INFORMATION
            </a>
        </div>
        <div class="h-content md:h-full col-span-12 md:col-span-7 lg:col-span-8 flex gap-4 overflow-auto">
            <x-patients.tab-nav />
            <div id="tab-content" class="flex-1 h-full border border-border rounded-xl font-sans">
                @include('pages.patients.partials.medical-history')
                @include('pages.patients.partials.procedures')
            </div>
        </div>
@endsection
