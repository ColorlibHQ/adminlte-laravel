<button type="{{ $type }}" {{ $attributes->merge(['class' => $buttonClass()]) }}>
    @isset($icon)<i class="{{ $icon }} {{ ($label || trim($slot)) ? 'me-1' : '' }}"></i>@endisset
    {{ $label }}{{ $slot }}
</button>
