@extends('layouts.app')

@section('title', 'Forgot Password - Agricart ERP')

@section('content')
<div class="min-h-[calc(100vh-12rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl shadow-2xl p-8 sm:p-10">
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
                <div class="mb-6 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/30 text-[#83b735] text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30 text-red-200 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.auth.email') }}</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="you@example.com"
                        class="w-full px-4 py-3 rounded-xl bg-white/90 border border-white/30 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:border-transparent"
                    >
                </div>
                <button
                    type="submit"
                    class="w-full py-3.5 px-4 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d] focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:ring-offset-2 transition-all shadow-lg shadow-[#83b735]/25"
                >
                    {{ __('app.forgot.send') }}
                </button>
            </form>

            <a href="{{ route('login') }}" class="mt-6 flex items-center justify-center gap-2 text-sm text-white/80 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.forgot.back') }}
            </a>
        </div>
    </div>
</div>
@endsection
