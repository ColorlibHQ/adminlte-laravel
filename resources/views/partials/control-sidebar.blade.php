@if (config('adminlte.control_sidebar', false))
    <aside class="control-sidebar control-sidebar-{{ config('adminlte.control_sidebar_theme', 'dark') }}" data-lte-toggle="control-sidebar">
        <div class="control-sidebar-content">
            {{ $slot ?? '' }}
        </div>
    </aside>
@endif
