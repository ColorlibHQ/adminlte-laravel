<div class="rating {{ $class }}">
    @foreach ($stars() as $star)
        <i class="bi {{ $star['full'] ? 'bi-star-fill' : 'bi-star' }} text-{{ $color }}"></i>
    @endforeach
</div>
