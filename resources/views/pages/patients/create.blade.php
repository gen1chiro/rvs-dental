@extends('layouts.layout')

@php
    use App\Models\Patient;
@endphp

@section('hideNavbar', true)
@section('content')
    <div class="flex items-center justify-between py-4 md:py-8 mx-4 md:mx-8 border-b border-border sticky top-0 z-50 bg-background">
        <h1 class="text-2xl md:text-5xl">Add Patient</h1>
        <x-ui.button variant="secondary" class="rounded-xl text-xs md:text-sm">
            <a href="{{ route('patients.index') }}">RETURN TO PATIENT LIST</a>
        </x-ui.button>
    </div>
    @include('pages.patients.partials.form', [
        'patient' => new Patient(),
        'action' => route('patients.store'),
        'submitLabel' => 'Add New Patient'
    ])
@endsection
