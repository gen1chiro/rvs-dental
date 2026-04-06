window.AppointmentList = (() => {
    const container = document.getElementById('appointment-container');
    const list = document.getElementById('appointment-list');
    const trigger = document.getElementById('infinite-scroll-trigger');

    if (!container || !trigger) return {};

    const baseUrl = container.getAttribute('data-url');
    let page = 1;
    let isLoading = false;
    let hasMore = true;
    let currentSort = 'asc';
    let currentSearch = '';
    let currentDate = '';

    const loadMore = async (reset = false) => {
        if (!reset && (isLoading || !hasMore)) return;

        isLoading = true;
        if (reset) {
            page = 1;
            hasMore = true;
            
            // Start fade out
            list.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            
            // Wait for fade out
            await new Promise(r => setTimeout(r, 300));

            list.innerHTML = '<div class="p-6 text-center animate-pulse text-muted">Loading appointments...</div>';
            list.classList.remove('opacity-0');

            trigger.innerHTML = '<div class="animate-pulse text-muted text-sm">Loading...</div>';
            trigger.style.display = 'block';
        } else {
            page++;
        }

        try {
            const url = new URL(baseUrl);
            url.searchParams.set('page', page);
            url.searchParams.set('sort', currentSort);
            if (currentSearch) url.searchParams.set('search', currentSearch);
            if (currentDate) url.searchParams.set('date', currentDate);

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

            if (reset) {
                list.innerHTML = '';
            }

            if (response.status === 204 || !trimmed) {
                hasMore = false;
                if (reset && !trimmed) {
                    list.innerHTML = '<div class="p-12 text-center text-muted"><p class="text-lg">No appointments found matching your search.</p></div>';
                    trigger.style.display = 'none';
                } else {
                    trigger.innerHTML = '<span class="text-sm italic text-muted">No more appointments.</span>';
                }
                return;
            }

            list.insertAdjacentHTML('beforeend', trimmed);
            
            // Check if server said no more
            if (!serverHasMore) {
                hasMore = false;
                trigger.innerHTML = '<span class="text-sm italic text-muted">No more appointments.</span>';
            } else {
                trigger.innerHTML = '<div class="animate-pulse text-muted text-sm">Loading...</div>';
                trigger.style.display = 'block';
            }

        } catch (error) {
            console.error("Error fetching appointments:", error);
            trigger.innerHTML = '<button onclick="window.AppointmentList.retry()" class="text-danger text-sm underline">Error loading. Click to retry.</button>';
        } finally {
            isLoading = false;
        }
    };

    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && hasMore && !isLoading) {
            loadMore();
        }
    }, {
        root: container,
        threshold: 0.1,
        rootMargin: '150px'
    });

    observer.observe(trigger);

    return {
        setSort: (sort) => {
            currentSort = sort;
            loadMore(true);
        },
        setSearch: (search) => {
            currentSearch = search;
            loadMore(true);
        },
        setDate: (date) => {
            currentDate = date;
            loadMore(true);
        },
        retry: () => {
            loadMore();
        }
    };
})();
