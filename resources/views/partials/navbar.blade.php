@php
    $navLeft = app('adminlte')->menu('navbar-left');
@endphp
<nav class="app-header {{ config('adminlte.classes_topnav', 'navbar-expand bg-body') }} navbar">
    <div class="{{ config('adminlte.classes_topnav_container', 'container-fluid') }}">
        {{-- Left side --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="{{ __('Toggle sidebar') }}">
                    <i class="bi bi-list"></i>
                </a>
            </li>

            <li class="nav-item d-none d-md-block">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="bi bi-grid-1x2 me-1" aria-hidden="true"></i> {{ __('adminlte.home') }}
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ config('adminlte.sidebar_docs_url', '#') }}" class="nav-link" target="_blank" rel="noopener">
                    <i class="bi bi-book me-1" aria-hidden="true"></i> {{ __('adminlte.documentation') }}
                </a>
            </li>

            @foreach ($navLeft as $item)
                <li class="nav-item d-none d-md-block">
                    <a href="{{ $item['href'] ?? '#' }}" class="nav-link">{{ $item['text'] ?? '' }}</a>
                </li>
            @endforeach
        </ul>

        {{-- Right side --}}
        <ul class="navbar-nav ms-auto">
            {{-- Search (opens the ⌘K command palette) --}}
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#" role="button"
                   data-adminlte-search aria-label="{{ __('adminlte.search') }}">
                    <i class="bi bi-search"></i>
                    <kbd class="d-none d-lg-inline small bg-body-secondary text-body-secondary border rounded px-1">⌘K</kbd>
                </a>
            </li>

            {{-- Messages dropdown --}}
            @include('adminlte::partials.navbar-messages')

            {{-- Notifications dropdown --}}
            @include('adminlte::partials.navbar-notifications')

            {{-- Fullscreen toggle --}}
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen" aria-label="{{ __('Toggle fullscreen') }}">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
                </a>
            </li>

            {{-- Color mode toggle --}}
            @if (config('adminlte.color_mode_toggle', true))
                @include('adminlte::partials.color-mode')
            @endif

            {{-- User menu --}}
            @if (config('adminlte.usermenu_enabled', true))
                @include('adminlte::partials.usermenu')
            @endif
        </ul>
    </div>
</nav>

@include('adminlte::partials.command-palette')
