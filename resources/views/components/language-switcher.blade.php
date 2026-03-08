@php
    $locales = config('locales.supported', []);
    $current = app()->getLocale();
@endphp
<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button
        type="button"
        @click="open = !open"
        class="flex items-center gap-2 px-3 py-2 rounded-xl backdrop-blur-xl bg-white/10 border border-white/20 text-white/90 hover:bg-white/20 transition-all text-sm"
        aria-haspopup="true"
        :aria-expanded="open"
    >
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
        </svg>
        <span class="hidden sm:inline max-w-[100px] truncate">{{ $locales[$current] ?? 'English' }}</span>
        <svg class="w-4 h-4 shrink-0 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div
        x-show="open"
        x-transition
        x-cloak
        class="absolute right-0 mt-2 w-48 py-1 rounded-xl backdrop-blur-xl bg-white/10 border border-white/20 shadow-xl z-50 overflow-hidden"
        style="display: none;"
    >
        @foreach ($locales as $code => $name)
            <form method="POST" action="{{ route('locale.switch') }}" class="block">
                @csrf
                <input type="hidden" name="locale" value="{{ $code }}">
                <button
                    type="submit"
                    class="w-full text-left px-4 py-2.5 text-sm text-white/90 hover:bg-white/20 transition-colors {{ $code === $current ? 'bg-[#83b735]/30 text-white font-medium' : '' }}"
                >
                    {{ $name }}
                </button>
            </form>
        @endforeach
    </div>
</div>
