@php
    $title = trim(($title ?? config('adminlte.title', 'AdminLTE 4')));
    $authType = $authType ?? 'login'; // login | register
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
<body class="{{ $authType }}-page bg-body-secondary">
    <div class="{{ $authType }}-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1">
                    @if (config('adminlte.auth_logo.enabled', false))
                        <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                             alt="{{ config('adminlte.auth_logo.img.alt') }}"
                             @if (config('adminlte.auth_logo.img.class', null))
                                class="{{ config('adminlte.auth_logo.img.class') }}"
                             @endif
                             @if (config('adminlte.auth_logo.img.width', null))
                                width="{{ config('adminlte.auth_logo.img.width') }}"
                             @endif
                             @if (config('adminlte.auth_logo.img.height', null))
                                height="{{ config('adminlte.auth_logo.img.height') }}"
                             @endif>
                    @else
                        <img src="{{ asset(config('adminlte.logo_img')) }}"
                             alt="{{ config('adminlte.logo_img_alt') }}" height="50">
                    @endif
                    {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                </a>
            </div>
            <div class="card-body">
                @yield('auth_body')
            </div>
        </div>
    </div>
    @stack('js')
</body>
</html>
