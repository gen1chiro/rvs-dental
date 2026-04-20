@extends('layouts.layout')

@section('content')
<div class="w-full px-4 sm:px-12 py-6 sm:py-10">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-6 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-4xl sm:text-6xl text-gray-900 tracking-tight">{{ $appointment->patient?->full_name ?? 'Appointment Details' }}</h1>
            <p class="text-gray-500 font-mono text-sm uppercase tracking-widest">
                Appointment #{{ $appointment->appointment_id }} • {{ $appointment->scheduled_at->format('F j, Y') }} • {{ $appointment->slot }}
            </p>
        </div>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
            <a href="{{ route('appointments.index') }}"
               class="bg-secondary/50 hover:bg-secondary text-primary px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-[10px] sm:text-xs font-mono uppercase tracking-widest transition-colors flex items-center gap-2 border border-primary/20 justify-center">
                Return to List
            </a>
            <a href="{{ route('appointments.edit', $appointment) }}"
               class="bg-white hover:bg-gray-50 text-gray-700 px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-[10px] sm:text-xs font-mono uppercase tracking-widest transition-colors flex items-center gap-2 border border-gray-300 justify-center">
                Edit
            </a>
            <button type="button" id="toggle-upload-btn"
               class="bg-white hover:bg-gray-50 text-gray-700 px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-[10px] sm:text-xs font-mono uppercase tracking-widest transition-colors flex items-center gap-2 border border-primary/20 justify-center shadow-sm">
                Add Images
            </button>
            <a href="{{ route('appointments.generate', $appointment) }}"
               class="bg-primary hover:bg-primary/90 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-[10px] sm:text-xs font-mono uppercase tracking-widest transition-colors flex items-center gap-2 justify-center">
                Certificate
            </a>
            <a href="{{ route('appointments.generate', $appointment) }}"
               class="bg-primary hover:bg-primary/90 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-[10px] sm:text-xs font-mono uppercase tracking-widest transition-colors flex items-center gap-2 justify-center">
                Medical Form
            </a>
        </div>
    </div>

    <hr class="border-gray-300 mb-8 sm:mb-12">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Left: Procedure Form --}}
        <div class="lg:col-span-1">
            <h2 class="text-xl font-mono font-bold text-gray-800 uppercase tracking-tight mb-6">Add Procedure</h2>
            @include('pages.appointments.partials.procedure-form')
        </div>

        {{-- Right: Procedures Conducted & Upload Form --}}
        <div class="lg:col-span-2">
            {{-- Upload Form (Hidden by default) --}}
            <div id="upload-form-container" class="hidden mb-12 animate-in fade-in slide-in-from-top-4 duration-300">
                <h2 class="text-xl font-mono font-bold text-gray-800 uppercase tracking-tight mb-6">Upload Procedure Images</h2>
                <x-forms.container
                    action="{{ route('appointments.images.save', $appointment) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="bg-gray-50 p-6 sm:p-8 rounded-3xl border border-gray-200"
                >
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">
                                Select Images
                            </label>
                            <input type="file"
                                name="images[]"
                                id="images-input"
                                multiple
                                class="block w-full text-sm font-mono border border-gray-300 rounded-xl p-4 bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                accept=".jpg,.png,.jpeg"
                            >
                            <p class="text-gray-500 text-[10px] font-mono mt-2 uppercase tracking-tight">Max 10MB per image. Formats: JPG, JPEG, PNG.</p>
                        </div>

                        <div id="selected-file-list" class="grid grid-cols-1 sm:grid-cols-2 gap-3"></div>

                        <div class="flex justify-end pt-2">
                            <x-ui.button
                                type="submit"
                                variant="primary"
                                class="w-full sm:w-auto px-8 py-3 rounded-xl text-sm transition-all shadow-lg shadow-primary/20"
                            >
                                Start Upload
                            </x-ui.button>
                        </div>
                    </div>
                </x-forms.container>
                <hr class="border-gray-200 mt-12">
            </div>

            <h2 class="text-xl font-mono font-bold text-gray-800 uppercase tracking-tight mb-6">Procedures Conducted</h2>
            @if ($appointment->appointmentProcedures->isEmpty())
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl p-12 text-center">
                    <p class="text-gray-500 font-mono italic text-sm uppercase tracking-widest">No procedures yet for this appointment.</p>
                </div>
            @else
                <div class="flex flex-col gap-4">
                    @foreach ($appointment->appointmentProcedures as $procedure)
                        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-lg font-bold text-gray-900">{{ $procedure->dentalProcedure->name }}</p>
                                <p class="text-lg font-mono font-bold text-primary">₱{{ number_format($procedure->ledger->charged_price, 2) }}</p>
                            </div>
                            @if ($procedure->notes)
                                <p class="text-gray-600 text-sm italic border-l-2 border-primary/20 pl-4 mt-2 font-mono">{{ $procedure->notes }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        (function() {
            const toggleBtn = document.getElementById('toggle-upload-btn');
            const uploadFormContainer = document.getElementById('upload-form-container');
            const fileInput = document.getElementById('images-input');
            const fileListContainer = document.getElementById('selected-file-list');

            if (!toggleBtn || !uploadFormContainer) return;

            let selectedFiles = [];

            const formatSize = (bytes) => {
                if (bytes >= 1048576) return `${(bytes / 1048576).toFixed(2)} MB`;
                if (bytes >= 1024) return `${(bytes / 1024).toFixed(2)} KB`;
                return `${bytes.toFixed(2)} B`;
            }

            const renderFiles = () => {
                if (!fileListContainer) return;

                fileListContainer.innerHTML = selectedFiles
                    .map((file, index) => `
                        <div class="flex justify-between items-center bg-white border border-gray-200 rounded-xl px-4 py-3 shadow-sm">
                            <div class="flex flex-col min-w-0">
                                <span class="font-mono text-xs text-gray-900 truncate font-bold">${file.name}</span>
                                <span class="font-mono text-[9px] text-gray-500 uppercase tracking-tighter">${formatSize(file.size)}</span>
                            </div>
                            <button
                                type="button"
                                data-index="${index}"
                                class="ml-2 text-red-400 hover:text-red-600 transition-colors p-1.5 hover:bg-red-50 rounded-lg remove-file-trigger"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    `)
                    .join('');
            };

            toggleBtn.addEventListener('click', () => {
                uploadFormContainer.classList.toggle('hidden');
            });

            if (fileInput) {
                fileInput.addEventListener('change', () => {
                    selectedFiles = Array.from(fileInput.files);
                    renderFiles();
                });
            }

            if (fileListContainer) {
                fileListContainer.addEventListener('click', (e) => {
                    const removeTrigger = e.target.closest('.remove-file-trigger');
                    if (!removeTrigger) return;

                    const index = parseInt(removeTrigger.dataset.index);
                    selectedFiles.splice(index, 1);

                    const dt = new DataTransfer();
                    selectedFiles.forEach(file => dt.items.add(file));
                    fileInput.files = dt.files;

                    renderFiles();
                });
            }
        })();
    </script>
@endpush
