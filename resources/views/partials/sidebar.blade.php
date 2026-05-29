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

            @if (config('adminlte.sidebar_docs_url'))
                <div class="sidebar-docs-cta mt-3 border-top border-secondary border-opacity-25">
                    <a href="{{ config('adminlte.sidebar_docs_url') }}"
                       class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2"
                       target="_blank" rel="noopener"
                       title="{{ __('adminlte.view_documentation') }}">
                        <i class="bi bi-book" aria-hidden="true"></i>
                        <span class="sidebar-docs-cta__text">{{ __('adminlte.view_documentation') }}</span>
                    </a>
                </div>
            @endif
        </nav>
    </div>
</aside>

@once
    {{-- Inline (not @push('css'): this partial renders in the body, after the head's @stack('css')). --}}
    <style>
        .sidebar-docs-cta { padding: 1rem; }
        /* When the sidebar is collapsed to icons (and not hovered open), shrink the
           docs button to icon-only so it doesn't overflow the narrow rail. */
        .sidebar-mini.sidebar-collapse .app-sidebar:not(:hover) .sidebar-docs-cta { padding: .5rem; }
        .sidebar-mini.sidebar-collapse .app-sidebar:not(:hover) .sidebar-docs-cta__text { display: none; }
        /* Fully-collapsed (non-mini) sidebars hide off-canvas, so hide the CTA outright. */
        .sidebar-collapse:not(.sidebar-mini) .sidebar-docs-cta { display: none; }
    </style>
@endonce
