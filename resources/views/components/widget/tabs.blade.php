<div class="@if ($class) {{ $class }} @endif">
    <ul class="nav nav-{{ $variant }} @if ($justified) nav-justified @endif @if ($fill) nav-fill @endif" role="tablist">
        {{ $slot }}
    </ul>
    <div class="tab-content">
        <!-- Tab panes injected via <x-adminlte-tab> components -->
    </div>
</div>
