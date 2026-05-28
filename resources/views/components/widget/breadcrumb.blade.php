<nav aria-label="breadcrumb" @if ($class) class="{{ $class }}" @endif>
    <ol class="breadcrumb mb-0">
        @forelse ($items as $item)
            <li class="breadcrumb-item @if ($item['active'] ?? false) active @endif">
                @if (!($item['active'] ?? false) && isset($item['url']))
                    <a href="{{ $item['url'] }}">{{ $item['label'] ?? '' }}</a>
                @else
                    {{ $item['label'] ?? '' }}
                @endif
            </li>
        @empty
        @endforelse
        {{ $slot }}
    </ol>
</nav>
