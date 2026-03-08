@extends('layouts.app')

@section('title', ($shipment->tracking_number ?: 'Shipment #' . $shipment->id) . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('shipments.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $shipment->tracking_number ?: 'Shipment #' . $shipment->id }}</h1>
                    <p class="text-sm text-white/60">{{ __('app.logistics.' . $shipment->status) }} • {{ $shipment->carrier?->name ?? '—' }}</p>
                </div>
            </div>
            <a href="{{ route('shipments.edit', $shipment) }}" class="px-4 py-2.5 rounded-xl bg-white/10 text-white text-sm hover:bg-[#83b735]/20">{{ __('app.contacts.edit') }}</a>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.sale') }}</p>
                    <p class="text-white/90">{{ $shipment->sale ? '#' . $shipment->sale->id . ' - ' . ($shipment->sale->customer?->name ?? '—') : '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.carrier') }}</p>
                    <p class="text-white/90">{{ $shipment->carrier?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.ship_date') }}</p>
                    <p class="text-white/90">{{ $shipment->ship_date?->format('d M Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.expected_delivery') }}</p>
                    <p class="text-white/90">{{ $shipment->expected_delivery?->format('d M Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.status') }}</p>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $shipment->status === 'delivered' ? 'bg-[#83b735]/20 text-[#83b735]' : ($shipment->status === 'cancelled' ? 'bg-red-500/20 text-red-400' : 'bg-white/20 text-white/70') }}">{{ __('app.logistics.' . $shipment->status) }}</span>
                </div>
            </div>
            @if($shipment->notes)
            <div class="mt-4 pt-4 border-t border-white/10">
                <p class="text-xs text-white/60 mb-1">{{ __('app.logistics.notes') }}</p>
                <p class="text-white/90">{{ $shipment->notes }}</p>
            </div>
            @endif
        </div>

        @if($shipment->logisticsCosts->isNotEmpty())
        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-white/20">
                <h3 class="text-sm font-bold text-white/90">{{ __('app.logistics.costs') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.logistics.category') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.logistics.date') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90">{{ __('app.logistics.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shipment->logisticsCosts as $cost)
                        <tr class="border-b border-white/10">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $cost->category ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $cost->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium text-right">{{ number_format($cost->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
