@extends('adminlte::page')

@section('title', 'Theme Generator')

@php
    use ColorlibHQ\AdminLte\Support\ThemeColors;

    // Seed each control from config so the generator reflects the theme the app
    // is actually running, falling back to the stock AdminLTE 4 value when the
    // key is unset (null) or holds something that isn't a hex colour.
    $colors = [
        'primary_color' => ThemeColors::normalize(config('adminlte.primary_color')) ?? '#0d6efd',
        'sidebar_color' => ThemeColors::normalize(config('adminlte.sidebar_color')) ?? '#343a40',
        'navbar_color' => ThemeColors::normalize(config('adminlte.navbar_color')) ?? '#ffffff',
        'footer_color' => ThemeColors::normalize(config('adminlte.footer_color')) ?? '#ffffff',
    ];

    $sidebarTheme = config('adminlte.sidebar_theme', 'dark');
@endphp

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h1>Theme Generator</h1></div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customize Theme Colors</h3>
                </div>
                <div class="card-body">
                    <p class="text-body-secondary small">
                        Every control below maps to a <code>config/adminlte.php</code> key and previews
                        live on this page. Copy the snippet when it looks right.
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input-color name="primary_color" label="Primary Color"
                                                    :default="$colors['primary_color']" />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input-color name="sidebar_color" label="Sidebar Color"
                                                    :default="$colors['sidebar_color']" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input-color name="navbar_color" label="Navbar Color"
                                                    :default="$colors['navbar_color']" />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input-color name="footer_color" label="Footer Color"
                                                    :default="$colors['footer_color']" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tg-sidebar-theme">Sidebar Theme</label>
                            <select id="tg-sidebar-theme" class="form-select">
                                <option value="dark" @selected($sidebarTheme === 'dark')>Dark</option>
                                <option value="light" @selected($sidebarTheme === 'light')>Light</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tg-mode">Preview Mode</label>
                            <select id="tg-mode" class="form-select">
                                <option value="light">Light</option>
                                <option value="dark">Dark</option>
                            </select>
                            <div class="form-text">
                                Preview only — at runtime the color mode comes from the topbar
                                toggle and the visitor's system preference.
                            </div>
                        </div>
                    </div>
                    <button id="tg-reset" type="button" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset to current config
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Config Output</h3>
                    <button id="tg-copy" class="btn btn-sm btn-outline-secondary ms-auto">
                        <i class="bi bi-clipboard me-1"></i> Copy
                    </button>
                </div>
                <div class="card-body">
                    <pre id="config-output" class="small mb-0" style="max-height: 320px; overflow: auto;"></pre>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Mirrors ColorlibHQ\AdminLte\Support\ThemeColors so the live preview
        // matches exactly what the generated config will render server-side.
        const SHADE_HOVER_BG = 0.85;
        const SHADE_HOVER_BORDER = 0.80;
        const SHADE_ACTIVE_BG = 0.80;
        const SHADE_ACTIVE_BORDER = 0.75;
        const MIN_CONTRAST_RATIO = 4.5;

        const defaults = @json($colors);

        const mode = document.getElementById('tg-mode');
        const sidebarTheme = document.getElementById('tg-sidebar-theme');
        const output = document.getElementById('config-output');
        const pickers = Object.keys(defaults).map(key => document.querySelector(`[name=${key}]`));

        const preview = document.createElement('style');
        preview.id = 'tg-preview';
        document.head.append(preview);

        const channels = hex => [1, 3, 5].map(i => parseInt(hex.slice(i, i + 2), 16));
        const rgb = hex => channels(hex).join(', ');
        const shade = (hex, keep) =>
            '#' + channels(hex).map(c => Math.round(c * keep).toString(16).padStart(2, '0')).join('');

        function contrast(hex) {
            const luminance = channels(hex).reduce((total, channel, index) => {
                const value = channel / 255;
                const linear = value <= 0.04045 ? value / 12.92 : ((value + 0.055) / 1.055) ** 2.4;
                return total + linear * [0.2126, 0.7152, 0.0722][index];
            }, 0);

            const onWhite = 1.05 / (luminance + 0.05);
            const onBlack = (luminance + 0.05) / 0.05;

            if (onWhite > MIN_CONTRAST_RATIO) return '#ffffff';
            if (onBlack > MIN_CONTRAST_RATIO) return '#000000';

            return onWhite >= onBlack ? '#ffffff' : '#000000';
        }

        function buildCss(colors) {
            const primary = colors.primary_color;
            const hoverBg = shade(primary, SHADE_HOVER_BG);
            const hoverBorder = shade(primary, SHADE_HOVER_BORDER);
            const fg = contrast(primary);

            return `
:root, [data-bs-theme="light"], [data-bs-theme="dark"] {
    --bs-primary: ${primary};
    --bs-primary-rgb: ${rgb(primary)};
    --bs-link-color: ${primary};
    --bs-link-color-rgb: ${rgb(primary)};
    --bs-link-hover-color: ${hoverBorder};
    --bs-link-hover-color-rgb: ${rgb(hoverBorder)};
}
.btn-primary {
    --bs-btn-color: ${fg};
    --bs-btn-bg: ${primary};
    --bs-btn-border-color: ${primary};
    --bs-btn-hover-color: ${fg};
    --bs-btn-hover-bg: ${hoverBg};
    --bs-btn-hover-border-color: ${hoverBorder};
    --bs-btn-active-color: ${fg};
    --bs-btn-active-bg: ${shade(primary, SHADE_ACTIVE_BG)};
    --bs-btn-active-border-color: ${shade(primary, SHADE_ACTIVE_BORDER)};
}
.btn-outline-primary {
    --bs-btn-color: ${primary};
    --bs-btn-border-color: ${primary};
    --bs-btn-hover-color: ${fg};
    --bs-btn-hover-bg: ${primary};
    --bs-btn-hover-border-color: ${primary};
}
.app-sidebar {
    --bs-secondary-bg: ${colors.sidebar_color};
    --bs-secondary-bg-rgb: ${rgb(colors.sidebar_color)};
}
.app-header {
    --bs-body-bg: ${colors.navbar_color};
    --bs-body-bg-rgb: ${rgb(colors.navbar_color)};
}
.app-footer {
    --bs-body-bg: ${colors.footer_color};
    --bs-body-bg-rgb: ${rgb(colors.footer_color)};
}`.trim();
        }

        function currentColors() {
            return Object.fromEntries(pickers.map(picker => [picker.name, picker.value]));
        }

        function update() {
            const colors = currentColors();

            // Live-apply to this page: colour mode on the document, sidebar theme
            // on the sidebar, and the generated variables in a <style> element.
            document.documentElement.setAttribute('data-bs-theme', mode.value);
            document.querySelector('.app-sidebar')
                ?.setAttribute('data-bs-theme', sidebarTheme.value);
            preview.textContent = buildCss(colors);

            output.textContent =
`// config/adminlte.php
'sidebar_theme'  => '${sidebarTheme.value}',
'primary_color'  => '${colors.primary_color}',
'sidebar_color'  => '${colors.sidebar_color}',
'navbar_color'   => '${colors.navbar_color}',
'footer_color'   => '${colors.footer_color}',`;
        }

        [...pickers, mode, sidebarTheme].forEach(el => {
            el.addEventListener('input', update);
            el.addEventListener('change', update);
        });

        document.getElementById('tg-reset').addEventListener('click', () => {
            pickers.forEach(picker => { picker.value = defaults[picker.name] });
            sidebarTheme.value = @json($sidebarTheme);
            update();
        });

        document.getElementById('tg-copy').addEventListener('click', async () => {
            const btn = document.getElementById('tg-copy');
            await navigator.clipboard.writeText(output.textContent);
            btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Copied';
            setTimeout(() => { btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copy' }, 1500);
        });

        // AdminLTE's core JS applies the stored color mode on DOMContentLoaded,
        // so wait for it before seeding the preview select — otherwise the first
        // update() would stamp "light" over the visitor's actual preference.
        function init() {
            const applied = document.documentElement.getAttribute('data-bs-theme');

            if (applied === 'light' || applied === 'dark') {
                mode.value = applied;
            }

            update();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    </script>
@endsection
