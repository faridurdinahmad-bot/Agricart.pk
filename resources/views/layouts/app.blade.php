<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ app()->getLocale() === 'ur' ? 'locale-ur' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    @if(app()->getLocale() === 'ur')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col font-sans antialiased"
      x-data="{ crystal: 'moderate' }"
      x-init="crystal = localStorage.getItem('crystal') || 'moderate'"
      :class="'crystal-' + crystal">
    {{-- Full-page background with overlay --}}
    <div class="fixed inset-0 -z-10">
        <img
            src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&q=80"
            alt="Agriculture background"
            class="w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 via-slate-900/75 to-slate-900/85"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(131,183,53,0.08)_0%,_transparent_50%)]"></div>
    </div>

    {{-- Sticky Glassmorphism Header --}}
    <header class="sticky top-0 z-50 w-full backdrop-blur-xl glass-solid border-b border-white/20 shadow-lg shadow-black/10">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 h-16 lg:h-20">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-xl font-bold text-white">
                <span class="text-[#83b735]">Agricart</span>
                <span>ERP</span>
            </a>
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Crystal level toggle: soft -> moderate -> strong -> soft --}}
                <button type="button"
                        @click="crystal = crystal === 'soft' ? 'moderate' : crystal === 'moderate' ? 'strong' : 'soft'; localStorage.setItem('crystal', crystal)"
                        class="flex items-center justify-center w-9 h-9 rounded-xl backdrop-blur-xl border border-white/20 text-white/90 hover:bg-white/20 hover:text-white transition-all"
                        :title="crystal === 'soft' ? '{{ __('app.dashboard.crystal_soft') }}' : crystal === 'moderate' ? '{{ __('app.dashboard.crystal_moderate') }}' : '{{ __('app.dashboard.crystal_strong') }}'"
                        aria-label="Toggle glass opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </button>
                <x-language-switcher />
                <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2.5 rounded-xl backdrop-blur-xl bg-white/10 border border-white/20 text-white font-medium text-sm hover:bg-white/20 hover:border-white/30 transition-all duration-200">
                        {{ __('app.nav.dashboard') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#83b735] border border-[#83b735] text-white font-semibold text-sm hover:bg-[#6f9d2d] hover:border-[#6f9d2d] transition-all duration-200 shadow-lg shadow-[#83b735]/25">
                            {{ __('app.nav.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2.5 rounded-xl backdrop-blur-xl bg-white/10 border border-white/20 text-white font-medium text-sm hover:bg-white/20 hover:border-white/30 transition-all duration-200">
                        {{ __('app.nav.login') }}
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 rounded-xl bg-[#83b735] border border-[#83b735] text-white font-semibold text-sm hover:bg-[#6f9d2d] hover:border-[#6f9d2d] transition-all duration-200 shadow-lg shadow-[#83b735]/25">
                        {{ __('app.nav.register') }}
                    </a>
                @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="backdrop-blur-xl glass-solid border-t border-white/20 mt-auto">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-2 text-lg font-bold text-white">
                    <span class="text-[#83b735]">Agricart</span>
                    <span>ERP</span>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-6 text-sm">
                    <a href="{{ route('privacy') }}" class="text-white/80 hover:text-white transition-colors">
                        {{ __('app.nav.privacy') }}
                    </a>
                    <a href="{{ route('terms') }}" class="text-white/80 hover:text-white transition-colors">
                        {{ __('app.nav.terms') }}
                    </a>
                </div>
            </div>
            <p class="mt-8 text-center text-sm text-white/60">
                &copy; {{ date('Y') }} Agricart ERP. {{ __('app.footer.copyright') }}
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
