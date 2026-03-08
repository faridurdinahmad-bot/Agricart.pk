@props(['href', 'title'])

<div class="flex items-center gap-3 mb-6">
    <a href="{{ $href }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:ring-offset-2 focus:ring-offset-transparent" aria-label="{{ __('app.common.back') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
    </a>
    <h1 class="page-heading">{{ $title }}</h1>
</div>
