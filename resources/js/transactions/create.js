const ledgerTbl = document.getElementById('ledger-info-table');
const transactionTbl = document.getElementById('transaction-info-table');
const totalChargedEl = document.getElementById('total-charged');
const totalPaidEl = document.getElementById('total-paid');
const remainingBalanceEl = document.getElementById('remaining-balance');
const creditAmountInput = document.getElementById('credit-amount');
const payFullBtn = document.getElementById('pay-full-btn');
const ledgerSelector = document.getElementById('ledger-selector');

let currentProcedures = [];

const getStatusClass = (status) => {
    switch (status) {
        case 'Scheduled': return 'bg-amber-50 text-amber-700 border-amber-200';
        case 'Completed': return 'bg-green-50 text-green-700 border-green-200';
        case 'Cancelled':
        case 'No Show': return 'bg-rose-50 text-rose-700 border-rose-200';
        default: return 'bg-gray-50 text-gray-700 border-gray-200';
    }
}

const updateTotals = (procedure) => {
    if (!procedure) {
        totalChargedEl.textContent = '₱0.00';
        totalPaidEl.textContent = '₱0.00';
        remainingBalanceEl.textContent = '₱0.00';
        ledgerSelector.value = '';
        return;
    }

    const totalCharged = Number(procedure.charged_price);
    const totalPaid = procedure.transactions.reduce((sum, tx) => sum + Number(tx.credit || 0), 0);
    const remainingBalance = totalCharged - totalPaid;

    totalChargedEl.textContent = `₱${totalCharged.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    totalPaidEl.textContent = `₱${totalPaid.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    remainingBalanceEl.textContent = `₱${remainingBalance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    
    ledgerSelector.value = procedure.ledger_id;

    payFullBtn.onclick = () => {
        creditAmountInput.value = remainingBalance.toFixed(2);
    };
}

const selectAppointment = async (id) => {
    const res = await fetch(`/appointments/${id}/full`);
    const appointmentDetails = await res.json();
    if (!appointmentDetails) {
        console.log('No appointment details found.');
        return;
    }

    currentProcedures = appointmentDetails.procedures;
    const transactions = currentProcedures.flatMap(p => p.transactions);

    // Populate Ledger Selector
    ledgerSelector.innerHTML = '<option value="" disabled selected>Choose procedure</option>' + 
        currentProcedures.map(p => `<option value="${p.ledger_id}">${p.procedure_name} (#${p.ledger_id})</option>`).join('');

    renderLedger(currentProcedures);
    renderTransactions(transactions);

    // Auto-select first procedure if available
    if (currentProcedures.length > 0) {
        ledgerSelector.value = currentProcedures[0].ledger_id;
        updateTotals(currentProcedures[0]);
    } else {
        updateTotals(null);
    }
}

ledgerSelector.addEventListener('change', (e) => {
    const selectedId = e.target.value;
    const procedure = currentProcedures.find(p => p.ledger_id == selectedId);
    updateTotals(procedure);
});

const renderLedger = (entries) => {
    ledgerTbl.innerHTML = entries.length
        ? entries.map(entry => `
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="py-4 text-sm font-bold text-gray-900">${entry.procedure_name}</td>
            <td class="py-4 text-xs text-gray-500 font-mono tracking-tighter">#${entry.ledger_id}</td>
            <td class="py-4 text-sm font-mono font-bold text-gray-900 text-right tracking-tight">₱${Number(entry.charged_price).toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
        </tr>        
    `).join('')
        : `
        <tr>
            <td colspan="3" class="text-center py-12">
                <p class="text-gray-400 font-mono italic text-xs uppercase tracking-widest">No ledger entries yet.</p>
            </td>
        </tr>
    `;
}

const renderTransactions = (transactions) => {
    transactionTbl.innerHTML = transactions.length
        ? transactions.map(tx => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="py-4 text-xs text-gray-700 font-mono uppercase tracking-tight font-bold">Payment on ${tx.created_at}</td>
                <td class="py-4">
                    <span class="px-2 py-0.5 rounded text-[9px] font-mono font-bold uppercase tracking-widest bg-secondary/30 text-primary border border-primary/10">
                        ${tx.mode_of_payment || 'CASH'}
                    </span>
                </td>
                <td class="py-4 text-sm text-rose-500 text-right font-mono font-bold tracking-tight">${tx.debit ? '₱' + Number(tx.debit).toLocaleString(undefined, { minimumFractionDigits: 2 }) : '—'}</td>
                <td class="py-4 text-sm text-green-600 text-right font-mono font-bold tracking-tight">${tx.credit ? '₱' + Number(tx.credit).toLocaleString(undefined, { minimumFractionDigits: 2 }) : '—'}</td>
                <td class="py-4 text-sm text-gray-900 text-right font-mono font-bold tracking-tight">₱${Number(tx.balance).toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
            </tr>      
        `).join('')
        : `
            <tr>
                <td colspan="5" class="text-center py-12">
                    <p class="text-gray-400 font-mono italic text-xs uppercase tracking-widest">No transactions yet.</p>
                </td>
            </tr>
        `;
}

document.addEventListener('patientSelected', async (e) => {
    const patient = e.detail;

    const patientInfoContainer = document.getElementById('patient-info-container');
    if (!patientInfoContainer) return;

    patientInfoContainer.innerHTML = `
        <div class="flex gap-4 items-center bg-secondary bg-opacity-10 p-4 rounded-2xl border border-primary/10 animate-fade-in-up">
            <img 
                src="${patient.image_url}" 
                alt="Image of ${patient.full_name}"
                class="w-16 h-16 bg-white border border-edge shrink-0 object-cover rounded-xl shadow-sm"
            >
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-mono font-bold text-gray-800 truncate uppercase tracking-tight">${patient.full_name}</h3>
                <div class="flex flex-col gap-0.5 mt-1">
                    <p class="text-[10px] font-mono text-gray-500 uppercase tracking-widest leading-none">
                        <span class="font-bold text-gray-700">Age:</span> ${patient.age} Y.O.
                    </p>
                    <p class="text-[10px] font-mono text-gray-500 uppercase tracking-widest leading-none">
                        <span class="font-bold text-gray-700">Phone:</span> ${patient.contact_no}
                    </p>
                </div>
            </div>
        </div>
    `;

    const appointmentContainer = document.getElementById('appointment-container');
    if (!appointmentContainer) return;

    appointmentContainer.innerHTML = `
        <div class="flex items-center gap-3 p-4 text-muted animate-pulse">
            <div class="w-2 h-2 rounded-full bg-primary/40"></div>
            <p class="text-xs font-mono font-bold uppercase tracking-widest">Loading appointments...</p>
        </div>
    `;

    try {
        const res = await fetch(`/patients/${patient.patient_id}/appointments`);
        const appointments = await res.json();
        
        if (appointments.length === 0) {
            appointmentContainer.innerHTML = `
                <div class="p-8 border border-dashed border-gray-300 rounded-2xl text-center bg-gray-50/50">
                    <p class="text-xs text-gray-400 font-mono italic uppercase tracking-widest">No appointments found.</p>
                </div>
            `;
            return;
        }

        appointmentContainer.innerHTML = appointments.map(appointment => `
            <div 
                class="appointment-card cursor-pointer p-4 rounded-2xl border border-edge bg-white hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 transition-all group animate-fade-in-up"
                data-appointment-id="${appointment.appointment_id}"
            >
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="text-sm font-mono font-bold text-gray-800 group-hover:text-primary transition-colors uppercase tracking-tight">
                            ${new Date(appointment.scheduled_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                        </p>
                        <p class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest mt-0.5">${appointment.slot}</p>
                    </div>
                    <span class="text-[9px] px-2 py-0.5 rounded border font-mono font-bold uppercase tracking-widest ${getStatusClass(appointment.status)}">
                        ${appointment.status}
                    </span>
                </div>
                <div class="pt-3 border-t border-gray-100">
                    <p class="text-[9px] font-mono font-bold text-gray-400 uppercase tracking-widest mb-1">Dentist</p>
                    <p class="text-xs font-mono font-bold text-gray-700 uppercase tracking-tight">Dr. ${appointment.dentist.first_name} ${appointment.dentist.last_name}</p>
                </div>
            </div>
        `).join('');

        document.querySelectorAll('.appointment-card').forEach(el => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.appointment-card').forEach(card => {
                    card.classList.remove('border-primary/50', 'bg-primary/5', 'ring-1', 'ring-primary/20', 'shadow-lg', 'shadow-primary/5');
                });
                el.classList.add('border-primary/50', 'bg-primary/5', 'ring-1', 'ring-primary/20', 'shadow-lg', 'shadow-primary/5');
                
                const id = el.dataset.appointmentId;
                selectAppointment(id);
            })
        });
        
    } catch (err) {
        console.error(err);
        appointmentContainer.innerHTML = `
            <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl">
                <p class="text-xs text-rose-500 font-mono font-bold uppercase tracking-widest">Failed to load appointments.</p>
            </div>
        `;
    }
})