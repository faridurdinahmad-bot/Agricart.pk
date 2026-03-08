@extends('layouts.app')

@section('title', __('app.reports.purchase') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.reports.purchase') }}</h1>
        </div>

        <form method="GET" class="mb-6 flex flex-wrap gap-2">
            <input type="date" name="from" value="{{ $from }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to" value="{{ $to }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">{{ __('app.reports.filter') }}</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.total_purchases') }}</p>
                <p class="text-2xl font-bold text-[#83b735]">{{ number_format($totalPurchases, 2) }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.purchases_count') }}</p>
                <p class="text-2xl font-bold text-white/90">{{ $count }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('purchases.index') }}" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.menu.reports_menu.view_purchases') }}</a>
            <a href="{{ route('purchase-returns.index') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.view_purchase_returns') }}</a>
        </div>
    </div>
</div>
@endsection
