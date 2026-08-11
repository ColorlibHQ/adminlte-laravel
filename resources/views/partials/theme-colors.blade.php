{{-- Config-driven colour overrides (primary_color, sidebar_color, navbar_color,
     footer_color). Renders nothing unless at least one is set.

     Emitted unescaped by design: ThemeColors validates every value against a
     strict hex pattern and drops anything else, so the string can only contain
     hex digits, integers and its own hardcoded selectors. Placed after the Vite
     bundle so it wins the cascade, but before @stack('css')/@yield('css') so
     page-level styles can still override it. --}}
@php($adminlteThemeColors = \ColorlibHQ\AdminLte\Support\ThemeColors::styles())

@if ($adminlteThemeColors !== '')
    <style id="adminlte-theme-colors">
{!! $adminlteThemeColors !!}
    </style>
@endif
