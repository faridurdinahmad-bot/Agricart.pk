@extends('layouts.app')

@section('title', 'Agricart ERP - Streamline Your Agricultural Business')

@section('content')
    {{-- Hero Section --}}
    <section class="relative py-20 sm:py-28 lg:py-36 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="backdrop-blur-xl glass-solid border border-white/20 rounded-2xl lg:rounded-3xl p-8 sm:p-12 lg:p-16 text-center shadow-2xl">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    {{ __('app.hero.title') }}
                    <span class="text-[#83b735]">{{ __('app.hero.title_highlight') }}</span>
                    <br>{{ __('app.hero.title_end') }}
                </h1>
                <p class="text-lg sm:text-xl text-white/90 max-w-2xl mx-auto mb-10 leading-relaxed">
                    {{ __('app.hero.description') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-8 py-4 rounded-xl bg-[#83b735] text-white font-semibold text-lg hover:bg-[#6f9d2d] transition-all duration-200 shadow-lg shadow-[#83b735]/30">
                        {{ __('app.hero.get_started') }}
                    </a>
                    <a href="#features"
                       class="inline-flex items-center justify-center px-8 py-4 rounded-xl backdrop-blur-xl glass-solid border border-white/20 text-white font-medium hover:bg-white/20 transition-all duration-200">
                        {{ __('app.hero.explore_features') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="relative py-16 sm:py-24 lg:py-32 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                    {{ __('app.features.title') }}
                </h2>
                <p class="text-lg text-white/80 max-w-2xl mx-auto">
                    {{ __('app.features.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                {{-- Inventory Card --}}
                <div class="backdrop-blur-xl glass-solid border border-white/20 rounded-2xl p-8 hover:bg-white/15 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#83b735]/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-[#83b735]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8 4-8-4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ __('app.features.inventory.title') }}</h3>
                    <p class="text-white/80 leading-relaxed">
                        {{ __('app.features.inventory.description') }}
                    </p>
                </div>

                {{-- Sales Card --}}
                <div class="backdrop-blur-xl glass-solid border border-white/20 rounded-2xl p-8 hover:bg-white/15 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#83b735]/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-[#83b735]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ __('app.features.sales.title') }}</h3>
                    <p class="text-white/80 leading-relaxed">
                        {{ __('app.features.sales.description') }}
                    </p>
                </div>

                {{-- Vendor Management Card --}}
                <div class="backdrop-blur-xl glass-solid border border-white/20 rounded-2xl p-8 hover:bg-white/15 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#83b735]/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-[#83b735]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ __('app.features.vendor.title') }}</h3>
                    <p class="text-white/80 leading-relaxed">
                        {{ __('app.features.vendor.description') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
