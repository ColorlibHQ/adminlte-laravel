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
                    <button class="btn btn-primary">{{ __('adminlte.preview') }}</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Config Output</h3>
                </div>
                <div class="card-body">
                    <pre id="config-output" class="small" style="max-height: 300px; overflow: auto;">// Paste into config/adminlte.php
'sidebar_theme' => 'dark',
'classes_sidebar' => '',
'classes_topnav' => '',</pre>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.querySelectorAll('input[type="color"]').forEach(input => {
            input.addEventListener('change', () => {
                updatePreview();
            });
        });

        function updatePreview() {
            const config = `// Theme Configuration\n'sidebar_theme' => 'dark',\n'primary_color' => 'primary',`;
            document.getElementById('config-output').textContent = config;
        }
    </script>
@endsection
