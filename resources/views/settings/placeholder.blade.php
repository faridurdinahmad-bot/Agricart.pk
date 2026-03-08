@extends('layouts.app')

@section('title', $title . ' - Agricart ERP')

@section('content')
<div class="min-h-[calc(100vh-12rem)] flex items-center justify-center py-12 px-4">
    <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-12 text-center max-w-md">
        <h1 class="text-2xl font-bold text-white mb-4">{{ $title }}</h1>
        <p class="text-white/80 mb-8">{{ __('app.settings.coming_soon') }}</p>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#83b735] text-white font-medium hover:bg-[#6f9d2d] transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('app.settings.back_dashboard') }}
        </a>
    </div>
</div>
@endsection
