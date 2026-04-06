@props(['appointmentId', 'name', 'remarks', 'status', 'color'])

<div class="appointment-item flex justify-between items-start px-6 py-5 hover:bg-gray-50 [&.active]:bg-secondary cursor-pointer transition animate-fade-in-up"
     data-id="{{ $appointmentId }}">

    <div class="flex flex-col gap-1">
        <h3 class="font-bold text-gray-900 text-base leading-none">{{ $name }}</h3>
        <p class="text-sm text-gray-600">{{ $remarks }}</p>
    </div>

    <div class="pt-1">
        <span class="{{ $color }} text-xs tracking-wider">
            {{ $status }}
        </span>
    </div>
</div>
