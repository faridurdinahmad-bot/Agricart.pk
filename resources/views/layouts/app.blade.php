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
<body class="min-h-screen flex flex-col font-sans antialiased overflow-x-hidden"
      x-data="{ glassLevel: 40 }"
      x-init="glassLevel = Math.min(100, Math.max(0, parseInt(localStorage.getItem('glassLevel'), 10) || 40))"
      :style="'--glass-from: ' + (0.06 + (glassLevel/100)*0.46) + '; --glass-to: ' + (0.02 + (glassLevel/100)*0.34) + '; --glass-solid: ' + (0.08 + (glassLevel/100)*0.47)">
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
        <nav class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-2 px-4 sm:px-6 lg:px-8 h-auto min-h-[4rem] lg:h-20 py-2 lg:py-0">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-lg sm:text-xl font-bold text-white shrink-0">
                <span class="text-[#83b735]">Agricart</span>
                <span>ERP</span>
            </a>
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap justify-end">
                {{-- Glass opacity: continuous slider — شفاف (0) to گہرا (100) — solid box so label & scale stay readable --}}
                <div class="glass-range-control flex items-center gap-2 sm:gap-3 px-3 py-2 rounded-xl bg-slate-800/95 border border-white/20 shadow-lg"
                     title="{{ __('app.dashboard.glass_opacity') }}">
                    <span class="flex items-center gap-1.5 shrink-0">
                        <svg class="w-4 h-4 text-[#83b735]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-semibold text-white whitespace-nowrap">{{ __('app.dashboard.glass') }}</span>
                    </span>
                    <span class="text-[10px] font-medium text-white/50 shrink-0 w-4 text-left" title="{{ __('app.dashboard.glass_light') }}">0</span>
                    <input type="range"
                           min="0"
                           max="100"
                           x-model.number="glassLevel"
                           @input="localStorage.setItem('glassLevel', glassLevel)"
                           class="glass-range-input w-20 sm:w-28 h-1.5 rounded-full appearance-none cursor-pointer accent-[#83b735]"
                           aria-label="{{ __('app.dashboard.glass_opacity') }}">
                    <span class="text-[10px] font-medium text-white/50 shrink-0 w-4 text-right" title="{{ __('app.dashboard.glass_dark') }}">100</span>
                </div>
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

    <main class="flex-1 w-full min-w-0 overflow-x-hidden">
        <div class="min-h-[calc(100vh-12rem)] w-full">
            @yield('content')
        </div>
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

    {{-- Form submit loading overlay --}}
    <div id="form-loading-overlay" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm pointer-events-none opacity-0 transition-opacity duration-200" aria-hidden="true">
        <div class="flex flex-col items-center gap-3 rounded-2xl bg-slate-800/95 border border-white/20 px-6 py-5 shadow-xl">
            <svg class="h-10 w-10 animate-spin text-[#83b735]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-label="{{ __('app.common.loading') }}">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium text-white/90">{{ __('app.common.loading') }}</span>
        </div>
    </div>
    <script>
        document.addEventListener('submit', function(e) {
            if (e.target.matches('form') && !e.target.dataset.noLoading) {
                var el = document.getElementById('form-loading-overlay');
                if (el) { el.classList.remove('opacity-0'); el.classList.add('opacity-100'); el.style.pointerEvents = 'auto'; }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
