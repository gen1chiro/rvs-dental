@extends('layouts.layout')

@section('content')
    <div class="flex flex-col gap-1">
        <p>{{ $patient->first_name }} {{ $patient->last_name }}</p>
        <p>{{ $patient->address }}</p>
        <p>{{ $patient->contact_no }}</p>
        <img src="{{ $patient->image_url  }}" alt="Image of {{ $patient->first_name }}" class="w-32 h-32 rounded-full object-fit">
        <p>{{ $patient->date_of_birth }}</p>
        <p>{{ $patient->occupation }}</p>
        <p>{{ $patient->marital_status }}</p>
        <p>{{ $patient->guardian_name }}</p>
        <p>{{ $patient->sex }}</p>
    </div>
@endsection