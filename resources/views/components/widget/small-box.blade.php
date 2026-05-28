<div {{ $attributes->merge(['class' => 'small-box text-bg-'.$theme]) }}>
    <div class="inner">
        <h3>{{ $title }}</h3>
        @if ($text)<p>{{ $text }}</p>@endif
        {{ $slot }}
    </div>
    @isset($icon)
        <i class="small-box-icon {{ $icon }}" aria-hidden="true"></i>
    @endisset
    @isset($url)
        <a href="{{ $url }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
            {{ $urlText }} <i class="bi bi-link-45deg"></i>
        </a>
    @endisset
</div>
