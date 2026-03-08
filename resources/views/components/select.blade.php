@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
])

@php
$id = $id ?? $name;
$selectClass = 'w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:border-transparent transition-all';
if ($error) $selectClass .= ' border-red-400/50 focus:ring-red-400';
if ($disabled) $selectClass .= ' opacity-60 cursor-not-allowed';
@endphp

<div>
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-white/90 mb-1.5">
        {{ $label }}
        @if($required)<span class="text-red-400">*</span>@endif
    </label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $selectClass]) }}
    >
        {{ $slot }}
    </select>
    @if($error)
    <p class="mt-1 text-sm text-red-300">{{ $error }}</p>
    @endif
</div>
