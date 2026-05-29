@extends('adminlte::page')

@section('title', 'Layout Options')

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h1 class="m-0">Layout Options</h1></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Layout Options</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="callout callout-info">
        <p class="mb-0">
            In the Laravel package, AdminLTE's layout variants are <strong>config-driven</strong> rather than
            separate pages — set the keys below in <code>config/adminlte.php</code> and the layout updates
            everywhere. The toggles you can try live (color mode, sidebar collapse, fullscreen) are in the navbar.
        </p>
    </div>

    @php
        $options = [
            ['Fixed Sidebar', 'layout_fixed_sidebar', 'bi bi-layout-sidebar', 'The sidebar stays in place while the page content scrolls.'],
            ['Fixed Header', 'layout_fixed_navbar', 'bi bi-layout-text-window', 'The top navbar is pinned to the top of the viewport.'],
            ['Fixed Footer', 'layout_fixed_footer', 'bi bi-layout-text-window-reverse', 'The footer is pinned to the bottom of the viewport.'],
            ['Sidebar Mini', 'sidebar_mini', 'bi bi-distribute-vertical', 'Collapses the sidebar to icons; expands on hover.'],
            ['Collapsed Sidebar', 'sidebar_collapse', 'bi bi-chevron-bar-left', 'Starts with the sidebar collapsed.'],
            ['Boxed Layout', 'layout_boxed', 'bi bi-bounding-box', 'Constrains the app to a centered, boxed width.'],
            ['Top Navigation', 'layout_topnav', 'bi bi-menu-button-wide', 'Hides the sidebar and renders the menu in the top navbar.'],
            ['Right-to-Left (RTL)', 'layout_rtl', 'bi bi-text-right', 'Loads the RTL stylesheet and flips the layout direction.'],
        ];
    @endphp

    <div class="row">
        @foreach ($options as [$name, $key, $icon, $desc])
            @php($enabled = (bool) config('adminlte.'.$key))
            <div class="col-md-6 col-xl-4">
                <x-adminlte-card :title="$name" :icon="$icon" theme="" :collapsible="false">
                    <x-slot name="tools">
                        <span class="badge text-bg-{{ $enabled ? 'success' : 'secondary' }}">
                            {{ $enabled ? 'On' : 'Off' }}
                        </span>
                    </x-slot>
                    <p class="text-secondary">{{ $desc }}</p>
                    <pre class="mb-0 bg-body-secondary rounded p-2 small"><code>'{{ $key }}' => {{ $enabled ? 'true' : 'false' }},</code></pre>
                </x-adminlte-card>
            </div>
        @endforeach
    </div>
@stop
