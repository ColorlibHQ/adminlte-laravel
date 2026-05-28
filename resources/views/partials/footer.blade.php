<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">
        @yield('footer_right', 'Version 4.0.0')
    </div>
    <strong>
        @yield('footer_left')
        &copy; {{ now()->year }}
        <a href="https://adminlte.io" target="_blank" rel="noopener">AdminLTE.io</a>.
    </strong>
    All rights reserved.
</footer>
