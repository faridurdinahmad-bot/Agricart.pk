@extends('layouts.app')

@section('title', __('app.inventory.product_catalog') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.inventory.product_catalog')">
            <x-slot:actions>
                <x-button href="{{ route('products.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.inventory.add_product') }}
                </x-button>
                <x-button href="{{ route('products.index', array_filter(['import' => 1, 'status' => request('status')])) }}" variant="secondary">{{ __('app.inventory.import_products') }}</x-button>
                <x-button href="{{ route('products.export') }}" variant="secondary">{{ __('app.inventory.export_products') }}</x-button>
                <x-button href="{{ route('categories.index') }}" variant="secondary">{{ __('app.inventory.categories') }}</x-button>
                <x-button href="{{ route('units.index') }}" variant="secondary">{{ __('app.inventory.units') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(request('import'))
        <x-card :title="__('app.inventory.import_products')" class="mb-6">
            <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">CSV File</label>
                    <input type="file" name="file" accept=".csv,.txt" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#83b735] file:text-white file:text-sm file:font-medium">
                    <p class="mt-1.5 text-xs text-white/60">Columns: sku, name, unit, category, brand, purchase_price, sale_price, quantity, reorder_level</p>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit" variant="primary">{{ __('app.inventory.import_products') }}</x-button>
                    <x-button :href="route('products.index', array_filter(['status' => request('status')]))" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
        @endif

        <div class="flex gap-2 mb-4">
            <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('status') ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80 hover:bg-white/10' }}">{{ __('app.inventory.active') }}</a>
            <a href="{{ route('products.index', ['status' => 'inactive']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'inactive' ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80 hover:bg-white/10' }}">{{ __('app.inventory.inactive') }}</a>
            <a href="{{ route('products.index', array_merge(request()->query(), ['low_stock' => 1])) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('low_stock') ? 'bg-amber-500/20 text-amber-400 border border-amber-400/40' : 'glass-solid border border-white/20 text-white/80 hover:bg-white/10' }}">{{ __('app.inventory.low_stock') }}</a>
        </div>

        <form method="GET" class="mb-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="low_stock" value="{{ request('low_stock') }}">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('app.inventory.search') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 w-full max-w-xs">
        </form>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px]">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.inventory.sku') }}</th>
                            <th>{{ __('app.inventory.name') }}</th>
                            <th>{{ __('app.inventory.category') }}</th>
                            <th>{{ __('app.inventory.unit') }}</th>
                            <th>{{ __('app.inventory.quantity') }}</th>
                            <th>{{ __('app.inventory.sale_price') }}</th>
                            <th>{{ __('app.staff.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr class="table-row {{ $p->isLowStock() ? 'bg-amber-500/5' : '' }}">
                            <td class="px-4 py-3 text-sm font-mono text-white/90">{{ $p->sku }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $p->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->unit?->symbol ?? $p->unit?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="text-sm {{ $p->isLowStock() ? 'text-amber-400 font-medium' : 'text-white/90' }}">{{ $p->quantity }}</span>
                                @if($p->isLowStock())
                                <span class="text-xs text-amber-400">(Low)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-[#83b735]">{{ number_format($p->sale_price, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $p->status === 'active' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($p->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('products.edit', $p) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20 hover:text-[#83b735] transition-all">{{ __('app.inventory.edit') }}</a>
                                    @if($p->isActive())
                                    <form method="POST" action="{{ route('products.deactivate', $p) }}" class="inline" onsubmit="return confirm('{{ __('app.inventory.deactivate_product') }}?');">@csrf<button type="submit" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-red-500/20 hover:text-red-400 transition-all">{{ __('app.inventory.deactivate') }}</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8"><x-empty-state :message="request('search') ? __('app.common.no_search_results') : __('app.inventory.no_products')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $products->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
