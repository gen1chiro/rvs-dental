@extends('layouts.layout')

@section('hideNavbar', true)
@section('content')
    <div class="flex flex-col gap-4 my-auto max-w-4xl mx-auto w-full">
        @include('pages.appointments.partials.certificate')
    </div>
@endsection

@if(session('print'))
    <script>
        window.print();
    </script>
@endif