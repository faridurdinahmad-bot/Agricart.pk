@extends('layouts.app')

@section('title', 'Terms & Conditions - Agricart ERP')

@section('content')
<div class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-4xl">
        <div class="backdrop-blur-xl glass-solid border border-white/20 rounded-2xl p-8 sm:p-12 lg:p-16">
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-8">{{ __('app.terms.title') }}</h1>
            <p class="text-white/80 mb-6">{{ __('app.terms.last_updated') }}: {{ now()->translatedFormat('F j, Y') }}</p>

            <div class="prose prose-invert prose-lg max-w-none space-y-6 text-white/90">
                <h2 class="text-xl font-semibold text-white mt-8 mb-4">{{ __('app.terms.section1_title') }}</h2>
                <p>{{ __('app.terms.section1_text') }}</p>

                <h2 class="text-xl font-semibold text-white mt-8 mb-4">{{ __('app.terms.section2_title') }}</h2>
                <p>{{ __('app.terms.section2_text') }}</p>

                <h2 class="text-xl font-semibold text-white mt-8 mb-4">{{ __('app.terms.section3_title') }}</h2>
                <p>{{ __('app.terms.section3_text') }}</p>

                <h2 class="text-xl font-semibold text-white mt-8 mb-4">{{ __('app.terms.section4_title') }}</h2>
                <p>{{ __('app.terms.section4_text') }}</p>

                <h2 class="text-xl font-semibold text-white mt-8 mb-4">{{ __('app.terms.section5_title') }}</h2>
                <p>{{ __('app.terms.section5_text') }}</p>

                <h2 class="text-xl font-semibold text-white mt-8 mb-4">{{ __('app.terms.section6_title') }}</h2>
                <p>{{ __('app.terms.section6_text') }}</p>
            </div>

            <a href="{{ url('/') }}" class="inline-flex items-center mt-10 text-[#83b735] hover:text-[#6f9d2d] font-medium transition-colors">
                &larr; {{ __('app.terms.back_home') }}
            </a>
        </div>
    </div>
</div>
@endsection
