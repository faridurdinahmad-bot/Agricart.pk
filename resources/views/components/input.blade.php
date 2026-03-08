@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'type' => 'text',
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'variant' => 'default',
])

@php
$id = $id ?? $name;
$inputClass = 'w-full px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:border-transparent transition-all';
$inputClass .= $variant === 'light' ? ' bg-white/90 border border-white/30 text-slate-900 placeholder-slate-500' : ' bg-white/10 border border-white/20 text-white placeholder-white/50';
if ($error) $inputClass .= ' border-red-400/50 focus:ring-red-400';
if ($disabled) $inputClass .= ' opacity-60 cursor-not-allowed';
@endphp

<div>
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-white/90 mb-1.5">
        {{ $label }}
        @if($required)<span class="text-red-400">*</span>@endif
    </label>
    @endif
    @if($type === 'textarea')
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        rows="{{ $attributes->get('rows', 3) }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->except('value', 'rows')->merge(['class' => $inputClass]) }}
    >{{ $slot ?? '' }}</textarea>
    @else
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $attributes->get('value') ?? old($name) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->except('value')->merge(['class' => $inputClass]) }}
    >
    @endif
    @if($error)
    <p class="mt-1 text-sm text-red-300">{{ $error }}</p>
    @endif
</div>
