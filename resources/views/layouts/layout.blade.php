@include('layouts.header')

<body class="h-dvh flex flex-col">
@auth
    @include('layouts.navbar')
@endauth

<main class="flex-1 flex flex-col min-h-0">
    @yield('content')
</main>

@stack('scripts')
</body>

