<header class="flex w-full justify-between">
    <div>
        <p>Logo</p>
    </div>
    <nav class="flex gap-4 items-center">
        @foreach (config('navigation.links') as $link)
            @php $link = (object) $link; @endphp
            <x-ui.nav-links :name="$link->name" :url="$link->url" />
        @endforeach
        <x-forms.container 
            action="{{ route('logout') }}"
            method="POST"
        >
            <x-ui.button type="submit" variant="primary" class="">
                LOG OUT
            </x-ui.button>
        </x-forms.container>
</nav>
</header>