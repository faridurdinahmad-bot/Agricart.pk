@extends('layouts.app')

@section('title', __('app.logistics.add_vehicle') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('delivery-vehicles.index')" :title="__('app.logistics.add_vehicle')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('delivery-vehicles.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.logistics.name') . ' *'" required placeholder="e.g. Van 1, Truck A" />
                <x-input name="number_plate" :label="__('app.logistics.number_plate')" />
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="driver_name" :label="__('app.logistics.driver_name')" />
                    <x-input name="driver_phone" :label="__('app.logistics.driver_phone')" />
                </div>
                <x-input type="textarea" name="notes" :label="__('app.logistics.notes')" :rows="3">{{ old('notes') }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.logistics.save') }}</x-button>
                    <x-button :href="route('delivery-vehicles.index')" variant="secondary">{{ __('app.logistics.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
