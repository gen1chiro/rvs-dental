@extends('layouts.layout')

@section('content')
    <div id="appointment-view-container"
         data-url="{{ route('appointments.index') }}"
         data-calendar-url="{{ url('appointments/calendar/data') }}"
         class="w-full h-full px-2 pb-2 md:px-4 md:pb-4 flex gap-4 overflow-hidden relative">

        <!-- Main Panel (List or Calendar) -->
        <div id="list-panel"
             class="flex-1 min-h-0 flex flex-col bg-white border border-edge rounded-xl shadow-sm transition-all duration-300 overflow-hidden">

            <x-appointments.toolbar/>

            <!-- List View -->
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

            <!-- Calendar View (Hidden by default) -->
            <div id="calendar-panel" class="hidden flex-1 flex flex-col min-h-0 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-edge flex justify-between items-center sticky top-0 z-10">
                    <div class="flex items-center gap-4">
                        <h2 id="calendar-month-year" class="text-lg font-bold text-gray-900"></h2>
                        <div class="flex items-center gap-1">
                            <button id="prev-month" class="p-1 hover:bg-gray-200 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button id="next-month" class="p-1 hover:bg-gray-200 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <button id="calendar-today" class="px-3 py-1 text-sm font-medium text-primary hover:bg-primary/10 rounded-md transition-colors border border-primary">
                        Today
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <!-- Days Header -->
                    <div class="grid grid-cols-7 border-b border-edge  bg-white sticky top-0 z-10">
                        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                            <div class="py-2 text-center     text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $day }}</div>
                        @endforeach
                    </div>
                    <!-- Calendar Grid -->
                    <div id="calendar-grid" class="grid grid-cols-7 divide-x divide-y border-b border-edge divide-edge"></div>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
        <div id="detail-panel"
             class="fixed inset-y-0 right-0 z-50 w-0 opacity-0 md:relative md:inset-auto md:z-auto border-edge bg-white border-l md:border shadow-2xl md:shadow-sm transition-all duration-300 flex flex-col overflow-hidden md:rounded-xl">

            <div id="detail-content" class="h-full w-full">
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    @vite(['resources/js/appointments/index.js'])
@endpush
