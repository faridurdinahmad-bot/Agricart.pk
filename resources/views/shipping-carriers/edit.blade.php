@extends('layouts.app')

@section('title', __('app.logistics.edit_carrier') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('shipping-carriers.show', $shippingCarrier)" :title="__('app.logistics.edit_carrier') . ' - ' . $shippingCarrier->name" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('shipping-carriers.update', $shippingCarrier) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="name" :label="__('app.logistics.name') . ' *'" :value="old('name', $shippingCarrier->name)" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="contact_phone" :label="__('app.logistics.contact_phone')" :value="old('contact_phone', $shippingCarrier->contact_phone)" />
                    <x-input type="email" name="contact_email" :label="__('app.logistics.contact_email')" :value="old('contact_email', $shippingCarrier->contact_email)" />
                </div>
                <x-input type="url" name="website" :label="__('app.logistics.website')" :value="old('website', $shippingCarrier->website)" />
                <x-select name="status" :label="__('app.logistics.status') . ' *'" required>
                    <option value="active" {{ old('status', $shippingCarrier->status) === 'active' ? 'selected' : '' }}>{{ __('app.logistics.active') }}</option>
                    <option value="inactive" {{ old('status', $shippingCarrier->status) === 'inactive' ? 'selected' : '' }}>{{ __('app.logistics.inactive') }}</option>
                </x-select>
                <x-input type="textarea" name="notes" :label="__('app.logistics.notes')" :rows="3">{{ old('notes', $shippingCarrier->notes) }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.logistics.update') }}</x-button>
                    <x-button :href="route('shipping-carriers.show', $shippingCarrier)" variant="secondary">{{ __('app.logistics.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
