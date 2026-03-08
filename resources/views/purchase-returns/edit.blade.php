@extends('layouts.app')

@section('title', __('app.purchase.edit_return') . ' - ' . $purchaseReturn->reference_number . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-4xl mx-auto">
        <x-page-back :href="route('purchase-returns.show', $purchaseReturn)" :title="__('app.purchase.edit_return') . ' - ' . $purchaseReturn->reference_number" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('purchase-returns.update', $purchaseReturn) }}" x-data="{ items: {{ json_encode($purchaseReturn->items->map(fn($i) => ['product_id' => (string)$i->product_id, 'quantity' => $i->quantity, 'rate' => $i->rate])->values()) }} }">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <x-select name="vendor_id" :label="__('app.purchase.vendor') . ' *'" required>
                        @foreach($vendors as $v)
                        <option value="{{ $v->id }}" {{ old('vendor_id', $purchaseReturn->vendor_id) == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input type="date" name="date" :label="__('app.purchase.date') . ' *'" :value="old('date', $purchaseReturn->date->format('Y-m-d'))" required />
                </div>
                <div class="mb-6">
                    <x-input type="textarea" name="reason" :label="__('app.purchase.reason')" :rows="2">{{ old('reason', $purchaseReturn->reason) }}</x-input>
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-white/90">{{ __('app.purchase.items') }}</h3>
                    <button type="button" @click="items.push({ product_id: '', quantity: 1, rate: 0 })" class="px-3 py-1.5 rounded-lg bg-[#83b735]/20 text-[#83b735] text-sm hover:bg-[#83b735]/30">+ {{ __('app.purchase.add_row') }}</button>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/20">
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90">{{ __('app.inventory.product_catalog') }}</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90 w-24">{{ __('app.inventory.quantity') }}</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90 w-28">{{ __('app.purchase.rate') }}</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-white/90 w-28">{{ __('app.purchase.amount') }}</th>
                                <th class="px-3 py-2 w-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="border-b border-white/10">
                                    <td class="px-3 py-2">
                                        <select :name="'items[' + index + '][product_id]'" x-model="item.product_id" required class="w-full px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white product-select">
                                            <option value="">{{ __('app.purchase.select_product') }}</option>
                                            @foreach($products as $pr)
                                            <option value="{{ $pr->id }}" data-rate="{{ $pr->purchase_price }}">{{ $pr->name }} ({{ $pr->sku }})</option>
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

                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.purchase.update') }}</x-button>
                    <x-button :href="route('purchase-returns.show', $purchaseReturn)" variant="secondary">{{ __('app.purchase.cancel') }}</x-button>
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
