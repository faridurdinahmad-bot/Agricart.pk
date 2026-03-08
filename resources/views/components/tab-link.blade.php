@props(['href', 'label', 'active' => false, 'variant' => 'default'])

@php
$base = 'px-4 py-2 rounded-xl text-sm font-medium transition-all';
$activeStyles = [
    'default' => 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40',
    'warning' => 'bg-amber-500/20 text-amber-400 border border-amber-400/40',
];
$inactiveStyles = 'glass-solid border border-white/20 text-white/80 hover:bg-white/10';
$classes = $base . ' ' . ($active ? ($activeStyles[$variant] ?? $activeStyles['default']) : $inactiveStyles);
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $label }}</a>
