@include('layouts.header')

<body>
@auth
    @include('layouts.navbar')
@endauth
<main class="">
    @yield('content')
</main>
</body>
