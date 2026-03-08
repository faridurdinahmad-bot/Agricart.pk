@extends('layouts.app')

@section('title', $deliveryVehicle->name . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('delivery-vehicles.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $deliveryVehicle->name }}</h1>
                    <p class="text-sm text-white/60">{{ $deliveryVehicle->number_plate ?? '—' }} • {{ __('app.logistics.' . $deliveryVehicle->status) }}</p>
                </div>
            </div>
            <a href="{{ route('delivery-vehicles.edit', $deliveryVehicle) }}" class="px-4 py-2.5 rounded-xl bg-white/10 text-white text-sm hover:bg-[#83b735]/20">{{ __('app.contacts.edit') }}</a>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.number_plate') }}</p>
                    <p class="text-white/90">{{ $deliveryVehicle->number_plate ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.driver_name') }}</p>
                    <p class="text-white/90">{{ $deliveryVehicle->driver_name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.driver_phone') }}</p>
                    <p class="text-white/90">{{ $deliveryVehicle->driver_phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.status') }}</p>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $deliveryVehicle->status === 'active' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-white/20 text-white/70' }}">{{ __('app.logistics.' . $deliveryVehicle->status) }}</span>
                </div>
            </div>
            @if($deliveryVehicle->notes)
            <div class="mt-4 pt-4 border-t border-white/10">
                <p class="text-xs text-white/60 mb-1">{{ __('app.logistics.notes') }}</p>
                <p class="text-white/90">{{ $deliveryVehicle->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
