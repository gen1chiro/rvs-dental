@extends('layouts.layout')

@section('content')
    <div class="flex gap-3 w-1/4 bg-red-300 justify-center">
        <a href="{{ route('patients.create') }}">Add</a>
        <a href="{{ route('patients.edit', $patients[0]) }}">Edit</a>
    </div>
    <div class="flex gap-40 w-full">
        @foreach ($patients as $patient)
            <div class="flex flex-col gap-1">
                <p>{{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p>{{ $patient->address }}</p>
                <p>{{ $patient->contact_no }}</p>
                <p>{{ $patient->image_filename }}</p>
                <p>{{ $patient->date_of_birth }}</p>
                <p>{{ $patient->occupation }}</p>
                <p>{{ $patient->marital_status }}</p>
                <p>{{ $patient->guardian_name }}</p>
                <p>{{ $patient->sex }}</p>
            </div>
        @endforeach
    </div>
@endsection
