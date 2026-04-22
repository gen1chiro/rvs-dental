document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    if (!tabButtons.length || !tabPanels.length) return;

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                const bg = btn.querySelector('.tab-bg');
                if (bg) {
                    bg.setAttribute('fill', 'transparent');
                }
                const icon = btn.querySelector('.tab-icon');
                if (icon) {
                    icon.setAttribute('fill', '#006A6A');
                }
            });

            this.classList.add('active');
            const activeBg = this.querySelector('.tab-bg');
            if (activeBg) {
                activeBg.setAttribute('fill', '#006A6A');
            }
            const activeIcon = this.querySelector('.tab-icon');
            if (activeIcon) {
                activeIcon.setAttribute('fill', 'white');
            }

            tabPanels.forEach(panel => {
                panel.classList.add('hidden');
            });

            const targetPanel = document.getElementById(`tab-${targetTab}`);
            if (targetPanel) {
                targetPanel.classList.remove('hidden');
            }
        });
    });

    const patientInfo = document.getElementById('patient-info');
    const patientId = patientInfo?.dataset.patientId;

    if (!patientId) return;

    const lastAppointmentValue = document.getElementById('last-appointment-value');
    const nextAppointmentValue = document.getElementById('next-appointment-value');
    const deficiencyValue = document.getElementById('deficiency-value');
    const totalPaymentValue = document.getElementById('total-payment-value');

    fetch(`/patients/${patientId}/summary`)
        .then((response) => response.json())
        .then((summary) => {
            if (lastAppointmentValue) {
                lastAppointmentValue.textContent = summary.last_appointment ?? 'N/A';
            }

            if (nextAppointmentValue) {
                nextAppointmentValue.textContent = summary.next_appointment ?? 'N/A';
            }

            if (deficiencyValue) {
                deficiencyValue.textContent = `₱${Number(summary.deficiency).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
            }

            if (totalPaymentValue) {
                totalPaymentValue.textContent = `₱${Number(summary.total_payment).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
            }
        })
        .catch(() => {
            if (lastAppointmentValue) {
                lastAppointmentValue.textContent = 'N/A';
            }

            if (nextAppointmentValue) {
                nextAppointmentValue.textContent = 'N/A';
            }

            if (deficiencyValue) {
                deficiencyValue.textContent = '₱0.00';
            }

            if (totalPaymentValue) {
                totalPaymentValue.textContent = '₱0.00';
            }
        });
});
