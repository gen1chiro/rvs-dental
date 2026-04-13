window.showAppointmentDetail = async (id) => {
    const detailPanel = document.getElementById('detail-panel');
    const detailContent = document.getElementById('detail-content');
    const container = document.getElementById('appointment-container');
    const baseUrl = container ? container.getAttribute('data-url') : '';

    if (!detailPanel || !detailContent || !baseUrl) return;

    detailContent.innerHTML = '<div class="p-6 animate-pulse flex flex-col gap-4"><div class="h-4 bg-gray-200 rounded w-3/4"></div><div class="h-4 bg-gray-200 rounded w-1/2"></div></div>';

    // Open panel
    detailPanel.classList.remove('w-0', 'opacity-0');
    detailPanel.classList.add('w-full', 'md:w-5/12', 'lg:w-4/12', 'opacity-100');

    try {
        const response = await fetch(`${baseUrl}/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Failed to fetch details');

        const data = await response.json();

        detailContent.innerHTML = `
            <div class="flex flex-col h-full w-full bg-secondary bg-opacity-30 overflow-y-auto animate-fade-in-up">
                <div class="p-6 border-b border-edge">
                    <div class="flex justify-between items-start mb-2">
                        <h2 class="text-xl md:text-2xl font-black text-gray-900 uppercase leading-tight">
                            ${data.day_name || 'THU'} ${data.formatted_date || '23/03/25'} ${data.time || '14:00'}
                        </h2>
                        <button id="close-detail" class="text-danger hover:scale-110 transition-transform p-1">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm md:text-md font-medium text-gray-700">${data.patient_name} | ${data.dentist_name}</p>
                </div>

                <div class="divide-y divide-dotted divide-edge divide-opacity-50">
                    <div class="px-6 py-4">
                        <p class="text-base font-bold text-gray-900">${data.dentist_name}</p>
                        <p class="text-xs text-gray-900">Dentist</p>
                    </div>

                    <div class="px-6 py-4">
                        <p class="text-base font-bold text-gray-900">${data.procedure_type || 'Whitening'}</p>
                        <p class="text-xs text-gray-900">Procedure Type</p>
                    </div>

                    <div class="px-6 py-4">
                        <p class="text-base font-bold text-gray-900">${data.status}</p>
                        <p class="text-xs text-gray-900">Status</p>
                    </div>
                </div>

                <div class="px-6 py-6 border-t border-edge">
                    <p class="text-sm text-gray-900 leading-relaxed">
                        ${data.remarks || 'No specific remarks for this appointment.'}
                    </p>
                </div>

                <div class="px-6 py-6 border-t border-edge mt-auto">
                    <div class="flex gap-4 items-center">
                        <img
                            src="${data.patient_image_url}"
                            alt="Image of ${data.patient_name}"
                            class="w-16 h-16 md:w-20 md:h-20 bg-white border border-edge shrink-0 object-cover"
                        >
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 truncate">${data.patient_name}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-1 mt-1 text-[11px] text-gray-600">
                                <p class="truncate"><span class="font-semibold text-gray-900">Age:</span> ${data.age || '20'} y.o.</p>
                                <p class="truncate"><span class="font-semibold text-gray-900">P:</span> ${data.phone || '+65 123 456 7890'}</p>
                                <p class="truncate"><span class="font-semibold text-gray-900">DOB:</span> ${data.dob || 'May/14/2005'}</p>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-6 md:mt-8 bg-primary hover:bg-opacity-90 text-white py-3 md:py-4 px-6 rounded-sm font-bold text-sm flex items-center justify-center gap-2 transition-all">
                        VIEW FULL INFO <span class="text-lg">→</span>
                    </button>
                </div>
            </div>
        `;

        const closeDetail = () => {
            detailPanel.classList.add('w-0', 'opacity-0');
            detailPanel.classList.remove('w-full', 'md:w-5/12', 'lg:w-4/12', 'opacity-100');
        };

        document.getElementById('close-detail').addEventListener('click', closeDetail);

    } catch (error) {
        console.error('Error:', error);
        detailContent.innerHTML = '<p class="p-6 text-danger">Error loading details. Please try again.</p>';
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const list = document.getElementById('appointment-list');
    if (!list) return;

    list.addEventListener('click', (e) => {
        const item = e.target.closest('.appointment-item');
        if (item) {
            // Remove active class from all items
            list.querySelectorAll('.appointment-item').forEach(el => {
                el.classList.remove('active');
            });
            // Add active class to clicked item
            item.classList.add('active');

            const id = item.getAttribute('data-id');
            window.showAppointmentDetail(id);
        }
    });
});
