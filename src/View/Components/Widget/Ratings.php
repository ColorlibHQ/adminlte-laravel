<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Ratings extends Component
{
    public function __construct(
        public int $value,
        public int $max = 5,
        public string $color = 'warning',
        public bool $readonly = true,
        public ?string $class = null,
    ) {}

    public function stars(): array
    {
        $stars = [];
        for ($i = 1; $i <= $this->max; $i++) {
            $stars[] = [
                'full' => $i <= $this->value,
                'number' => $i,
            ];
        }
        return $stars;
    }

    public function render(): View
    {
        return view('adminlte::components.widget.ratings');
    }
}
