<x-forms.container 
    id="appointment-form"
    action="{{ route('appointment.procedure.store', $appointment) }}"
    method="POST"
    class="flex flex-col gap-4 w-2/5"
    data-appointment-id="{{ $appointment->appointment_id }}"
>
    <div id="procedure-container">
        <div class="flex flex-col">
            <label for="procedure-search">Procedure</label>
            <input type="text" id="procedure-search" placeholder="Search procedures..." autocomplete="off">
        </div>
        <ul id="procedure-dropdown" class="hidden max-h-60 overflow-y-auto"></ul>
        <input type="hidden" name="procedure_id" id="procedure-id">
    </div>
    <div class="flex flex-col gap-2">
        <label for="charged-price">Charged Price</label>
        <input type="number" name="charged_price" id="charged-price" placeholder="Enter amount...">
        <small class="text-gray-500">
            Note: Auto-filled value is based on the minimum procedure price. Adjust if needed.
        </small>
    </div>
    <div class="flex flex-col gap-2">
        <label for="notes">Notes (Optional)</label>
        <textarea type="text" name="notes" id="notes" placeholder="Enter notes..."></textarea>
    </div>
    <div class="flex flex-col gap-2">
        <label for="notes">Ledger Description</label>
        <input name="ledger_description" id="ledger-description" readonly />
        <small class="text-gray-500">
            Note: Ledger description is used for billing records. Procedure notes are only informational.
        </small>
    </div>
    <div class="flex justify-start mt-4 sm:mt-8 max-w-6xl w-full">
        <x-ui.button
            type="submit"
            variant="primary"
            class="w-full sm:w-auto px-10 py-4 rounded-xl text-lg transition-all"
        >
            Add Procedure
        </x-ui.button>
    </div>
</x-forms.container>



@push('scripts')
<script>
    const form = document.getElementById('appointment-form');
    const searchInput = document.getElementById('procedure-search');
    const procedureDropdown = document.getElementById('procedure-dropdown');
    const chargedPriceInput = document.getElementById('charged-price');
    const procedureIdInput = document.getElementById('procedure-id');
    const ledgerDescriptionFormat = document.getElementById('ledger-description');

    let procedures = [];
    let selectedProcedure = null;
    const appointmentId = form.dataset.appointmentId;

    const fetchProcedures = async () => {
        const res = await fetch(`/procedures`);
        const data = await res.json();
        return data;
    }

    const formatPeso = (amount) => `₱${amount}`;

    const renderProcedures = (filtered) => {
        if (filtered.length === 0) {
            procedureDropdown.innerHTML = `<li class="p-2 text-gray-500">No results</li>`;
            return;
        }

        procedureDropdown.innerHTML = filtered.map(procedure => `
            <li 
                data-id="${procedure.procedure_id}" 
                class='flex flex-col'
            >
                <div class="flex justify-between">
                    <p>${ procedure.name }</p>
                    <p>${ procedure.max_price ? `${formatPeso(procedure.min_price) } - ${ formatPeso(procedure.max_price) }` : `${ formatPeso(procedure.min_price) }`}</p>
                </div>
                ${procedure.notes ? `<p class="italic">Note: ${ procedure.notes }</p>` : ''}
            </li>
        `).join('');
    }

    // Fill input on selection
    procedureDropdown.addEventListener('click', (e) => {
        const li = e.target.closest('li');
        if (!li) return;

        selectedProcedure = procedures.find(procedure => procedure.procedure_id === Number(li.dataset.id));

        searchInput.value = selectedProcedure.name;
        chargedPriceInput.value = selectedProcedure.min_price;
        procedureIdInput.value = selectedProcedure.procedure_id;
        ledgerDescriptionFormat.value = `Charge for ${selectedProcedure.name} - Appointment #${appointmentId}`
        procedureDropdown.classList.add('hidden');
    });

    // Show filtered dropdown
    searchInput.addEventListener('input', () => {
        const value = searchInput.value.trim().toLowerCase();
        if (!value) return;
        
        const filtered = procedures.filter(procedure => procedure.name.toLowerCase().includes(value));

        renderProcedures(filtered);
        procedureDropdown.classList.remove('hidden');
    });

    // Render dropdown when focused
    searchInput.addEventListener('focus', () => {
        renderProcedures(procedures);
        procedureDropdown.classList.remove('hidden');
    });

    document.addEventListener('DOMContentLoaded', async () => {
        procedures = await fetchProcedures();
    });

    document.addEventListener('click', (e) => {
        const procedureContainer = document.getElementById('procedure-container');
        if (!procedureContainer.contains(e.target)) procedureDropdown.classList.add('hidden');
    })
</script>
@endpush