@extends('layouts.app')

@section('title', __('app.contacts.edit_customer') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('customers.index')" :title="__('app.contacts.edit_customer')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="name" :label="__('app.contacts.name')" :value="old('name', $customer->name)" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="phone" :label="__('app.contacts.phone')" :value="old('phone', $customer->phone)" />
                    <x-input type="email" name="email" :label="__('app.contacts.email')" :value="old('email', $customer->email)" />
                </div>
                <x-input type="textarea" name="address" :label="__('app.contacts.address')" :rows="2">{{ old('address', $customer->address) }}</x-input>
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="city" :label="__('app.contacts.city')" :value="old('city', $customer->city)" />
                    <x-select name="customer_group_id" :label="__('app.contacts.customer_group')">
                        <option value="">{{ __('app.contacts.select_group') }}</option>
                        @foreach($customerGroups as $g)
                        <option value="{{ $g->id }}" {{ old('customer_group_id', $customer->customer_group_id) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <x-input type="number" name="credit_limit" :label="__('app.contacts.credit_limit')" :value="old('credit_limit', $customer->credit_limit)" step="0.01" min="0" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.contacts.update') }}</x-button>
                    <x-button :href="route('customers.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
