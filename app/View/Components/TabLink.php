<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabLink extends Component
{
    public function __construct(
        public string $href,
        public string $label,
        public bool $active = false,
        public string $variant = 'default',
    ) {}

    public function render()
    {
        return view('components.tab-link');
    }
}
