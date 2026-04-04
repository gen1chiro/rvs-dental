@extends('layouts.layout')

@section('content')
    <a href="{{ route('patients.create') }}">Add</a>
    <div class="flex gap-40 w-full">
        @foreach ($patients as $patient)
            <div class="flex flex-col gap-1">
                <p>{{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p>{{ $patient->address }}</p>
                <p>{{ $patient->contact_no }}</p>
                <img src="{{ $patient->image_url  }}" alt="Image of {{ $patient->first_name }}" class="w-32 h-32 rounded-full object-fit">
                <p>{{ $patient->date_of_birth->format('F d, Y') }}</p>
                <p>{{ $patient->occupation }}</p>
                <p>{{ $patient->marital_status }}</p>
                <p>{{ $patient->guardian_name }}</p>
                <p>{{ $patient->sex }}</p>
                <div class="flex gap-3">
                    <a href="{{ route('patients.show', $patient) }}">View</a>
                    <a href="{{ route('patients.edit', $patient) }}">Edit</a>
                    <a href="{{ route('patients.destroy', $patient) }}">Delete</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
