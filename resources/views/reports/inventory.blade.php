@extends('layouts.app')

@section('title', __('app.reports.inventory') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.reports.inventory') }}</h1>
        </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.total_inventory_value') }}</p>
                <p class="text-2xl font-bold text-[#83b735]">{{ number_format($totalValue, 2) }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.products_count') }}</p>
                <p class="text-2xl font-bold text-white/90">{{ $productsCount }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.low_stock_items') }}</p>
                <p class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-400' : 'text-white/90' }}">{{ $lowStockCount }}</p>
            </div>
        </div>

        <div class="flex gap-2 mb-6">
            <a href="{{ route('products.index') }}" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.menu.reports_menu.view_products') }}</a>
            <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.low_stock') }}</a>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-white/20">
                <h3 class="text-sm font-bold text-white/90">{{ __('app.reports.products_count') }} ({{ $productsCount }})</h3>
            </div>
            <div class="overflow-x-auto max-h-96 overflow-y-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.quantity') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.reorder_level') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.purchase_price') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products->take(50) as $p)
                        <tr class="border-b border-white/10 hover:bg-white/5">
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
                        <tr><td colspan="5" class="px-4 py-12 text-center text-white/60">{{ __('app.inventory.no_products') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($productsCount > 100)
            <div class="px-4 py-2 border-t border-white/10 text-sm text-white/60">{{ __('app.reports.products_count') }}: {{ $productsCount }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
