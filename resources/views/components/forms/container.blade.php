<form {{ $attributes->merge(['class' => '']) }}>
    @csrf
    {{ $slot }}
</form>
