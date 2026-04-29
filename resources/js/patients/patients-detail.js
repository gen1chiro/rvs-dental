document.addEventListener('DOMContentLoaded', () => {
    const list = document.getElementById('patient-list');
    const patientInfo = document.getElementById('patient-info');

    if (!list || !patientInfo) return;

    const formatDate = (dateStr) => {
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', {
            month: 'long',
            day: '2-digit',
            year: 'numeric',
        });
    };

    list.addEventListener('click', async (e) => {
        const row = e.target.closest('.patient-row');
        if (!row) return;

        list.querySelectorAll('.patient-row').forEach((item) => item.classList.remove('active'));
        row.classList.add('active');

        patientInfo.classList.remove('items-center', 'justify-center');
        patientInfo.classList.add('bg-secondary', 'flex-col');

        const patientId = row.dataset.patientId;
        const {
            age,
            first_name,
            last_name,
            address,
            contact_no,
            image_url,
            date_of_birth,
            occupation,
            marital_status,
            guardian_name,
            sex,
        } = JSON.parse(row.dataset.patient);

        console.log(row.dataset.patient);

        const summaryResponse = await fetch(`/patients/${patientId}/summary`);
        const summary = await summaryResponse.json();

        patientInfo.innerHTML = `
            <div class="flex-1 overflow-auto">
                <p class="font-bold text-3xl p-4 border-b border-border">
                    <span>${first_name}</span>
                    <span>${last_name}</span>
                </p>
                <div class="flex flex-col gap-4 p-4 border-b border-border">
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col gap-2">
                            <p class="font-bold text-xl">Basic Information</p>
                            <p class="text-xs">Age: ${age}</p>
                            <p class="text-xs">Sex: ${sex}</p>
                            <p class="text-xs">DOB: ${formatDate(date_of_birth)}</p>
                        </div>
                        <img
                            src="${image_url}"
                            alt="Image of ${first_name} ${last_name}"
                            class="w-25 bg-white aspect-square object-cover"
                        >
                    </div>
                    <div class="text-xs flex flex-col gap-2">
                        <p>Address: ${address}</p>
                        <p>Occupation: ${occupation}</p>
                        <p>Parent/Guardian Name: ${guardian_name ?? 'N/A'}</p>
                        <p>Contact No: ${contact_no}</p>
                        <p>Civil Status: ${marital_status}</p>
                    </div>
                </div>
                <div class="p-4 flex flex-col gap-4">
                    <p class="font-bold text-xl">Appointments & Transactions</p>
                    <div class="flex gap-8">
                        <div class="flex flex-col gap-4">
                            <div>
                                <p class="text-2xl font-bold">${summary.last_appointment}</p>
                                <p class="text-xs">Last Completed Appointment</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold">${summary.next_appointment}</p>
                                <p class="text-xs">Next Appointment</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div>
                                <p class="text-2xl font-bold">₱${Number(summary.deficiency).toLocaleString(undefined, { minimumFractionDigits: 2 })}</p>
                                <p class="text-xs">Deficiency</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold">₱${Number(summary.total_payment).toLocaleString(undefined, { minimumFractionDigits: 2 })}</p>
                                <p class="text-xs">Total Payments</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/patients/${patientId}" class="hover:cursor-pointer inline-flex items-center justify-center px-4 py-4 font-sans text-sm transition-colors duration-200 bg-primary text-white hover:bg-primary/90 w-full shrink-0">
                VIEW FULL INFO →
            </a>
        `;
    });
});
