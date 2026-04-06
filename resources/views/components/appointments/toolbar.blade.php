<div class="bg-gray-100 px-4 py-3 rounded-t-xl border border-edge flex flex-col md:flex-row justify-between items-center gap-4">

    <div class="bg-white flex items-center px-3 py-2 rounded-xl border border-edge w-full md:w-2/5 focus-within:border-primary transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
        <input id="appointment-search" type="text" placeholder="Search Appointment..." class="flex-1 ml-2 outline-none text-sm text-gray-700 bg-transparent">
        <button id="date-sort-btn" class="bg-secondary hover:bg-primary/50 text-primary px-4 text-sm py-2 rounded flex items-center gap-1 hover:cursor-pointer group">
            Date
            <svg id="date-sort-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 transition-transform duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75 12 3m0 0 3.75 3.75M12 3v18" />
            </svg>
        </button>
    </div>

    <div class="flex items-center gap-3 w-full md:w-auto">
        {{-- Calendar View Button --}}
        <x-ui.button variant="outline" class="rounded-xl gap-2">
            Calendar View
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
            </svg>
        </x-ui.button>

        {{-- Date Picker --}}
        <div class="bg-white flex items-center px-3 py-2 rounded-xl border border-edge focus-within:border-primary transition-colors">
            <input type="date" id="date-filter-input" class="outline-none text-sm text-gray-700 bg-transparent cursor-pointer">
        </div>
    </div>
</div>
