import './patients-scroll';
import './patients-detail';

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('patient-search');
    let searchTimeout;

    if (!searchInput) return;

    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (window.PatientList && typeof window.PatientList.setSearch === 'function') {
                window.PatientList.setSearch(e.target.value);
            }
        }, 300);
    });
});
