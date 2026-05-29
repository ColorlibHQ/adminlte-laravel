@php
    // Demo notifications for the navbar dropdown. Replace with real data in your app.
    $notifications = config('adminlte.navbar_notifications', [
        ['icon' => 'bi bi-envelope', 'text' => '4 new messages', 'time' => '3 mins'],
        ['icon' => 'bi bi-people-fill', 'text' => '8 friend requests', 'time' => '12 hours'],
        ['icon' => 'bi bi-file-earmark-fill', 'text' => '3 new reports', 'time' => '2 days'],
    ]);
    $notificationCount = config('adminlte.navbar_notifications_count', 15);
@endphp
<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-bell-fill"></i>
        <span class="navbar-badge badge text-bg-warning">{{ $notificationCount }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">{{ $notificationCount }} {{ __('adminlte.notifications') }}</span>
        <div class="dropdown-divider"></div>
        @foreach ($notifications as $note)
            <a href="#" class="dropdown-item">
                <i class="{{ $note['icon'] }} me-2"></i> {{ $note['text'] }}
                <span class="float-end text-secondary fs-7">{{ $note['time'] }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endforeach
        <a href="#" class="dropdown-item dropdown-footer">{{ __('adminlte.see_all_notifications') }}</a>
    </div>
</li>
