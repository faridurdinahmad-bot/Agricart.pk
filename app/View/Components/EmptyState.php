<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmptyState extends Component
{
    public function __construct(
        public string $message,
        public ?string $icon = null,
    ) {}

    public function render()
    {
        return view('components.empty-state');
    }
}
