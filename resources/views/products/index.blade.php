@extends('layouts.app')

@section('title', __('app.inventory.product_catalog') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.inventory.product_catalog') }}</h1>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.inventory.add_product') }}
                </a>
                <a href="{{ route('products.index', array_filter(['import' => 1, 'status' => request('status')])) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    {{ __('app.inventory.import_products') }}
                </a>
                <a href="{{ route('products.export') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    {{ __('app.inventory.export_products') }}
                </a>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    {{ __('app.inventory.categories') }}
                </a>
                <a href="{{ route('units.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    {{ __('app.inventory.units') }}
                </a>
            </div>
        </div>

        @if(request('import'))
        <div class="mb-6 backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <h2 class="text-lg font-bold text-white mb-4">{{ __('app.inventory.import_products') }}</h2>
            <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">CSV File</label>
                    <input type="file" name="file" accept=".csv,.txt" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#83b735] file:text-white file:text-sm">
                    <p class="mt-1.5 text-xs text-white/60">Columns: sku, name, unit, category, brand, purchase_price, sale_price, quantity, reorder_level</p>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d]">{{ __('app.inventory.import_products') }}</button>
                    <a href="{{ route('products.index', array_filter(['status' => request('status')])) }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.inventory.cancel') }}</a>
                </div>
            </form>
        </div>
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
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.sku') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.category') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.unit') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.quantity') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.inventory.sale_price') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.status') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr class="border-b border-white/10 hover:bg-white/5 {{ $p->isLowStock() ? 'bg-amber-500/5' : '' }}">
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
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $p->status === 'active' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-white/20 text-white/70' }}">{{ ucfirst($p->status) }}</span>
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
                        <tr><td colspan="8" class="px-4 py-12 text-center text-white/60">{{ __('app.inventory.no_products') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
