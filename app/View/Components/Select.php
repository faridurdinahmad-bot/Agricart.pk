<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $name = null,
        public ?string $id = null,
        public bool $required = false,
        public bool $disabled = false,
        public ?string $error = null,
    ) {
        $this->id = $id ?? $name;
    }

    public function render()
    {
        return view('components.select');
    }
}
