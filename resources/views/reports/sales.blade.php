@extends('layouts.app')

@section('title', __('app.reports.sales') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.reports.sales') }}</h1>
        </div>

        <form method="GET" class="mb-6 flex flex-wrap gap-2">
            <input type="date" name="from" value="{{ $from }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to" value="{{ $to }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">{{ __('app.reports.filter') }}</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.total_sales') }}</p>
                <p class="text-2xl font-bold text-[#83b735]">{{ number_format($totalSales, 2) }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.sales_count') }}</p>
                <p class="text-2xl font-bold text-white/90">{{ $count }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.returns_total') }}</p>
                <p class="text-2xl font-bold text-red-400">{{ number_format($returnsTotal, 2) }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.net_sales') }}</p>
                <p class="text-2xl font-bold text-[#83b735]">{{ number_format($totalSales - $returnsTotal, 2) }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('sales.index') }}" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.menu.reports_menu.view_sales') }}</a>
            <a href="{{ route('sale-returns.index') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.view_sale_returns') }}</a>
        </div>
    </div>
</div>
@endsection
