@php
    $user = auth()->user();
    $name = $user->name ?? ($user->email ?? 'Guest');
    $avatar = !empty($user?->profile_photo_url)
        ? $user->profile_photo_url
        : asset('vendor/adminlte/img/user2-160x160.jpg');
    $memberSince = $user?->created_at ? $user->created_at->format('M. Y') : null;
    $profileUrl = config('adminlte.usermenu_profile_url', false) === true
        ? 'admin/profile'
        : config('adminlte.usermenu_profile_url');
@endphp
<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <img src="{{ $avatar }}" class="user-image rounded-circle shadow" alt="{{ $name }}" width="30" height="30">
        <span class="d-none d-md-inline">{{ $name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        {{-- Header --}}
        
        @if(config('adminlte.usermenu_header'))
            <li class="user-header {{ config('adminlte.usermenu_header_class', 'text-bg-primary') }}
                @if(!config('adminlte.usermenu_image')) h-auto @endif" style="min-height: 0px;">
                
                @if(config('adminlte.usermenu_image'))
                    <img src="{{ $avatar }}" class="rounded-circle shadow" alt="{{ $name }}" width="90" height="90">
                @endif
                <p>
                    {{ $name }}
                    @if(config('adminlte.usermenu_desc'))
                        @if ($memberSince)<small>{{ __('adminlte.member_since') }} {{ $memberSince }}</small>@endif
                    @endif
                </p>
            </li>
        @endif
        
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
            @if (config('adminlte.usermenu_profile_url'))
                <a href="{{ $profileUrl }}" class="btn btn-outline-secondary">
                    {{ __('adminlte.profile') }}
                </a>
            @endif
            
            <a href="#" class="btn btn-outline-danger float-end @if(!config('adminlte.usermenu_profile_url')) w-100 @endif"
               onclick="event.preventDefault(); document.getElementById('adminlte-logout-form').submit();">
                {{ __('adminlte.sign_out') }}
            </a>
            <form id="adminlte-logout-form" action="{{ url('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
    </ul>
</li>
