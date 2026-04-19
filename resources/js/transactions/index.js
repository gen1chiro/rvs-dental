document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('transaction-container');
    const list = document.getElementById('transaction-list');
    const trigger = document.getElementById('infinite-scroll-trigger');
    const detailContainer = document.getElementById('transaction-detail-content');
    const searchInput = document.getElementById('transaction-search');
    const sortBtn = document.getElementById('transaction-sort-btn');
    const sortIcon = document.getElementById('transaction-sort-icon');
    const dateFilter = document.getElementById('transaction-date-filter');
    const statusFilter = document.getElementById('transaction-status-filter');

    if (!container || !list || !trigger || !detailContainer) return;

    const baseUrl = container.getAttribute('data-url');
    let page = 1;
    let isLoading = false;
    let hasMore = trigger.dataset.hasMore === '0' ? false : true;
    let sortOrder = 'desc';
    let searchTimeout;

    const updateTransactions = async (reset = true) => {
        if (isLoading) return;
        if (!reset && !hasMore) return;

        isLoading = true;
        if (reset) {
            page = 1;
            hasMore = true;
            list.innerHTML = '';
            list.appendChild(trigger);
            trigger.innerHTML = '<div class="animate-pulse text-muted text-sm">Loading transactions...</div>';
            trigger.classList.remove('hidden');
        } else {
            page++;
        }

        try {
            const url = new URL(baseUrl, window.location.origin);
            url.searchParams.set('page', page);
            url.searchParams.set('sort', sortOrder);
            
            if (searchInput && searchInput.value) {
                url.searchParams.set('search', searchInput.value);
            }
            if (dateFilter && dateFilter.value) {
                url.searchParams.set('date', dateFilter.value);
            }
            if (statusFilter && statusFilter.value) {
                url.searchParams.set('status', statusFilter.value);
            }

            const response = await fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const html = await response.text();
            const trimmed = html.trim();
            const serverHasMore = response.headers.get('X-Has-More') === '1';

            if (trimmed) {
                trigger.insertAdjacentHTML('beforebegin', trimmed);
            }

            hasMore = serverHasMore;
            if (!hasMore) {
                trigger.innerHTML = '<span class="text-sm italic text-muted">No more transactions.</span>';
            } else {
                trigger.innerHTML = '<div class="animate-pulse text-muted text-sm">Loading more transactions...</div>';
            }

            if (reset && !trimmed) {
                list.innerHTML = '<div class="p-10 text-center text-muted italic">No transactions found.</div>';
                list.appendChild(trigger);
                trigger.classList.add('hidden');
            }

        } catch (error) {
            console.error("Error fetching transactions:", error);
            trigger.innerHTML = '<button id="retry-transactions" class="text-danger text-sm underline">Error loading. Click to retry.</button>';
            document.getElementById('retry-transactions')?.addEventListener('click', () => updateTransactions(false));
        } finally {
            isLoading = false;
        }
    };

    // --- Row Selection Logic (Event Delegation) ---
    list.addEventListener('click', function(e) {
        const row = e.target.closest('.transaction-row');
        if (!row) return;

        const transactionId = row.dataset.transactionId;
        
        list.querySelectorAll('.transaction-row').forEach(r => r.classList.remove('active'));
        row.classList.add('active');

        detailContainer.innerHTML = '<div class="h-full flex items-center justify-center p-8 text-center"><div class="animate-pulse text-primary uppercase tracking-widest text-sm">Loading details...</div></div>';
        detailContainer.classList.add('items-center', 'justify-center');
        detailContainer.classList.remove('items-start', 'justify-start', 'text-center');

        fetch(`/transactions/${transactionId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            detailContainer.innerHTML = html;
            detailContainer.classList.remove('items-center', 'justify-center', 'text-center');
            detailContainer.classList.add('items-start', 'justify-start');

            const closeBtn = document.getElementById('close-transaction-detail');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    detailContainer.innerHTML = `
                        <div class="p-8">
                            <p class="font-mono text-primary uppercase tracking-widest text-sm">
                                Click on transaction<br>to display info
                            </p>
                        </div>
                    `;
                    detailContainer.classList.add('items-center', 'justify-center', 'text-center');
                    detailContainer.classList.remove('items-start', 'justify-start');
                    list.querySelectorAll('.transaction-row').forEach(r => r.classList.remove('active'));
                });
            }
        })
        .catch(error => {
            console.error('Error fetching transaction details:', error);
            detailContainer.innerHTML = '<p class="text-danger p-8">Error loading details.</p>';
        });
    });

    // --- Search Logic ---
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => updateTransactions(true), 300);
        });
    }

    // --- Sort Logic ---
    if (sortBtn && sortIcon) {
        sortBtn.addEventListener('click', () => {
            sortOrder = sortOrder === 'desc' ? 'asc' : 'desc';
            if (sortOrder === 'asc') {
                sortIcon.classList.remove('rotate-180');
            } else {
                sortIcon.classList.add('rotate-180');
            }
            updateTransactions(true);
        });
    }

    // --- Date Filter Logic ---
    if (dateFilter) {
        dateFilter.addEventListener('change', () => updateTransactions(true));
    }

    // --- Status Filter Logic ---
    if (statusFilter) {
        statusFilter.addEventListener('change', () => updateTransactions(true));
    }

    // --- Infinite Scroll Logic ---
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && hasMore && !isLoading) {
            updateTransactions(false);
        }
    }, {
        root: list,
        threshold: 0.1,
        rootMargin: '100px'
    });

    observer.observe(trigger);
});
