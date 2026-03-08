@extends('layouts.app')

@section('title', 'Login - Agricart ERP')

@section('content')
<div class="flex items-center justify-center py-6 sm:py-8 md:py-10 lg:py-12 px-4 sm:px-6 min-h-[calc(100vh-8rem)]">
    <div class="w-full max-w-[340px] sm:max-w-[380px] md:max-w-[400px]">
        {{-- Login Card - Compact & Responsive --}}
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl shadow-2xl p-5 sm:p-6 md:p-7">
            {{-- Header --}}
            <div class="text-center mb-5 sm:mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.auth.welcome_back') }}</h1>
                <p class="mt-1.5 text-white/80 text-xs sm:text-sm">{{ __('app.auth.sign_in_subtitle') }}</p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 sm:p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-red-200">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-medium text-white/90 mb-1.5">{{ __('app.auth.email') }}</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="you@example.com"
                        class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-xl bg-white/90 border border-white/30 text-slate-900 text-sm sm:text-base placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:border-transparent transition-all"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs sm:text-sm font-medium text-white/90 mb-1.5">{{ __('app.auth.password') }}</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 pr-11 sm:pr-12 rounded-xl bg-white/90 border border-white/30 text-slate-900 text-sm sm:text-base placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:border-transparent transition-all"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-500 hover:text-slate-700 focus:outline-none rounded-lg hover:bg-white/50 transition-colors"
                            title="Show/Hide password"
                            aria-label="Toggle password visibility"
                        >
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded border-white/30 bg-white/20 text-[#83b735] focus:ring-[#83b735] focus:ring-offset-0"
                        >
                        <span class="text-xs sm:text-sm text-white/90 group-hover:text-white transition-colors">{{ __('app.auth.remember') }}</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs sm:text-sm text-[#83b735] hover:text-[#6f9d2d] font-medium transition-colors">
                        {{ __('app.auth.forgot_password') }}
                    </a>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full py-3 sm:py-3.5 px-4 rounded-xl bg-[#83b735] text-white text-sm sm:text-base font-semibold hover:bg-[#6f9d2d] focus:outline-none focus:ring-2 focus:ring-[#83b735] focus:ring-offset-2 focus:ring-offset-transparent transition-all duration-200 shadow-lg shadow-[#83b735]/25"
                >
                    {{ __('app.auth.sign_in') }}
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative my-5 sm:my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/20"></div>
                </div>
                <div class="relative flex justify-center text-xs sm:text-sm">
                    <span class="px-3 bg-transparent text-white/60">{{ __('app.auth.or_continue') }}</span>
                </div>
            </div>

            {{-- Social Login - Google Only --}}
            <a href="#" class="flex items-center justify-center gap-2 py-2.5 sm:py-3 px-4 rounded-xl backdrop-blur-xl bg-white/10 border border-white/20 text-white text-sm sm:text-base font-medium hover:bg-white/20 transition-all duration-200 w-full">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                {{ __('app.auth.continue_google') }}
            </a>

            {{-- Register Link --}}
            <p class="mt-5 sm:mt-6 text-center text-xs sm:text-sm text-white/80">
                {{ __('app.auth.no_account') }}
                <a href="{{ route('register') }}" class="font-semibold text-[#83b735] hover:text-[#6f9d2d] transition-colors">
                    {{ __('app.auth.create_account') }}
                </a>
            </p>
        </div>

        {{-- Security Note --}}
        <p class="mt-4 sm:mt-5 text-center text-[10px] sm:text-xs text-white/50">
            <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
            {{ __('app.auth.security_note') }}
        </p>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');

    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeOffIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeOffIcon.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
