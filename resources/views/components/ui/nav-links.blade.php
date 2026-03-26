@props(['url' => '', 'name' => ''])

<a href="{{ url($url) }}" class="">
    {{ $name }}
</a>