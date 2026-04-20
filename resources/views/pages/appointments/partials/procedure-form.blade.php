<x-forms.container 
    id="appointment-form"
    action="{{ route('appointment.procedure.store', $appointment) }}"
    method="POST"
    class="flex flex-col gap-6 bg-white p-8 rounded-3xl border border-gray-200 shadow-sm"
    data-appointment-id="{{ $appointment->appointment_id }}"
>
    <div id="procedure-container" class="relative">
        <div class="flex flex-col gap-2">
            <label for="procedure-search" class="font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Procedure</label>
            <input type="text" 
                id="procedure-search" 
                placeholder="Search procedures..." 
                autocomplete="off"
                class="w-full bg-gray-50 border border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl p-4 font-mono transition-all text-sm"
            >
        </div>
        <ul id="procedure-dropdown" class="hidden absolute z-10 w-full mt-2 bg-white border border-gray-200 rounded-xl shadow-xl max-h-60 overflow-y-auto divide-y divide-gray-100"></ul>
        <input type="hidden" name="procedure_id" id="procedure-id">
    </div>

    <div class="flex flex-col gap-2">
        <label for="charged-price" class="font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Charged Price</label>
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-mono text-sm">₱</span>
            <input type="number" 
                name="charged_price" 
                id="charged-price" 
                placeholder="0.00"
                class="w-full bg-gray-50 border border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl p-4 pl-8 font-mono transition-all text-sm"
            >
        </div>
        <p class="text-gray-400 text-[10px] font-mono leading-tight uppercase tracking-tight">
            Note: Auto-filled value is based on the minimum procedure price.
        </p>
    </div>

    <div class="flex flex-col gap-2">
        <label for="notes" class="font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Notes (Optional)</label>
        <textarea name="notes" 
            id="notes" 
            rows="3"
            placeholder="Enter additional notes here..."
            class="w-full bg-gray-50 border border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl p-4 font-mono transition-all resize-none text-sm"
        ></textarea>
    </div>

    <div class="flex flex-col gap-2">
        <label for="ledger-description" class="font-mono font-bold text-sm text-gray-800 uppercase tracking-tight">Ledger Description</label>
        <input name="ledger_description" 
            id="ledger-description" 
            readonly 
            class="w-full bg-gray-100 border border-gray-200 text-gray-500 rounded-xl p-4 font-mono text-[10px] cursor-not-allowed uppercase"
        />
    </div>

    <div class="pt-4">
        <x-ui.button
            type="submit"
            variant="primary"
            class="w-full py-4 rounded-xl text-lg font-bold transition-all shadow-lg shadow-primary/20 uppercase tracking-widest text-sm"
        >
            Add Procedure
        </x-ui.button>
    </div>
</x-forms.container>

@push('scripts')
<script>
    (function() {
        const form = document.getElementById('appointment-form');
        const searchInput = document.getElementById('procedure-search');
        const procedureDropdown = document.getElementById('procedure-dropdown');
        const chargedPriceInput = document.getElementById('charged-price');
        const procedureIdInput = document.getElementById('procedure-id');
        const ledgerDescriptionFormat = document.getElementById('ledger-description');

        if (!form || !searchInput || !procedureDropdown) return;

        let procedures = [];
        let selectedProcedure = null;
        const appointmentId = form.dataset.appointmentId;

        const fetchProcedures = async () => {
            try {
                const res = await fetch(`/procedures`);
                return await res.json();
            } catch (err) {
                console.error("Failed to fetch procedures", err);
                return [];
            }
        }

        const formatPeso = (amount) => `₱${amount}`;

        const renderProcedures = (filtered) => {
            if (filtered.length === 0) {
                procedureDropdown.innerHTML = `<li class="px-4 py-3 text-gray-500 font-mono text-xs italic">No procedures found</li>`;
                return;
            }

            procedureDropdown.innerHTML = filtered.map(procedure => `
                <li 
                    data-id="${procedure.procedure_id}" 
                    class="px-4 py-3 hover:bg-gray-50 cursor-pointer flex flex-col gap-1 transition-colors group"
                >
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-gray-900 group-hover:text-primary transition-colors text-sm">${ procedure.name }</p>
                        <p class="text-[10px] font-mono font-bold text-primary bg-primary/5 px-2 py-1 rounded-md">
                            ${ procedure.max_price ? `${formatPeso(procedure.min_price) } - ${ formatPeso(procedure.max_price) }` : `${ formatPeso(procedure.min_price) }`}
                        </p>
                    </div>
                    ${procedure.notes ? `<p class="text-[10px] text-gray-500 italic truncate font-mono">Note: ${ procedure.notes }</p>` : ''}
                </li>
            `).join('');
        }

        procedureDropdown.addEventListener('click', (e) => {
            const li = e.target.closest('li');
            if (!li) return;

            selectedProcedure = procedures.find(p => p.procedure_id === Number(li.dataset.id));
            if (!selectedProcedure) return;

            searchInput.value = selectedProcedure.name;
            chargedPriceInput.value = selectedProcedure.min_price;
            procedureIdInput.value = selectedProcedure.procedure_id;
            ledgerDescriptionFormat.value = `Charge for ${selectedProcedure.name} - Appt #${appointmentId}`;
            procedureDropdown.classList.add('hidden');
        });

        searchInput.addEventListener('input', () => {
            const value = searchInput.value.trim().toLowerCase();
            if (!value) {
                procedureDropdown.classList.add('hidden');
                return;
            }
            
            const filtered = procedures.filter(p => p.name.toLowerCase().includes(value));
            renderProcedures(filtered);
            procedureDropdown.classList.remove('hidden');
        });

        searchInput.addEventListener('focus', () => {
            if (procedures.length > 0) {
                renderProcedures(procedures);
                procedureDropdown.classList.remove('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', async () => {
            procedures = await fetchProcedures();
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !procedureDropdown.contains(e.target)) {
                procedureDropdown.classList.add('hidden');
            }
        });
    })();
</script>
@endpush
