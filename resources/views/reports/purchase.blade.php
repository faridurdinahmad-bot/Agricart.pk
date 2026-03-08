@extends('layouts.app')

@section('title', __('app.reports.purchase') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-back :href="route('dashboard')" :title="__('app.reports.purchase')" />

        <form method="GET" class="mb-6 flex flex-wrap gap-2 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-medium text-white/70">From</label>
                <input type="date" name="from" value="{{ $from }}" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-[#83b735]">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-medium text-white/70">To</label>
                <input type="date" name="to" value="{{ $to }}" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-[#83b735]">
            </div>
            <x-button type="submit" variant="primary">{{ __('app.reports.filter') }}</x-button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <x-metric-card :label="__('app.reports.total_purchases')" :value="number_format($totalPurchases, 2)" variant="success" />
            <x-metric-card :label="__('app.reports.purchases_count')" :value="$count" />
        </div>

        <div class="flex gap-2">
            <x-button href="{{ route('purchases.index') }}" variant="primary">{{ __('app.menu.reports_menu.view_purchases') }}</x-button>
            <x-button href="{{ route('purchase-returns.index') }}" variant="secondary">{{ __('app.menu.reports_menu.view_purchase_returns') }}</x-button>
        </div>
    </div>
</div>
@endsection
