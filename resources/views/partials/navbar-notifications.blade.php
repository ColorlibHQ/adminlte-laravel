@php
    use ColorlibHQ\AdminLte\Support\NavbarData;

    // Real unread notifications when the `notifications` table exists, otherwise
    // the config-driven demo data. See NavbarData for the fallback logic.
    $notifications = NavbarData::notifications();
    $notificationCount = NavbarData::notificationCount();
    $notificationsUrl = \Illuminate\Support\Facades\Route::has('adminlte.notifications.index')
        ? route('adminlte.notifications.index')
        : '#';
@endphp
<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-bell-fill"></i>
        @if ($notificationCount > 0)
            <span class="navbar-badge badge text-bg-warning">{{ $notificationCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">{{ $notificationCount }} {{ __('adminlte.notifications') }}</span>
        <div class="dropdown-divider"></div>
        @forelse ($notifications as $note)
            <a href="{{ $note['url'] ?? '#' }}" class="dropdown-item">
                <i class="{{ $note['icon'] }} me-2"></i> {{ $note['text'] }}
                <span class="float-end text-secondary fs-7">{{ $note['time'] }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <span class="dropdown-item text-secondary">{{ __('adminlte.no_notifications') }}</span>
            <div class="dropdown-divider"></div>
        @endforelse
        <a href="{{ $notificationsUrl }}" class="dropdown-item dropdown-footer">{{ __('adminlte.see_all_notifications') }}</a>
    </div>
</li>
