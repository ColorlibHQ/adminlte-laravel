@php
    $items = app('adminlte')->menu('sidebar');
    $sidebarTheme = config('adminlte.sidebar_theme', 'dark');
    $sidebarClasses = config('adminlte.classes_sidebar', 'bg-body-secondary shadow');
@endphp
<aside class="app-sidebar {{ $sidebarClasses }}" @if ($sidebarTheme === 'dark') data-bs-theme="dark" @endif>
    {{-- Brand --}}
    <div class="sidebar-brand {{ config('adminlte.classes_brand') }}">
        <a href="{{ url('/') }}" class="brand-link">
            @if (config('adminlte.logo_img'))
                <img src="{{ asset(config('adminlte.logo_img')) }}"
                     alt="{{ config('adminlte.logo_img_alt', 'Logo') }}"
                     class="{{ config('adminlte.logo_img_class', 'brand-image opacity-75 shadow') }}">
            @endif
            <span class="brand-text {{ config('adminlte.classes_brand_text', 'fw-light') }}">
                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
            </span>
        </a>
    </div>

    {{-- Menu --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="{{ __('Main navigation') }}">
            <ul class="nav sidebar-menu flex-column {{ config('adminlte.classes_sidebar_nav') }}"
                data-lte-toggle="treeview"
                data-accordion="false"
                role="menu"
                id="navigation">
                @foreach ($items as $item)
                    @include('adminlte::partials.menu-item', ['item' => $item])
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
