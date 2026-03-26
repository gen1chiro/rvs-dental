@props([
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $baseClasses = 'hover:cursor-pointer inline-flex items-center justify-center px-4 py-2 font-mono text-sm font-medium border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variantClasses = match ($variant) {
        'primary' => 'bg-primary border-secondary text-white hover:bg-primary/90 focus:ring-primary',
        'secondary' => 'bg-secondary border-primary text-primary hover:bg-secondary/90 focus:ring-secondary',
        'danger' => 'bg-red-600 border-red-700 text-white hover:bg-red-700 focus:ring-red-500',
        default => 'bg-primary border-secondary text-white hover:bg-primary/90 focus:ring-primary',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "$baseClasses $variantClasses"]) }}
>
    {{ $slot }}
</button>
