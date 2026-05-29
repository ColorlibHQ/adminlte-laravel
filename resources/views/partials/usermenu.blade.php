@php
    $user = auth()->user();
    $name = $user->name ?? ($user->email ?? 'Guest');
    $avatar = (config('adminlte.usermenu_image') && ! empty($user?->profile_photo_url))
        ? $user->profile_photo_url
        : asset('vendor/adminlte/img/user2-160x160.jpg');
    $memberSince = $user?->created_at ? $user->created_at->format('M. Y') : null;
@endphp
<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <img src="{{ $avatar }}" class="user-image rounded-circle shadow" alt="{{ $name }}" width="30" height="30">
        <span class="d-none d-md-inline">{{ $name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        {{-- Header --}}
        <li class="user-header text-bg-primary">
            <img src="{{ $avatar }}" class="rounded-circle shadow" alt="{{ $name }}" width="90" height="90">
            <p>
                {{ $name }}
                @if ($memberSince)<small>{{ __('adminlte.member_since') }} {{ $memberSince }}</small>@endif
            </p>
        </li>
        {{-- Body --}}
        <li class="user-body">
            <div class="row">
                <div class="col-4 text-center"><a href="#">{{ __('adminlte.followers') }}</a></div>
                <div class="col-4 text-center"><a href="#">{{ __('adminlte.sales') }}</a></div>
                <div class="col-4 text-center"><a href="#">{{ __('adminlte.friends') }}</a></div>
            </div>
        </li>
        {{-- Footer --}}
        <li class="user-footer">
            <a href="{{ url(config('adminlte.usermenu_profile_url') ?: 'admin/profile') }}" class="btn btn-outline-secondary">
                {{ __('adminlte.profile') }}
            </a>
            <a href="#" class="btn btn-outline-danger float-end"
               onclick="event.preventDefault(); document.getElementById('adminlte-logout-form').submit();">
                {{ __('adminlte.sign_out') }}
            </a>
            <form id="adminlte-logout-form" action="{{ url('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
    </ul>
</li>
