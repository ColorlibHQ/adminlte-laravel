<div class="timeline timeline-inverse {{ $class }}">
    @forelse ($items as $item)
        <div class="timeline-item">
            <span class="timeline-icon {{ $item['icon_bg'] ?? 'bg-primary' }}">
                <i class="{{ $item['icon'] ?? 'bi bi-info-circle' }}"></i>
            </span>
            <div class="timeline-content">
                @if ($item['title'] ?? null)
                    <h3 class="timeline-header">
                        @if ($item['url'] ?? null)
                            <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                        @else
                            {{ $item['title'] }}
                        @endif
                    </h3>
                @endif
                @if ($item['body'] ?? null)
                    <p class="timeline-body">{{ $item['body'] }}</p>
                @endif
                @if ($item['footer'] ?? null)
                    <div class="timeline-footer">{{ $item['footer'] }}</div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">{{ __('adminlte.no_items') }}</p>
    @endforelse
</div>
