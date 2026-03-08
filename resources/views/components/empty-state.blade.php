@props(['message', 'icon' => null])

<div class="flex flex-col items-center justify-center py-12 px-4 text-center">
    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-4">
        @if($icon)
            {{ $icon }}
        @else
        <svg class="w-7 h-7 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        @endif
    </div>
    <p class="text-sm text-white/60 max-w-sm">{{ $message }}</p>
    @if(isset($slot) && trim($slot) !== '')
    <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
