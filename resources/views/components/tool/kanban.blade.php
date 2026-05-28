<div class="row g-2 @if ($class) {{ $class }} @endif" data-sortable-kanban>
    @forelse ($lanes as $lane)
        <div class="col-lg-6 col-xl-4">
            <h5 class="mb-3">{{ $lane['name'] ?? 'Lane' }}</h5>
            <div class="list-group" data-sortable-group="{{ $loop->index }}">
                @forelse ($lane['cards'] ?? [] as $card)
                    <div class="list-group-item" draggable="true">
                        <div class="d-flex align-items-center">
                            @if ($card['color'] ?? false)
                                <span class="badge bg-{{ $card['color'] }} me-2"></span>
                            @endif
                            <div>
                                <strong>{{ $card['title'] ?? '' }}</strong>
                                @if ($card['description'] ?? false)
                                    <div class="small text-muted">{{ $card['description'] }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    @empty
    @endforelse
</div>
