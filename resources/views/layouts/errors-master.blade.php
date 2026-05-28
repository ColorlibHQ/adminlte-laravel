@php
    $rtl = config('adminlte.layout_rtl', false);
    $titlePrefix = config('adminlte.title_prefix', '');
    $titlePostfix = config('adminlte.title_postfix', '');
    $title = trim($titlePrefix.' '.($title ?? config('adminlte.title', 'AdminLTE 4')).' '.$titlePostfix);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ $rtl ? 'rtl' : 'ltr' }}"
      @isset($darkMode) data-bs-theme="dark" @endisset>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">

    @hasSection('adminlte_css')
        @yield('adminlte_css')
    @endif

    @vite(['resources/css/adminlte.css', 'resources/js/adminlte.js'])

    @stack('css')
    @yield('css')
</head>
<body class="bg-body-tertiary">
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            @yield('content')
        </div>
    </div>

    @stack('js')
    @yield('js')
</body>
</html>
