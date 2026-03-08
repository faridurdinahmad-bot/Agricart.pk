@extends('layouts.app')

@section('title', 'Forgot Password - Agricart ERP')

@section('content')
<div class="min-h-[calc(100vh-12rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <x-card class="shadow-2xl">
            <div class="text-center mb-8">
                <div class="mx-auto w-14 h-14 rounded-full bg-[#83b735]/20 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-[#83b735]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ __('app.forgot.title') }}</h1>
                <p class="mt-2 text-white/80 text-sm">{{ __('app.forgot.subtitle') }}</p>
            </div>

            @if (session('status'))
                <x-alert type="success" class="mb-6">{{ session('status') }}</x-alert>
            @endif

            @if ($errors->any())
                <x-alert type="error" class="mb-6">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </x-alert>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <x-input type="email" name="email" :label="__('app.auth.email')" placeholder="you@example.com" required variant="light" autofocus />
                <x-button type="submit" variant="primary" size="lg" block>{{ __('app.forgot.send') }}</x-button>
            </form>

            <a href="{{ route('login') }}" class="mt-6 flex items-center justify-center gap-2 text-sm text-white/80 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.forgot.back') }}
            </a>
        </x-card>
    </div>
</div>
@endsection
