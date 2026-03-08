@extends('layouts.app')

@section('title', $purchase->reference_number . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('purchases.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $purchase->reference_number }}</h1>
                    <p class="text-sm text-white/60">{{ $purchase->vendor->name }} • {{ $purchase->date->format('d M Y') }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                @if($purchase->isDraft())
                <a href="{{ route('purchases.edit', $purchase) }}" class="px-4 py-2.5 rounded-xl bg-white/10 text-white text-sm hover:bg-[#83b735]/20">{{ __('app.purchase.edit') }}</a>
                @endif
                @if($purchase->isOrder() && !$purchase->isReceived())
                <form method="POST" action="{{ route('purchases.receive', $purchase) }}" class="inline">@csrf<button type="submit" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.purchase.receive') }}</button></form>
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
                    <p class="text-white font-medium">{{ $purchase->vendor->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.purchase.type') }}</p>
                    <p class="text-white font-medium">{{ $purchase->type === 'order' ? __('app.purchase.order') : __('app.purchase.direct') }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.purchase.date') }}</p>
                    <p class="text-white font-medium">{{ $purchase->date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.purchase.status') }}</p>
                    <p class="text-white font-medium">{{ __('app.purchase.' . $purchase->status) }}</p>
                </div>
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
                    @foreach($purchase->items as $item)
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
                        <td class="px-4 py-3 text-sm font-bold text-[#83b735] text-right">{{ number_format($purchase->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            @if($purchase->notes)
            <div class="mt-6 pt-4 border-t border-white/10">
                <p class="text-xs text-white/60">{{ __('app.purchase.notes') }}</p>
                <p class="text-sm text-white/90">{{ $purchase->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
