<div {{ $attributes->merge(['class' => 'alert alert-'.$theme.($dismissable ? ' alert-dismissible fade show' : '')]) }} role="alert">
    @isset($icon)<i class="{{ $icon }} me-1"></i>@endisset
    @isset($title)<h5 class="alert-heading d-inline">{{ $title }}</h5>@endisset
    {{ $slot }}
    @if ($dismissable)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
