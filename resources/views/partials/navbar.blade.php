@php
    $navLeft = app('adminlte')->menu('navbar-left');
    $navRight = app('adminlte')->menu('navbar-right');
@endphp
<nav class="app-header {{ config('adminlte.classes_topnav', 'navbar-expand bg-body') }} navbar">
    <div class="{{ config('adminlte.classes_topnav_container', 'container-fluid') }}">
        {{-- Left side --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            @foreach ($navLeft as $item)
                @if (($item['type'] ?? null) === 'navbar-search')
                    <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                @else
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ $item['href'] ?? '#' }}" class="nav-link">{{ $item['text'] ?? '' }}</a>
                    </li>
                @endif
            @endforeach
        </ul>

        {{-- Right side --}}
        <ul class="navbar-nav ms-auto">
            @foreach ($navRight as $item)
                <li class="nav-item">
                    <a href="{{ $item['href'] ?? '#' }}" class="nav-link">
                        @isset($item['icon'])<i class="{{ $item['icon'] }}"></i>@endisset
                        {{ $item['text'] ?? '' }}
                    </a>
                </li>
            @endforeach

            {{-- Fullscreen toggle --}}
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen" aria-label="Toggle fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
                </a>
            </li>

            {{-- Color mode toggle --}}
            @if (config('adminlte.color_mode_toggle', true))
                @include('adminlte::partials.color-mode')
            @endif

            {{-- User menu --}}
            @auth
                @if (config('adminlte.usermenu_enabled', true))
                    @include('adminlte::partials.usermenu')
                @endif
            @endauth
        </ul>
    </div>
</nav>
