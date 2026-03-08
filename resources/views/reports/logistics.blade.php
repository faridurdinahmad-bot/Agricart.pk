@extends('layouts.app')

@section('title', __('app.reports.logistics') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-back :href="route('dashboard')" :title="__('app.reports.logistics')" />

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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <x-metric-card :label="__('app.reports.carriers')" :value="$carriersCount" />
            <x-metric-card :label="__('app.reports.shipments')" :value="$shipmentsCount" />
            <x-metric-card :label="__('app.reports.pending_shipments')" :value="$pendingShipments" :variant="$pendingShipments > 0 ? 'warning' : 'default'" />
            <x-metric-card :label="__('app.reports.delivered')" :value="$deliveredCount" variant="success" />
            <x-metric-card :label="__('app.reports.logistics_costs') . ' (' . $from . ' - ' . $to . ')'" :value="number_format($totalCosts, 2)" variant="danger" />
        </div>

        <div class="flex flex-wrap gap-2">
            <x-button href="{{ route('shipments.index') }}" variant="primary">{{ __('app.menu.reports_menu.view_shipments') }}</x-button>
            <x-button href="{{ route('shipping-carriers.index') }}" variant="secondary">{{ __('app.menu.reports_menu.view_carriers') }}</x-button>
            <x-button href="{{ route('logistics-costs.index') }}" variant="secondary">{{ __('app.menu.reports_menu.view_logistics_costs') }}</x-button>
        </div>
    </div>
</div>
@endsection
