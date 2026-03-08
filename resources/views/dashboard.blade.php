@extends('layouts.app')

@section('title', 'Dashboard - Agricart ERP')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-white">{{ __('app.dashboard.welcome') }}, {{ auth()->user()->name }}!</h1>
            <p class="mt-2 text-white/80">{{ __('app.dashboard.subtitle') }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl backdrop-blur-xl bg-white/10 border border-white/20 text-white hover:bg-white/20 transition-colors">
                    {{ __('app.nav.logout') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
