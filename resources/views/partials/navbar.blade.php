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
            {{-- Search (toggles the collapsible search bar below the navbar) --}}
            <li class="nav-item">
                <a class="nav-link" href="#" role="button"
                   data-bs-toggle="collapse" data-bs-target="#adminlteNavbarSearch"
                   aria-controls="adminlteNavbarSearch" aria-expanded="false"
                   aria-label="{{ __('adminlte.search') }}">
                    <i class="bi bi-search"></i>
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

    {{-- Collapsible search bar --}}
    <div class="collapse" id="adminlteNavbarSearch">
        <div class="{{ config('adminlte.classes_topnav_container', 'container-fluid') }} pb-2">
            <form role="search" method="GET" action="{{ config('adminlte.search_url') ?: url('/') }}">
                <div class="input-group">
                    <input type="search" name="{{ config('adminlte.search_param', 'q') }}"
                           class="form-control" placeholder="{{ __('adminlte.search') }}…"
                           value="{{ request(config('adminlte.search_param', 'q')) }}"
                           aria-label="{{ __('adminlte.search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>

@once
    @push('js')
        <script>
            // Focus the navbar search field whenever the search bar is revealed.
            document.addEventListener('DOMContentLoaded', function () {
                const box = document.getElementById('adminlteNavbarSearch');
                if (!box) return;
                box.addEventListener('shown.bs.collapse', function () {
                    const input = box.querySelector('input[type="search"]');
                    if (input) input.focus();
                });
            });
        </script>
    @endpush
@endonce
