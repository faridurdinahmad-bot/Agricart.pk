<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MetricCard extends Component
{
    public function __construct(
        public string $label,
        public string $value,
        public string $variant = 'default',
    ) {}

    public function render()
    {
        return view('components.metric-card');
    }
}
