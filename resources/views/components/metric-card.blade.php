@props(['label', 'value', 'variant' => 'default'])

@php
$valueClass = match($variant) {
    'success' => 'text-[#83b735]',
    'danger' => 'text-red-400',
    'warning' => 'text-amber-400',
    default => 'text-white/90',
};
@endphp

<div {{ $attributes->merge(['class' => 'backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6']) }}>
    <p class="text-xs text-white/60 mb-1">{{ $label }}</p>
    <p class="text-2xl font-bold {{ $valueClass }}">{{ $value }}</p>
</div>
