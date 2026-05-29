<div @if ($class) class="{{ $class }}" @endif>
    <ul class="nav nav-{{ $variant }} @if ($justified) nav-justified @endif @if ($fill) nav-fill @endif" role="tablist">
        {{-- Tab buttons render here; each pane is pushed to the stack below. --}}
        {{ $slot }}
    </ul>
    <div class="tab-content pt-3">
        @stack(\ColorlibHQ\AdminLte\View\Components\Widget\Tabs::PANE_STACK)
    </div>
</div>
