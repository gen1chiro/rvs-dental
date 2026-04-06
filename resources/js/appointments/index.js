import './appointments-scroll';
import './appointments-detail';

document.addEventListener('DOMContentLoaded', () => {
    const sortBtn = document.getElementById('date-sort-btn');
    const sortIcon = document.getElementById('date-sort-icon');
    const searchInput = document.getElementById('appointment-search');
    let sortOrder = 'asc';
    let searchTimeout;

    if (sortBtn && sortIcon) {
        sortBtn.addEventListener('click', () => {
            sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
            
            // Toggle icon flip
            if (sortOrder === 'desc') {
                sortIcon.classList.add('rotate-180');
            } else {
                sortIcon.classList.remove('rotate-180');
            }

            // Trigger list update
            if (window.AppointmentList && typeof window.AppointmentList.setSort === 'function') {
                window.AppointmentList.setSort(sortOrder);
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (window.AppointmentList && typeof window.AppointmentList.setSearch === 'function') {
                    window.AppointmentList.setSearch(e.target.value);
                }
            }, 300);
        });
    }

    const dateFilterInput = document.getElementById('date-filter-input');

    if (dateFilterInput) {
        dateFilterInput.addEventListener('change', (e) => {
            const val = e.target.value; // YYYY-MM-DD
            if (window.AppointmentList && typeof window.AppointmentList.setDate === 'function') {
                window.AppointmentList.setDate(val);
            }
        });
    }
});
