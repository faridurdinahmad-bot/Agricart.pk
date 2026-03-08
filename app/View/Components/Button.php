<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $variant = 'primary',
        public string $size = 'md',
        public string $type = 'button',
        public bool $disabled = false,
        public ?string $href = null,
        public bool $block = false,
    ) {}

    public function render()
    {
        return view('components.button');
    }
}
