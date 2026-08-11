{{-- Right-hand settings panel, rendered only when config('adminlte.control_sidebar')
     is enabled. The toggle button lives in partials/navbar.blade.php behind the
     same flag.

     Built on Bootstrap's Offcanvas rather than AdminLTE's old `.control-sidebar`:
     that was an AdminLTE 3 component, and v4 ships no CSS, no JS and no
     `data-lte-toggle="control-sidebar"` handler for it — the markup rendered as
     an unstyled block that could never be opened. Offcanvas is already in the
     bundle (`import 'bootstrap'` in the published resources/js/adminlte.js) and
     brings the backdrop, Esc-to-close and focus trap with it.

     Fill it from a page with @section('control_sidebar') or @push('control_sidebar'). --}}
@if (config('adminlte.control_sidebar', false))
    <div class="offcanvas offcanvas-end"
         tabindex="-1"
         id="adminlte-control-sidebar"
         data-bs-theme="{{ config('adminlte.control_sidebar_theme', 'dark') }}"
         aria-labelledby="adminlte-control-sidebar-label">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="adminlte-control-sidebar-label">
                {{ __('adminlte.settings') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                    aria-label="{{ __('Close') }}"></button>
        </div>
        <div class="offcanvas-body">
            @yield('control_sidebar')
            @stack('control_sidebar')
            {{ $slot ?? '' }}
        </div>
    </div>
@endif
