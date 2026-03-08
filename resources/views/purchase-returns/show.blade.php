@extends('layouts.app')

@section('title', $purchaseReturn->reference_number . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('purchase-returns.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $purchaseReturn->reference_number }}</h1>
                    <p class="text-sm text-white/60">{{ $purchaseReturn->vendor->name }} • {{ $purchaseReturn->date->format('d M Y') }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                @if($purchaseReturn->status === 'draft')
                <a href="{{ route('purchase-returns.edit', $purchaseReturn) }}" class="px-4 py-2.5 rounded-xl bg-white/10 text-white text-sm hover:bg-[#83b735]/20">{{ __('app.purchase.edit') }}</a>
                <form method="POST" action="{{ route('purchase-returns.complete', $purchaseReturn) }}" class="inline">@csrf<button type="submit" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.purchase.complete_return') }}</button></form>
                @endif
            </div>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-500/20 border border-red-400/40 text-red-300 text-sm">{{ session('error') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-xs text-white/60">{{ __('app.purchase.vendor') }}</p>
                    <p class="text-white font-medium">{{ $purchaseReturn->vendor->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.purchase.date') }}</p>
                    <p class="text-white font-medium">{{ $purchaseReturn->date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.purchase.status') }}</p>
                    <p class="text-white font-medium">{{ __('app.purchase.' . $purchaseReturn->status) }}</p>
                </div>
                @if($purchaseReturn->purchase)
                <div>
                    <p class="text-xs text-white/60">{{ __('app.purchase.from_purchase') }}</p>
                    <a href="{{ route('purchases.show', $purchaseReturn->purchase) }}" class="text-[#83b735] font-medium hover:underline">{{ $purchaseReturn->purchase->reference_number }}</a>
                </div>
                @endif
            </div>

            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.inventory.product_catalog') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.inventory.quantity') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.purchase.rate') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-white/90">{{ __('app.purchase.amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchaseReturn->items as $item)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-3 text-sm text-white/90">{{ $item->product->name }} ({{ $item->product->sku }})</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $item->quantity }} {{ $item->product->unit?->symbol ?? '' }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ number_format($item->rate, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-white/90 text-right">{{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-white/20">
                        <td colspan="3" class="px-4 py-3 text-sm font-bold text-white/90">{{ __('app.purchase.total') }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-[#83b735] text-right">{{ number_format($purchaseReturn->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            @if($purchaseReturn->reason)
            <div class="mt-6 pt-4 border-t border-white/10">
                <p class="text-xs text-white/60">{{ __('app.purchase.reason') }}</p>
                <p class="text-sm text-white/90">{{ $purchaseReturn->reason }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
