<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageHeading extends Component
{
    public function __construct(
        public string $title,
        public ?string $subtitle = null,
    ) {}

    public function render()
    {
        return view('components.page-heading');
    }
}
