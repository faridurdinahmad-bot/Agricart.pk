<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $name = null,
        public ?string $id = null,
        public string $type = 'text',
        public ?string $placeholder = null,
        public bool $required = false,
        public bool $disabled = false,
        public ?string $error = null,
    ) {
        $this->id = $id ?? $name;
    }

    public function render()
    {
        return view('components.input');
    }
}
