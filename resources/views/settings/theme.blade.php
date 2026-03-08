@extends('layouts.app')

@section('title', __('app.menu.sub_settings.theme_settings') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('dashboard')" :title="__('app.menu.sub_settings.theme_settings')" />

        <x-card>
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
        </x-card>
    </div>
</div>
@endsection
