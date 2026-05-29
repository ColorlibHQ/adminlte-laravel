@extends('adminlte::page')

@section('title', 'Theme Generator')

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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Sidebar Color</label>
                            <x-adminlte-input-color name="sidebar_color" value="#343a40" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Primary Color</label>
                            <x-adminlte-input-color name="primary_color" value="#007bff" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Navbar Color</label>
                            <x-adminlte-input-color name="navbar_color" value="#ffffff" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Footer Color</label>
                            <x-adminlte-input-color name="footer_color" value="#f8f9fa" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color Mode</label>
                            <select id="tg-mode" class="form-select">
                                <option value="light">Light</option>
                                <option value="dark">Dark</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sidebar Theme</label>
                            <select id="tg-sidebar-theme" class="form-select">
                                <option value="dark">Dark</option>
                                <option value="light">Light</option>
                            </select>
                        </div>
                    </div>
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
        const mode = document.getElementById('tg-mode');
        const sidebarTheme = document.getElementById('tg-sidebar-theme');
        const output = document.getElementById('config-output');

        function updatePreview() {
            // Live-apply the colour mode to the document for an instant preview.
            document.documentElement.setAttribute('data-bs-theme', mode.value);

            output.textContent =
`// Paste into config/adminlte.php
'color_mode'    => '${mode.value}',
'sidebar_theme' => '${sidebarTheme.value}',
'sidebar_color' => '${document.querySelector('[name=sidebar_color]')?.value ?? ''}',
'primary_color' => '${document.querySelector('[name=primary_color]')?.value ?? ''}',
'navbar_color'  => '${document.querySelector('[name=navbar_color]')?.value ?? ''}',
'footer_color'  => '${document.querySelector('[name=footer_color]')?.value ?? ''}',`;
        }

        document.querySelectorAll('input[type="color"], #tg-mode, #tg-sidebar-theme')
            .forEach(el => el.addEventListener('change', updatePreview));

        document.getElementById('tg-copy').addEventListener('click', async () => {
            await navigator.clipboard.writeText(output.textContent);
            const btn = document.getElementById('tg-copy');
            btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Copied';
            setTimeout(() => { btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copy'; }, 1500);
        });

        updatePreview();
    </script>
@endsection
