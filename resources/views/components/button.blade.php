@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'href' => null,
    'block' => false,
])

@php
$base = 'inline-flex items-center justify-center gap-2 font-medium transition-all duration-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-50 disabled:cursor-not-allowed';
$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2.5 text-sm',
    'lg' => 'px-5 py-3 text-base',
];
$variants = [
    'primary' => 'bg-[#83b735] text-white hover:bg-[#6f9d2d] focus:ring-[#83b735] shadow-lg shadow-[#83b735]/25',
    'secondary' => 'glass-solid border border-white/20 text-white hover:bg-white/20 focus:ring-white/40',
    'ghost' => 'bg-white/5 border border-white/10 text-white/90 hover:bg-white/10 hover:border-[#83b735]/30 focus:ring-[#83b735]/40',
    'danger' => 'bg-red-500/20 border border-red-400/30 text-red-200 hover:bg-red-500/30 focus:ring-red-400',
    'success' => 'bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] hover:bg-[#83b735]/30 focus:ring-[#83b735]',
];
$classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);
if ($block) $classes .= ' w-full';
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
@endif
