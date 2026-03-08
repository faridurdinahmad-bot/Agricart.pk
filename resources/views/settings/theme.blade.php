@extends('layouts.app')

@section('title', __('app.menu.sub_settings.theme_settings') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.menu.sub_settings.theme_settings') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-white/90 mb-3">{{ __('app.settings.language') }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(config('locales.supported', ['en' => 'English']) as $code => $name)
                        <form method="POST" action="{{ route('locale.switch') }}" class="inline">
                            @csrf
                            <input type="hidden" name="locale" value="{{ $code }}">
                            <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-medium {{ app()->getLocale() === $code ? 'bg-[#83b735] text-white' : 'bg-white/10 border border-white/20 text-white/90 hover:bg-white/20' }} transition-all">
                                {{ $name }}
                            </button>
                        </form>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white/90 mb-3">{{ __('app.settings.theme') }}</h3>
                    <p class="text-sm text-white/70">{{ __('app.settings.theme_note') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
