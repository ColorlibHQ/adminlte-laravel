<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-chat"></i>
        @if (count($messages) > 0)
            <span class="badge badge-{{ $badgeColor }} navbar-badge">{{ count($messages) }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <a href="#" class="dropdown-item">
            <span class="dropdown-header">{{ count($messages) }} {{ __('adminlte.messages') }}</span>
        </a>
        <div class="dropdown-divider"></div>
        @forelse ($messages as $message)
            <a href="{{ $message['url'] ?? '#' }}" class="dropdown-item">
                @if ($message['image'] ?? null)
                    <div class="d-flex">
                        <img src="{{ $message['image'] }}"
                             alt="{{ $message['from'] ?? 'User' }}"
                             class="rounded-circle me-3"
                             style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $message['from'] ?? 'Unknown' }}</h6>
                            <small class="text-muted">{{ $message['text'] ?? '' }}</small>
                        </div>
                    </div>
                @else
                    <div>
                        <h6 class="mb-0">{{ $message['from'] ?? 'Unknown' }}</h6>
                        <small>{{ $message['text'] ?? '' }}</small>
                    </div>
                @endif
            </a>
        @empty
            <a href="#" class="dropdown-item">{{ __('adminlte.no_messages') }}</a>
        @endforelse
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">{{ __('adminlte.see_all_messages') }}</a>
    </div>
</li>
