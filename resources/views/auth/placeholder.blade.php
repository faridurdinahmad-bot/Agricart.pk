@extends('layouts.app')

@section('title', 'Register - Agricart ERP')

@section('content')
<div class="min-h-[calc(100vh-12rem)] flex items-center justify-center py-12 px-4">
    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl p-12 text-center max-w-md">
        <h1 class="text-2xl font-bold text-white mb-4">{{ __('app.register.title') }}</h1>
        <p class="text-white/80 mb-8">{{ __('app.register.coming_soon') }}</p>
        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-[#83b735] text-white font-medium hover:bg-[#6f9d2d] transition-colors">
            {{ __('app.register.back_login') }}
        </a>
    </div>
</div>
@endsection
