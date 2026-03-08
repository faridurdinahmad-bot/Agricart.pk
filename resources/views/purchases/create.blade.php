@extends('layouts.app')

@section('title', ($type === 'direct' ? __('app.purchase.add_direct') : __('app.purchase.add_order')) . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('purchases.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $type === 'direct' ? __('app.purchase.add_direct') : __('app.purchase.add_order') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('purchases.store') }}" x-data="{ items: [{ product_id: '', quantity: 1, rate: 0 }] }">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.purchase.vendor') }} *</label>
                        <select name="vendor_id" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="">{{ __('app.purchase.select_vendor') }}</option>
                            @foreach($vendors as $v)
                            <option value="{{ $v->id }}" {{ old('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.purchase.date') }} *</label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                </div>
                @if($type === 'order')
                <div class="mb-6">
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.purchase.expected_date') }}</label>
                    <input type="date" name="expected_date" value="{{ old('expected_date') }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                </div>
                @endif
                <div class="mb-6">
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.purchase.notes') }}</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">{{ old('notes') }}</textarea>
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
                        <tbody x-ref="itemsBody">
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="border-b border-white/10">
                                    <td class="px-3 py-2">
                                        <select :name="'items[' + index + '][product_id]'" required class="w-full px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white product-select">
                                            <option value="">{{ __('app.purchase.select_product') }}</option>
                                            @foreach($products as $pr)
                                            <option value="{{ $pr->id }}" data-rate="{{ $pr->purchase_price }}">{{ $pr->name }} ({{ $pr->sku }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" step="0.01" min="0.01" required class="w-full px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white qty-input">
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

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d]">{{ __('app.purchase.save') }}</button>
                    <a href="{{ route('purchases.index') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.purchase.cancel') }}</a>
                </div>
            </form>
        </div>
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
