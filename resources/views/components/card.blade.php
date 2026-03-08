@props(['title' => null, 'padding' => true])

<div {{ $attributes->merge(['class' => 'backdrop-blur-xl glass-panel border border-white/25 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.25),0_0_0_1px_rgba(255,255,255,0.05)_inset] overflow-hidden']) }}>
    @if($title)
    <div class="px-4 sm:px-5 md:px-6 pt-4 sm:pt-5 md:pt-6 pb-3 border-b border-white/20 bg-white/5">
        <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
            <span class="w-1 h-5 rounded-full bg-[#83b735]"></span>
            {{ $title }}
        </h2>
    </div>
    @endif
    <div class="{{ $padding ? 'p-4 sm:p-5 md:p-6' : '' }}">
        {{ $slot }}
    </div>
</div>
