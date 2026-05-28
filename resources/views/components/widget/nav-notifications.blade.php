<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-bell"></i>
        @if (count($notifications) > 0)
            <span class="badge badge-{{ $badgeColor }} navbar-badge">{{ count($notifications) }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-header">{{ count($notifications) }} {{ __('adminlte.notifications') }}</span>
        <div class="dropdown-divider"></div>
        @forelse ($notifications as $notification)
            <a href="{{ $notification['url'] ?? '#' }}" class="dropdown-item">
                <i class="bi {{ $notification['icon'] ?? 'bi-info-circle' }} me-2"></i>
                <span>{{ $notification['title'] ?? 'Notification' }}</span>
                @if ($notification['time'] ?? null)
                    <span class="float-end text-muted text-sm">{{ $notification['time'] }}</span>
                @endif
            </a>
        @empty
            <a href="#" class="dropdown-item">{{ __('adminlte.no_notifications') }}</a>
        @endforelse
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">{{ __('adminlte.see_all_notifications') }}</a>
    </div>
</li>
