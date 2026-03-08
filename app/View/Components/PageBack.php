<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageBack extends Component
{
    public function __construct(
        public string $href,
        public string $title,
    ) {}

    public function render()
    {
        return view('components.page-back');
    }
}
