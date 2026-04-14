window.PatientList = (() => {
    const container = document.getElementById('patient-container');
    const list = document.getElementById('patient-list');
    const trigger = document.getElementById('infinite-scroll-trigger');

    if (!container || !list || !trigger) return {};

    const baseUrl = container.getAttribute('data-url');
    let page = 1;
    let isLoading = false;
    let hasMore = true;
    let currentSearch = '';

    const loadMore = async (reset = false) => {
        if (!reset && (isLoading || !hasMore)) return;

        isLoading = true;

        if (reset) {
            page = 1;
            hasMore = true;

            list.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            await new Promise((resolve) => setTimeout(resolve, 300));

            list.innerHTML = '<div class="p-6 text-center animate-pulse text-muted">Loading patients...</div>';
            list.classList.remove('opacity-0');

            trigger.innerHTML = '<div class="animate-pulse text-muted text-sm">Loading...</div>';
            trigger.style.display = 'block';
        } else {
            page++;
        }

        try {
            const url = new URL(baseUrl, window.location.origin);
            url.searchParams.set('page', page);
            if (currentSearch) url.searchParams.set('search', currentSearch);

            const response = await fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                },
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

                if (reset) {
                    list.innerHTML = '<div class="p-12 text-center text-muted"><p class="text-lg">No patients found matching your search.</p></div>';
                    trigger.style.display = 'none';
                } else {
                    trigger.innerHTML = '<span class="text-sm italic text-muted">No more patients.</span>';
                }

                return;
            }

            list.insertAdjacentHTML('beforeend', trimmed);

            if (!serverHasMore) {
                hasMore = false;
                trigger.innerHTML = '<span class="text-sm italic text-muted">No more patients.</span>';
            } else {
                trigger.innerHTML = '<div class="animate-pulse text-muted text-sm">Loading...</div>';
                trigger.style.display = 'block';
            }
        } catch (error) {
            console.error('Error fetching patients:', error);
            trigger.innerHTML = '<button onclick="window.PatientList.retry()" class="text-danger text-sm underline">Error loading. Click to retry.</button>';
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
        rootMargin: '150px',
    });

    observer.observe(trigger);

    return {
        setSearch: (search) => {
            currentSearch = search;
            loadMore(true);
        },
        retry: () => {
            loadMore();
        },
    };
})();
