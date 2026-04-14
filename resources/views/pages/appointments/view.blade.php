@extends('layouts.layout')

@section('content')
    <a href="{{ route('appointments.edit', $appointment) }}">Edit Appointment</a>
    <a href="{{ route('appointments.generate', $appointment) }}">Generate Certificate</a>
@endsection