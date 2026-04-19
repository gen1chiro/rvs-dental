<div id="tab-procedures" class="tab-panel hidden">
    <div class="w-full bg-secondary p-5 rounded-t-xl border-b border-border flex justify-between items-center">
        <p class="font-bold text-2xl md:text-3xl">Procedure Images</p>
        <div class="text-xs flex flex-col items-end text-right">
            <p>LAST UPDATED</p>
            <p>{{ $patient->appointments()->latest('scheduled_at')->value('scheduled_at')?->format('M d, Y') ?? '—' }}</p>
        </div>
    </div>
        {{-- Hint bar --}}
    <div class="px-5 pt-4">
        <p class="text-xs text-muted-foreground bg-secondary border border-border rounded-lg px-3 py-2">
            Double-click to open folder
        </p>
    </div>

    {{-- Folder grid --}}
    @if ($folders->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-muted-foreground">
            <svg width="48" height="48" viewBox="0 0 40 32" fill="none" class="mb-3 opacity-30">
                <rect x="0" y="8" width="40" height="22" rx="3" fill="#EF9F27"/>
                <rect x="0" y="6" width="18" height="6" rx="2" fill="#FAC775"/>
                <rect x="0" y="10" width="40" height="20" rx="3" fill="#EF9F27" opacity="0.85"/>
            </svg>
            <p class="text-sm">No procedure files found</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 p-5" id="folder-grid">
            @foreach ($folders as $folder)
                <div 
                    class="folder-card border border-border rounded-xl p-3 cursor-pointer select-none transition-colors hover:bg-secondary"
                    data-folder-info="{{ json_encode($folder)}}"
                >

                    {{-- Folder icon --}}
                    <svg class="folder-svg w-10 h-8 mb-2" viewBox="0 0 40 32" fill="none">
                        <rect x="0" y="8" width="40" height="22" rx="3" class="folder-front" fill="#888780"/>
                        <rect x="0" y="6" width="18" height="6" rx="2" class="folder-back" fill="#B4B2A9"/>
                        <rect x="0" y="10" width="40" height="20" rx="3" class="folder-front" fill="#888780" opacity="0.85"/>
                    </svg>

                    <p class="folder-name text-sm font-medium truncate">{{ $folder['label'] }}</p>
                    <p class="folder-meta text-xs text-muted-foreground truncate mt-0.5">
                        {{ $folder['date'] }} | {{ $folder['slot'] }}
                    </p>
                    <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-xs border
                        {{ $folder['status'] === 'completed'
                            ? 'bg-green-50 text-green-700 border-green-200'
                            : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                        {{ $folder['status'] }}
                    </span>
                </div>
            @endforeach
        </div>

        {{-- Inline expand area --}}
        <div id="expand-area" class="hidden mx-5 mb-5 border border-border rounded-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-2.5 bg-secondary border-b border-border">
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                    </svg>
                    <span class="text-sm font-medium" id="expand-title"></span>
                    <span class="text-xs text-muted-foreground" id="expand-count"></span>
                </div>
                <button id="close-expand" class="text-muted-foreground hover:text-foreground text-lg leading-none px-1">✕</button>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 p-3" id="img-grid"></div>
        </div>
    @endif
</div>


@push('scripts')
<script>
(() => {
    let activeId = null, clickTimer = null;

    const setActiveId = (id) => {
        document.querySelectorAll('.folder-card').forEach(el => {
            const isThis = el.dataset.id == id;
            el.classList.toggle('border-blue-400', isThis);
            el.classList.toggle('bg-blue-50', isThis);
            el.querySelectorAll('.folder-front').forEach(r => r.setAttribute('fill', isThis ? '#378ADD' : '#888780'));
            el.querySelectorAll('.folder-back').forEach(r => r.setAttribute('fill', isThis ? '#85B7EB' : '#B4B2A9'));
            activeId = id;
        })
    }

    const openFolder = (folder) => {
        const { label, slot, files } = JSON.parse(folder.dataset.folderInfo);
        const images = files.filter(f => /\.(jpg|jpeg|png)$/i.test(f.name));
        const grid = document.getElementById('img-grid');
        const area = document.getElementById('expand-area');

        document.getElementById('expand-title').textContent = `${label} · ${slot}`;
        document.getElementById('expand-count').textContent = images.length ? `${images.length} image(s)` : '';

        grid.innerHTML = images.length
            ? images.map(f => `
                <div class="border border-gray-200 rounded-lg overflow-hidden cursor-pointer hover:border-gray-300 transition-colors" onclick="window.open('${f.url}', '_blank')">
                    <div class="aspect-square"><img src="${f.url}" alt="${f.name}" class="w-full h-full object-cover" loading="lazy"/></div>
                    <p class="text-xs text-gray-500 px-2 py-1.5 truncate border-t border-gray-100 bg-white">${f.name}</p>
                </div>`).join('')
            : '<p class="col-span-full text-center text-sm text-gray-400 py-8">No images found for this appointment.</p>';

        area.classList.remove('hidden');
        setTimeout(() => area.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 50);
    }

    const reset = () => {
        document.querySelectorAll('.folder-card').forEach(el => {
            el.classList.remove('border-blue-400', 'bg-blue-50');
            el.querySelectorAll('.folder-front').forEach(r => r.setAttribute('fill', '#888780'));
            el.querySelectorAll('.folder-back').forEach(r => r.setAttribute('fill', '#B4B2A9'));
        });
        activeId = null;
    }

    document.querySelectorAll('.folder-card').forEach(folder => {
        folder.addEventListener('click', () => {
            if (clickTimer) {
                clearTimeout(clickTimer);
                clickTimer = null;
                return;
            }
            clickTimer = setTimeout(() => {
                clickTimer = null;
                activeId == folder.dataset.folderInfo ? reset() : setActiveId(JSON.parse(folder.dataset.folderInfo).id);
            }, 200)
        });

        folder.addEventListener('dblclick', () => {
            if (clickTimer) {
                clearTimeout(clickTimer);
                clickTimer = null;
            }

            setActiveId(JSON.parse(folder.dataset.folderInfo).id);
            openFolder(folder);
        })
    });

    document.getElementById('close-expand').addEventListener('click', () => {
        document.getElementById('expand-area').classList.add('hidden');
        reset();
    });
})();
</script>
@endpush