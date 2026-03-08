@extends('layouts.app')

@section('title', __('app.menu.sub_settings.business_profile') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('dashboard')" :title="__('app.menu.sub_settings.business_profile')" />

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('settings.business.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="name" :label="__('app.settings.business_name')" :value="old('name', $business['name'])" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="email" name="email" :label="__('app.settings.email')" :value="old('email', $business['email'])" />
                    <x-input name="phone" :label="__('app.settings.phone')" :value="old('phone', $business['phone'])" />
                </div>
                <x-input type="textarea" name="address" :label="__('app.settings.address')" rows="3">{{ old('address', $business['address']) }}</x-input>
                <x-input name="tax_number" :label="__('app.settings.tax_number')" :value="old('tax_number', $business['tax_number'])" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.settings.save') }}</x-button>
                    <x-button :href="route('dashboard')" variant="secondary">{{ __('app.settings.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
