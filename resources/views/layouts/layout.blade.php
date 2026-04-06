@include('layouts.header')

<body class="h-dvh flex flex-col">
@auth
    @hasSection('hideNavbar')
    @else
        @include('layouts.navbar')
    @endif
@endauth

<main class="flex-1 flex flex-col min-h-0">
    @yield('content')
</main>

@stack('scripts')
</body>

