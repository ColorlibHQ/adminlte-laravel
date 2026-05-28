<div {{ $attributes->merge(['class' => $cardClass()]) }}>
    @if ($title || $hasTools() || isset($tools))
        <div class="card-header {{ $headerClass }}">
            @if ($title)
                <div class="card-title">
                    @isset($icon)<i class="{{ $icon }} me-1"></i>@endisset
                    {{ $title }}
                </div>
            @endif

            <div class="card-tools ms-auto">
                {{ $tools ?? '' }}
                @if ($collapsible)
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Collapse">
                        <i data-lte-icon="expand" class="bi {{ $collapsed ? 'bi-plus-lg' : 'bi-dash-lg' }}"></i>
                        <i data-lte-icon="collapse" class="bi {{ $collapsed ? 'bi-dash-lg' : 'bi-plus-lg' }}"></i>
                    </button>
                @endif
                @if ($maximizable)
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-maximize" aria-label="Maximize">
                        <i class="bi bi-arrows-fullscreen"></i>
                    </button>
                @endif
                @if ($removable)
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove" aria-label="Remove">
                        <i class="bi bi-x-lg"></i>
                    </button>
                @endif
            </div>
        </div>
    @endif

    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer {{ $footerClass }}">
            {{ $footer }}
        </div>
    @endisset
</div>
