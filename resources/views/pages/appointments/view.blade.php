@extends('layouts.layout')

@section('content')
    <div class="flex gap-2">
        <a href="{{ route('appointments.edit', $appointment) }}">Edit Appointment</a>
        <button type="button" id="upload-btn">Add Procedure Images</button>
        <a href="{{ route('appointments.generate', $appointment) }}">Generate Certificate</a>
        <a href="{{ route('appointments.generate', $appointment) }}">Medical Form</a>
    
    </div>
    <div class="flex gap-10">
        @include('pages.appointments.partials.procedure-form')
       
        <div class="flex flex-col gap-3">
            <h1>Procedures Conducted</h1>
            @if ($appointment->appointmentProcedures->isEmpty())
                <p>No procedures yet for this appointment.</p>
            @else
                <div class="flex flex-col gap-3">
                    @foreach ($appointment->appointmentProcedures as $procedure)
                        <div class="border p-3 rounded-lg flex flex-col">
                            <div class="flex justify-between">
                                <p>{{ $procedure->dentalProcedure->name }}</p>
                                <p>₱{{ $procedure->ledger->charged_price }}</p>
                            </div>
                            @if ($procedure->notes)
                                <p>{{ $procedure->notes }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div id="upload-form" class="mt-4 p-4 rounded-lg bg-gray-50">
        <x-forms.container 
            action="{{ route('appointments.images.save', $appointment) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Select Images
                </label>

                <input type="file"
                    name="images[]"
                    id="images"
                    multiple
                    class="block w-full text-sm border border-gray-300 rounded p-2 bg-white"
                    accept=".jpg,.png,.jpeg"
                >
                <small class="text-gray-500">Max of 10MB per image only. Accepted file types: JPG/JPEG, PNG.</small>
            </div>
            <div id="file-list" class="mt-4 flex flex-col gap-2"></div>
            <x-ui.button
                type="submit"
                variant="primary"
                class="w-full sm:w-auto px-10 py-4 rounded-xl text-lg transition-all"
            >
                Add Images
            </x-ui.button>
        </x-forms.container>
    </div>
@endsection

@push('scripts')
    <script>
        const btn = document.getElementById('upload-btn');
        const imgForm = document.getElementById('upload-form');
        const imageInput = document.getElementById('images');
        const fileDetailsContainer = document.getElementById('file-list');

        let selectedFiles = [];

        const formatBytes = (bytes) => {
            if (bytes >= 1048576) return `${(bytes / 1048576).toFixed(2)} MB`;
            if (bytes >= 1024) return `${(bytes / 1024).toFixed(2)} KB`;
            return `${bytes.toFixed(2)} B`;
        }

        const renderFileList = () => {
            fileDetailsContainer.innerHTML = selectedFiles
                .map((file, index) => `
                    <div class="flex justify-between items-center border rounded px-3 py-2 text-sm">
                        <div class="flex flex-col">
                            <span class="truncate">${file.name}</span>
                            <span class="text-gray-500 text-xs">${formatBytes(file.size)}</span>
                        </div>
                        <button 
                            type="button" 
                            data-index="${index}" 
                            class="text-red-500 hover:text-red-700 font-bold"
                        >
                            ✕
                        </button>
                    </div>
                `)
                .join('');
        };

        btn.addEventListener('click', () => {
            imgForm.classList.toggle('hidden');
        });

        imageInput.addEventListener('change', () => {
            selectedFiles = Array.from(imageInput.files);
            renderFileList();
        })

        fileDetailsContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;

            const index = btn.dataset.index;
            selectedFiles.splice(index, 1);

            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            imageInput.files = dt.files;

            renderFileList();
        })
    </script>
@endpush
