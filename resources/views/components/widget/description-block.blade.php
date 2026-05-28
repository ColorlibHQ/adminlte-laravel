<div class="description-block border-left border-warning pl-4 {{ $class }}">
    <h5 class="text-warning">{{ $title }}</h5>
    @if ($text)
        <p class="text-muted text-sm">{{ $text }}</p>
    @endif
    @if ($items)
        <dl>
            @foreach ($items as $label => $value)
                <dt>{{ $label }}</dt>
                <dd>{{ $value }}</dd>
            @endforeach
        </dl>
    @endif
</div>
