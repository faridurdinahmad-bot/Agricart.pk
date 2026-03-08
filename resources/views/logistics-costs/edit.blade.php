@extends('layouts.app')

@section('title', __('app.logistics.edit_cost') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('logistics-costs.show', $logisticsCost)" :title="__('app.logistics.edit_cost') . ' #' . $logisticsCost->id" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('logistics-costs.update', $logisticsCost) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-select name="shipment_id" :label="__('app.logistics.shipment')">
                    <option value="">—</option>
                    @foreach($shipments as $s)
                    <option value="{{ $s->id }}" {{ old('shipment_id', $logisticsCost->shipment_id) == $s->id ? 'selected' : '' }}>#{{ $s->id }} {{ $s->tracking_number ? '- ' . $s->tracking_number : '' }} {{ $s->sale ? '(Sale #' . $s->sale->id . ')' : '' }}</option>
                    @endforeach
                </x-select>
                <x-select name="carrier_id" :label="__('app.logistics.carrier')">
                    <option value="">—</option>
                    @foreach($carriers as $c)
                    <option value="{{ $c->id }}" {{ old('carrier_id', $logisticsCost->carrier_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </x-select>
                <x-input name="category" :label="__('app.logistics.category')" :value="old('category', $logisticsCost->category)" />
                <x-input type="number" name="amount" :label="__('app.logistics.amount') . ' *'" :value="old('amount', $logisticsCost->amount)" step="0.01" min="0.01" required />
                <x-input type="date" name="date" :label="__('app.logistics.date') . ' *'" :value="old('date', $logisticsCost->date->format('Y-m-d'))" required />
                <x-input type="textarea" name="description" :label="__('app.logistics.description')" :rows="3">{{ old('description', $logisticsCost->description) }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.logistics.update') }}</x-button>
                    <x-button :href="route('logistics-costs.show', $logisticsCost)" variant="secondary">{{ __('app.logistics.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
