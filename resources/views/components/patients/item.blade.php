@props(['patient'])

<div
    class="patient-row flex justify-between items-start px-6 py-5 hover:bg-gray-50 [&.active]:bg-secondary cursor-pointer transition animate-fade-in-up"
    data-patient-id="{{ $patient->patient_id }}"
    data-patient='@json($patient)'
>
    <div class="flex flex-col items-start font-sans gap-1">
        <p class="font-bold text-base text-gray-900 leading-none">{{ $patient->first_name }} {{ $patient->last_name }}</p>
        <p class="text-sm text-gray-600">{{ $patient->last_appointment_remarks ?? 'No remarks available.' }}</p>
    </div>
    <p class="font-mono text-xs text-muted text-right pt-1">
        {{ $patient->last_appointment_updated_at ? \Illuminate\Support\Carbon::parse($patient->last_appointment_updated_at)->format('F d, Y h:i A') : 'No appointment yet' }}
    </p>
</div>
