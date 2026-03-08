@extends('layouts.app')

@section('title', __('app.contacts.add_vendor') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('vendors.index')" :title="__('app.contacts.add_vendor')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('vendors.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.contacts.name')" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="phone" :label="__('app.contacts.phone')" />
                    <x-input type="email" name="email" :label="__('app.contacts.email')" />
                </div>
                <x-input type="textarea" name="address" :label="__('app.contacts.address')" :rows="2">{{ old('address') }}</x-input>
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="city" :label="__('app.contacts.city')" />
                    <x-select name="vendor_group_id" :label="__('app.contacts.vendor_group')">
                        <option value="">{{ __('app.contacts.select_group') }}</option>
                        @foreach($vendorGroups as $g)
                        <option value="{{ $g->id }}" {{ old('vendor_group_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <x-input name="payment_terms" :label="__('app.contacts.payment_terms')" placeholder="e.g. Net 30, COD" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.contacts.save') }}</x-button>
                    <x-button :href="route('vendors.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
