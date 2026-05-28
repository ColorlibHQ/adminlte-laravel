<div class="card card-primary card-outline {{ $class }}">
    <div class="card-body box-profile">
        <div class="text-center">
            @if ($image)
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ $image }}"
                     alt="{{ $imageAlt ?? $name }}">
            @endif
        </div>
        <h3 class="profile-username text-center">{{ $name }}</h3>
        @if ($title)
            <p class="text-muted text-center">{{ $title }}</p>
        @endif
        @if ($description)
            <p class="text-muted text-center">{{ $description }}</p>
        @endif
        @if ($socials)
            <div class="text-center">
                @foreach ($socials as $social)
                    <a href="{{ $social['url'] }}"
                       class="btn btn-sm btn-{{ $social['color'] ?? 'primary' }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        <i class="{{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
