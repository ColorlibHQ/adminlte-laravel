@php
    $user = auth()->user();
    $name = $user->name ?? ($user->email ?? 'User');
    $profileUrl = config('adminlte.usermenu_profile_url');
@endphp
<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        @if (config('adminlte.usermenu_image') && ! empty($user->profile_photo_url))
            <img src="{{ $user->profile_photo_url }}" class="user-image rounded-circle shadow" alt="{{ $name }}">
        @else
            <i class="bi bi-person-circle fs-5"></i>
        @endif
        <span class="d-none d-md-inline ms-1">{{ $name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        @if (config('adminlte.usermenu_header'))
            <li class="user-header text-bg-primary {{ config('adminlte.usermenu_header_class') }}">
                <p>{{ $name }}@if (config('adminlte.usermenu_desc'))<small>{{ $user->email ?? '' }}</small>@endif</p>
            </li>
        @endif
        @if ($profileUrl)
            <li>
                <a href="{{ $profileUrl === true ? url('profile') : url($profileUrl) }}" class="dropdown-item">
                    <i class="bi bi-person me-2"></i>{{ __('Profile') }}
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
        @endif
        <li>
            <a href="#" class="dropdown-item"
               onclick="event.preventDefault(); document.getElementById('adminlte-logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i>{{ __('Sign out') }}
            </a>
            <form id="adminlte-logout-form" action="{{ url('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</li>
