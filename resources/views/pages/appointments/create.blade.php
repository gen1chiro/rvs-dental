@extends('layouts.layout')

@php
    use App\Models\Appointment;
@endphp

@section('hideNavbar', true)
@section('content')
    @include('pages.appointments.partials.form', [
        'appointment' => new Appointment(),
        'action' => route('appointments.store'),
        'submitLabel' => 'Schedule Appointment'
    ])
@endsection