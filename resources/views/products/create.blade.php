@extends('layouts.app')

@section('title', __('app.inventory.add_product') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('products.index')" :title="__('app.inventory.add_product')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="sku" :label="__('app.inventory.sku')" required />
                    <x-input name="name" :label="__('app.inventory.name')" required />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-select name="category_id" :label="__('app.inventory.category')">
                        <option value="">{{ __('app.inventory.none') }}</option>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </x-select>
                    <x-select name="brand_id" :label="__('app.inventory.brand')">
                        <option value="">{{ __('app.inventory.none') }}</option>
                        @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-select name="unit_id" :label="__('app.inventory.unit') . ' *'" required>
                        <option value="">{{ __('app.inventory.select_unit') }}</option>
                        @foreach($units as $u)
                        <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->symbol ?? $u->name }})</option>
                        @endforeach
                    </x-select>
                    <x-select name="warranty_id" :label="__('app.inventory.warranty')">
                        <option value="">{{ __('app.inventory.none') }}</option>
                        @foreach($warranties as $w)
                        <option value="{{ $w->id }}" {{ old('warranty_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <x-select name="return_policy_id" :label="__('app.inventory.return_policy')">
                    <option value="">{{ __('app.inventory.none') }}</option>
                    @foreach($returnPolicies as $r)
                    <option value="{{ $r->id }}" {{ old('return_policy_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                    @endforeach
                </x-select>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="number" name="purchase_price" :label="__('app.inventory.purchase_price')" :value="old('purchase_price', 0)" step="0.01" min="0" />
                    <x-input type="number" name="sale_price" :label="__('app.inventory.sale_price')" :value="old('sale_price', 0)" step="0.01" min="0" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="number" name="quantity" :label="__('app.inventory.quantity')" :value="old('quantity', 0)" step="0.01" min="0" />
                    <x-input type="number" name="reorder_level" :label="__('app.inventory.reorder_level')" :value="old('reorder_level', 0)" step="0.01" min="0" />
                </div>
                <x-input type="textarea" name="description" :label="__('app.inventory.description')" :rows="2">{{ old('description') }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.inventory.save') }}</x-button>
                    <x-button :href="route('products.index')" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
