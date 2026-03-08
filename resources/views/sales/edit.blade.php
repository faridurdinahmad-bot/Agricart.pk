@extends('layouts.app')

@section('title', __('app.sale.edit_sale') . ' - ' . $sale->reference_number . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-4xl mx-auto">
        <x-page-back :href="route('sales.show', $sale)" :title="__('app.sale.edit_sale') . ' - ' . $sale->reference_number" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('sales.update', $sale) }}" x-data="{ items: {{ json_encode($sale->items->map(fn($i) => ['product_id' => (string)$i->product_id, 'quantity' => $i->quantity, 'rate' => $i->rate])->values()) }} }">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <x-select name="customer_id" :label="__('app.sale.customer') . ' *'" required>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id', $sale->customer_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input type="date" name="date" :label="__('app.sale.date') . ' *'" :value="old('date', $sale->date->format('Y-m-d'))" required />
                </div>
                <div class="mb-6">
                    <x-input type="date" name="due_date" :label="__('app.sale.due_date')" :value="old('due_date', $sale->due_date?->format('Y-m-d'))" />
                </div>
                <div class="mb-6">
                    <x-input type="textarea" name="notes" :label="__('app.sale.notes')" :rows="2">{{ old('notes', $sale->notes) }}</x-input>
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-white/90">{{ __('app.sale.items') }}</h3>
                    <button type="button" @click="items.push({ product_id: '', quantity: 1, rate: 0 })" class="px-3 py-1.5 rounded-lg bg-[#83b735]/20 text-[#83b735] text-sm hover:bg-[#83b735]/30">+ {{ __('app.sale.add_row') }}</button>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/20">
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90">{{ __('app.inventory.product_catalog') }}</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90 w-24">{{ __('app.inventory.quantity') }}</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90 w-28">{{ __('app.sale.rate') }}</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90 w-28">{{ __('app.sale.amount') }}</th>
                                <th class="px-3 py-2 w-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="border-b border-white/10">
                                    <td class="px-3 py-2">
                                        <select :name="'items[' + index + '][product_id]'" x-model="item.product_id" required class="w-full px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white product-select">
                                            <option value="">{{ __('app.sale.select_product') }}</option>
                                            @foreach($products as $pr)
                                            <option value="{{ $pr->id }}" data-rate="{{ $pr->sale_price }}">{{ $pr->name }} ({{ $pr->sku }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" step="0.01" min="0.01" required class="w-full px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" :name="'items[' + index + '][rate]'" x-model="item.rate" step="0.01" min="0" required class="w-full px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white rate-input">
                                    </td>
                                    <td class="px-3 py-2 text-white/90 text-sm" x-text="(parseFloat(item.quantity) || 0) * (parseFloat(item.rate) || 0)"></td>
                                    <td class="px-3 py-2">
                                        <button type="button" @click="items.length > 1 && items.splice(index, 1)" class="p-1.5 rounded-lg text-red-400 hover:bg-red-500/20" :disabled="items.length <= 1">×</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <x-button type="submit" name="action" value="complete" variant="primary">{{ __('app.sale.complete_sale') }}</x-button>
                    <x-button type="submit" name="action" value="hold" variant="secondary">{{ __('app.sale.hold_invoice') }}</x-button>
                    <x-button :href="route('sales.show', $sale)" variant="secondary">{{ __('app.sale.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form')?.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select') && e.target.value) {
            const opt = e.target.options[e.target.selectedIndex];
            const rate = opt?.dataset?.rate || 0;
            const row = e.target.closest('tr');
            const rateInput = row?.querySelector('.rate-input');
            if (rateInput && parseFloat(rateInput.value) === 0) rateInput.value = rate;
        }
    });
});
</script>
@endsection
