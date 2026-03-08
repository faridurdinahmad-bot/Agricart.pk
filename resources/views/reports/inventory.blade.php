@extends('layouts.app')

@section('title', __('app.reports.inventory') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-back :href="route('dashboard')" :title="__('app.reports.inventory')" />

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <x-metric-card :label="__('app.reports.total_inventory_value')" :value="number_format($totalValue, 2)" variant="success" />
            <x-metric-card :label="__('app.reports.products_count')" :value="$productsCount" />
            <x-metric-card :label="__('app.reports.low_stock_items')" :value="$lowStockCount" :variant="$lowStockCount > 0 ? 'danger' : 'default'" />
        </div>

        <div class="flex gap-2 mb-6">
            <x-button href="{{ route('products.index') }}" variant="primary">{{ __('app.menu.reports_menu.view_products') }}</x-button>
            <x-button href="{{ route('products.index', ['low_stock' => 1]) }}" variant="secondary">{{ __('app.menu.reports_menu.low_stock') }}</x-button>
        </div>

        <x-card :padding="false" class="overflow-hidden">
            <div class="px-4 py-3 border-b border-white/20">
                <h3 class="text-sm font-bold text-white/90">{{ __('app.reports.products_count') }} ({{ $productsCount }})</h3>
            </div>
            <div class="overflow-x-auto max-h-96 overflow-y-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.quantity') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.reorder_level') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.purchase_price') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products->take(50) as $p)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $p->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->reorder_level ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90 text-right">{{ number_format($p->purchase_price, 2) }}</td>
                            <td class="px-4 py-3">
                                @if($p->reorder_level > 0 && $p->quantity <= $p->reorder_level)
                                <span class="px-2 py-0.5 rounded-full text-xs bg-red-500/20 text-red-400">{{ __('app.inventory.low_stock') }}</span>
                                @else
                                <span class="px-2 py-0.5 rounded-full text-xs bg-[#83b735]/20 text-[#83b735]">OK</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5"><x-empty-state :message="__('app.inventory.no_products')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($productsCount > 100)
            <div class="px-4 py-2 border-t border-white/10 text-sm text-white/60">{{ __('app.reports.products_count') }}: {{ $productsCount }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
