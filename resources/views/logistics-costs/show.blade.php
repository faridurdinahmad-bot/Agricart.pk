@extends('layouts.app')

@section('title', __('app.logistics.cost') . ' #' . $logisticsCost->id . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('logistics-costs.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $logisticsCost->category ?: __('app.logistics.cost') }} #{{ $logisticsCost->id }}</h1>
                    <p class="text-sm text-white/60">{{ $logisticsCost->date->format('d M Y') }} • {{ number_format($logisticsCost->amount, 2) }}</p>
                </div>
            </div>
            <a href="{{ route('logistics-costs.edit', $logisticsCost) }}" class="px-4 py-2.5 rounded-xl bg-white/10 text-white text-sm hover:bg-[#83b735]/20">{{ __('app.contacts.edit') }}</a>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.date') }}</p>
                    <p class="text-white/90">{{ $logisticsCost->date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.amount') }}</p>
                    <p class="text-xl font-bold text-[#83b735]">{{ number_format($logisticsCost->amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.category') }}</p>
                    <p class="text-white/90">{{ $logisticsCost->category ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.carrier') }}</p>
                    <p class="text-white/90">{{ $logisticsCost->carrier?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.shipment') }}</p>
                    <p class="text-white/90">{{ $logisticsCost->shipment ? '#' . $logisticsCost->shipment->id . ($logisticsCost->shipment->tracking_number ? ' - ' . $logisticsCost->shipment->tracking_number : '') : '—' }}</p>
                </div>
            </div>
            @if($logisticsCost->description)
            <div class="mt-4 pt-4 border-t border-white/10">
                <p class="text-xs text-white/60 mb-1">{{ __('app.logistics.description') }}</p>
                <p class="text-white/90">{{ $logisticsCost->description }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
