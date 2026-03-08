@props(['type' => 'success', 'dismissible' => false])

@php
$styles = [
    'success' => 'bg-[#83b735]/20 border-[#83b735]/40 text-[#83b735]',
    'error' => 'bg-red-500/20 border-red-400/30 text-red-200',
    'warning' => 'bg-amber-500/20 border-amber-400/30 text-amber-200',
    'info' => 'bg-blue-500/20 border-blue-400/30 text-blue-200',
];
$style = $styles[$type] ?? $styles['success'];
@endphp

<div {{ $attributes->merge(['class' => "p-4 rounded-xl border {$style}"]) }} role="alert">
    <div class="flex items-start gap-3">
        @if($type === 'error')
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
        </svg>
        @elseif($type === 'success')
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
        </svg>
        @endif
        <div class="flex-1 text-sm">{{ $slot }}</div>
    </div>
</div>
