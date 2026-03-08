@extends('layouts.app')

@section('title', __('app.inventory.add_product') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('products.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.inventory.add_product') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.sku') }}</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.category') }}</label>
                        <select name="category_id" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="">{{ __('app.inventory.none') }}</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.brand') }}</label>
                        <select name="brand_id" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="">{{ __('app.inventory.none') }}</option>
                            @foreach($brands as $b)
                            <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.unit') }} *</label>
                        <select name="unit_id" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="">{{ __('app.inventory.select_unit') }}</option>
                            @foreach($units as $u)
                            <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->symbol ?? $u->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.warranty') }}</label>
                        <select name="warranty_id" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="">{{ __('app.inventory.none') }}</option>
                            @foreach($warranties as $w)
                            <option value="{{ $w->id }}" {{ old('warranty_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.return_policy') }}</label>
                    <select name="return_policy_id" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                        <option value="">{{ __('app.inventory.none') }}</option>
                        @foreach($returnPolicies as $r)
                        <option value="{{ $r->id }}" {{ old('return_policy_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.purchase_price') }}</label>
                        <input type="number" name="purchase_price" value="{{ old('purchase_price', 0) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.sale_price') }}</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price', 0) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.quantity') }}</label>
                        <input type="number" name="quantity" value="{{ old('quantity', 0) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.reorder_level') }}</label>
                        <input type="number" name="reorder_level" value="{{ old('reorder_level', 0) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.inventory.description') }}</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">{{ old('description') }}</textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d]">{{ __('app.inventory.save') }}</button>
                    <a href="{{ route('products.index') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.inventory.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
