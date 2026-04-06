@extends('layouts.layout')

@section('content')
    <div class="w-full h-full p-2 md:p-4 flex gap-4 overflow-hidden relative">

        <!-- Appointment List -->
        <div id="list-panel"
             class="flex-1 min-h-0 flex flex-col bg-white border rounded-xl shadow-sm transition-all duration-300">

            <x-appointments.toolbar/>

            <div id="appointment-container"
                 data-url="{{ route('appointments.index') }}"
                 class="flex-1 min-h-0 overflow-y-auto">

                <div id="appointment-list">
                    @include('components.appointments.list', ['appointments' => $appointments])
                </div>

                <div id="infinite-scroll-trigger" class="p-6 text-center" @if(!$hasMore) style="display: none;" @endif>
                    <div class="animate-pulse text-muted text-sm">Loading...</div>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
        <div id="detail-panel"
             class="fixed inset-y-0 right-0 z-50 w-0 opacity-0 md:relative md:inset-auto md:z-auto bg-white border-l md:border shadow-2xl md:shadow-sm transition-all duration-300 flex flex-col overflow-hidden md:rounded-xl">

            <div id="detail-content" class="h-full w-full">
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    @vite(['resources/js/appointments/index.js'])
@endpush
