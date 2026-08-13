@php
    use Illuminate\Support\Facades\Route;

    $title = trim(($title ?? config('adminlte.title', 'AdminLTE 4')));

    $user = auth()->user();
    $name = $user->name ?? ($user->email ?? 'Guest');
    $avatar = ! empty($user?->profile_photo_url)
        ? $user->profile_photo_url
        : asset('vendor/adminlte/img/user2-160x160.jpg');

    // `password.confirm` is registered by `adminlte:make-auth` (and by
    // Breeze/Fortify). Fall back to the bare path so this page still renders
    // in an app that hasn't scaffolded auth yet.
    $unlockUrl = Route::has('password.confirm') ? route('password.confirm') : url('confirm-password');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    {{-- Bootstrap Icons ship via the Vite bundle (imported in resources/css/adminlte.css) --}}
    @vite(['resources/css/adminlte.css', 'resources/js/adminlte.js'])
    @include('adminlte::partials.theme-colors')
    @stack('css')
</head>
{{-- AdminLTE styles this page as `.lockscreen .lockscreen-*`, so the body
     class is what makes the rest of the markup below resolve. --}}
<body class="lockscreen bg-body-secondary app-loaded">
    <main class="lockscreen-wrapper" id="main" tabindex="-1">
        <h1 class="lockscreen-logo">
            <a href="{{ url('/') }}">
                @if (config('adminlte.auth_logo.enabled', false))
                    <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                         alt="{{ config('adminlte.auth_logo.img.alt') }}"
                         @if (config('adminlte.auth_logo.img.class'))
                             class="{{ config('adminlte.auth_logo.img.class') }}"
                         @endif
                         @if (config('adminlte.auth_logo.img.width'))
                             width="{{ config('adminlte.auth_logo.img.width') }}"
                         @endif
                         @if (config('adminlte.auth_logo.img.height'))
                             height="{{ config('adminlte.auth_logo.img.height') }}"
                         @endif>
                @endif
                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
            </a>
        </h1>

        <div class="lockscreen-name">{{ $name }}</div>

        <div class="lockscreen-item">
            <div class="lockscreen-image">
                <img src="{{ $avatar }}" alt="{{ $name }}">
            </div>

            <form action="{{ $unlockUrl }}" method="post" class="lockscreen-credentials">
                @csrf
                <label for="lockscreenPassword" class="visually-hidden">{{ __('adminlte.password') }}</label>

                <div class="input-group">
                    <input type="password" name="password" id="lockscreenPassword"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('adminlte.password') }}" required>

                    <div class="input-group-text border-0 bg-transparent px-1">
                        <button type="submit" class="btn shadow-none" aria-label="{{ __('adminlte.unlock') }}">
                            <i class="bi bi-box-arrow-right text-body-secondary"></i>
                        </button>
                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>

        <div class="help-block text-center">{{ __('adminlte.confirm_password_message') }}</div>

        @if (Route::has('login'))
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-decoration-none">
                    {{ __('adminlte.sign_in_as_different_user') }}
                </a>
            </div>
        @endif

        <div class="lockscreen-footer text-center">
            {!! config('adminlte.footer_left') !!}
        </div>
    </main>

    @stack('js')
</body>
</html>
