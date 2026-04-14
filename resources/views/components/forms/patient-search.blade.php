@props(['patientId' => null, 'patientName' => null])

{{-- Patient Name --}}
<div class="flex flex-col gap-1 w-full" id="patient-search-wrapper">
    <div class="relative">
        <input 
            type="hidden" 
            name="patient_id" 
            id="patient_id"
            value="{{ old('patient_id', $patientId) }}"
        >
        <input 
            type="text" 
            name="patient_name" 
            id="patient_name" 
            placeholder="Enter patient name..." 
            autocomplete="off"
            class="w-full bg-white border border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-lg px-4 py-2 outline-none font-mono"
            value="{{ old('patient_name', $patientName) }}"
        >
        <div class="absolute inset-y-0 right-1 flex items-center pl-2.5 pointer-events-none">
            <svg class="w-4 h-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        <ul id="patient_dropdown" class="hidden absolute z-50 mt-1 w-full bg-white shadow-sm max-h-60 overflow-y-auto">
        </ul>
    </div>
</div>

@push('scripts')
<script>
    (() => {
        const searchInput = document.getElementById('patient_name');
        const patientId = document.getElementById('patient_id');
        const patientList = document.getElementById('patient_dropdown');
        let debounceTimer;

        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            patientId.value = '';

            const searchTerm = this.value.trim();

            if (searchTerm.length < 2) {
                patientList.classList.add('hidden');
                patientList.innerHTML = '';
                return;
            }

            debounceTimer = setTimeout(() => searchPatients(searchTerm), 500);
        });

        const searchPatients = async (query) => {
            const res = await fetch(`/patients/search?query=${encodeURIComponent(query)}`);
            const patients = await res.json();

            console.log(patients);
            patientList.innerHTML = patients.length 
            ? patients.map(patient => `
                <li 
                    data-id="${patient.patient_id}" 
                    data-name="${patient.full_name}"
                >
                    ${patient.full_name}
                </li>
            `).join('')
            : '<li class="px-4 py-2 text-sm text-gray-400">No patients found.</li>';

            patientList.classList.remove('hidden');
            patientList.querySelectorAll('li[data-id]').forEach(li => {
                li.addEventListener('click', function () {
                    searchInput.value = this.dataset.name;
                    patientId.value = this.dataset.id;
                    patientList.classList.add('hidden');
                })
            })

        }
        document.addEventListener('click', (e) => {
            if(!document.getElementById('patient-search-wrapper').contains(e.target)) {
                patientList.classList.add('hidden');
            }
        });
    })();
</script>
@endpush
    