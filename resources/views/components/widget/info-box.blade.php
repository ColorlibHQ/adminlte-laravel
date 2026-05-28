<div {{ $attributes->merge(['class' => 'info-box']) }}>
    <span class="{{ $iconClass() }}">
        <i class="{{ $icon }}" aria-hidden="true"></i>
    </span>
    <div class="info-box-content">
        @if ($text)<span class="info-box-text">{{ $text }}</span>@endif
        @if ($title)<span class="info-box-number">{{ $title }}</span>@endif
        {{ $slot }}
        @isset($progress)
            <div class="progress">
                <div class="progress-bar {{ $theme ? 'text-bg-'.$theme : '' }}" style="width: {{ $progress }}%"></div>
            </div>
            @isset($progressText)<span class="progress-description">{{ $progressText }}</span>@endisset
        @endisset
    </div>
</div>
