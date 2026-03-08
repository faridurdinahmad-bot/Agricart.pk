@extends('layouts.app')

@section('title', __('app.logistics.edit_shipment') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('shipments.show', $shipment)" :title="__('app.logistics.edit_shipment') . ' - ' . ($shipment->tracking_number ?: '#' . $shipment->id)" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('shipments.update', $shipment) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-select name="sale_id" :label="__('app.logistics.sale')">
                    <option value="">—</option>
                    @foreach($sales as $s)
                    <option value="{{ $s->id }}" {{ old('sale_id', $shipment->sale_id) == $s->id ? 'selected' : '' }}>#{{ $s->id }} - {{ $s->customer?->name ?? '—' }}</option>
                    @endforeach
                </x-select>
                <x-select name="carrier_id" :label="__('app.logistics.carrier')">
                    <option value="">—</option>
                    @foreach($carriers as $c)
                    <option value="{{ $c->id }}" {{ old('carrier_id', $shipment->carrier_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </x-select>
                <x-input name="tracking_number" :label="__('app.logistics.tracking_number')" :value="old('tracking_number', $shipment->tracking_number)" />
                <x-select name="status" :label="__('app.logistics.status') . ' *'" required>
                    <option value="pending" {{ old('status', $shipment->status) === 'pending' ? 'selected' : '' }}>{{ __('app.logistics.pending') }}</option>
                    <option value="shipped" {{ old('status', $shipment->status) === 'shipped' ? 'selected' : '' }}>{{ __('app.logistics.shipped') }}</option>
                    <option value="in_transit" {{ old('status', $shipment->status) === 'in_transit' ? 'selected' : '' }}>{{ __('app.logistics.in_transit') }}</option>
                    <option value="delivered" {{ old('status', $shipment->status) === 'delivered' ? 'selected' : '' }}>{{ __('app.logistics.delivered') }}</option>
                    <option value="cancelled" {{ old('status', $shipment->status) === 'cancelled' ? 'selected' : '' }}>{{ __('app.logistics.cancelled') }}</option>
                </x-select>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="date" name="ship_date" :label="__('app.logistics.ship_date')" :value="old('ship_date', $shipment->ship_date?->format('Y-m-d'))" />
                    <x-input type="date" name="expected_delivery" :label="__('app.logistics.expected_delivery')" :value="old('expected_delivery', $shipment->expected_delivery?->format('Y-m-d'))" />
                </div>
                <x-input type="textarea" name="notes" :label="__('app.logistics.notes')" :rows="3">{{ old('notes', $shipment->notes) }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.logistics.update') }}</x-button>
                    <x-button :href="route('shipments.show', $shipment)" variant="secondary">{{ __('app.logistics.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
