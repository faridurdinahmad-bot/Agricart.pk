@extends('layouts.app')

@section('title', __('app.menu.sub_settings.business_profile') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.menu.sub_settings.business_profile') }}</h1>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('settings.business.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.settings.business_name') }} *</label>
                    <input type="text" name="name" value="{{ old('name', $business['name']) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.settings.email') }}</label>
                        <input type="email" name="email" value="{{ old('email', $business['email']) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.settings.phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $business['phone']) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.settings.address') }}</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">{{ old('address', $business['address']) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.settings.tax_number') }}</label>
                    <input type="text" name="tax_number" value="{{ old('tax_number', $business['tax_number']) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d] transition-all">{{ __('app.settings.save') }}</button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20 transition-all">{{ __('app.settings.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
