<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProfileCard extends Component
{
    /**
     * @param  array<int, array<string, mixed>>  $socials
     */
    public function __construct(
        public string $name,
        public ?string $title = null,
        public ?string $image = null,
        public ?string $imageAlt = null,
        public array $socials = [],
        public ?string $description = null,
        public ?string $class = null,
    ) {}

    /**
     * Social URLs may come from user-editable profile data, so reject
     * dangerous schemes (javascript:, data:, ...) instead of echoing them.
     *
     * @param  array<string, mixed>  $social
     */
    public function socialUrl(array $social): string
    {
        $url = (string) ($social['url'] ?? '');
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if ($url === '' || ($scheme !== '' && ! in_array($scheme, ['http', 'https', 'mailto'], true))) {
            return '#';
        }

        return $url;
    }

    public function render(): View
    {
        return view('adminlte::components.widget.profile-card');
    }
}
