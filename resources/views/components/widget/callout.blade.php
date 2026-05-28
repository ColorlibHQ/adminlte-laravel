<div {{ $attributes->merge(['class' => 'callout callout-'.$theme]) }}>
    @isset($title)
        <h5>@isset($icon)<i class="{{ $icon }} me-1"></i>@endisset{{ $title }}</h5>
    @endisset
    {{ $slot }}
</div>
