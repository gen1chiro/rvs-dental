@props([
    'name' => 'select',
    'variant' => '',
])

@php
    $baseClasses = 'font-mono';

    $variantClasses = match ($variant) {
        'form' => 'flex-1 border border-border bg-white rounded-sm px-4 py-2',
        default => '',
    };
@endphp

<select
    name="{{ $name }}"
    {{ $attributes->merge(['class' => "$baseClasses $variantClasses"]) }}
>
    {{ $slot }}
</select>
