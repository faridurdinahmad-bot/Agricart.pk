<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public ?string $title = null,
        public bool $padding = true,
    ) {}

    public function render()
    {
        return view('components.card');
    }
}
