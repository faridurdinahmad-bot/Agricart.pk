@extends('layouts.app')

@section('title', __('app.inventory.edit_category') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('categories.index')" :title="__('app.inventory.edit_category')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="name" :label="__('app.inventory.name')" :value="old('name', $category->name)" required />
                <x-select name="parent_id" :label="__('app.inventory.parent')">
                    <option value="">{{ __('app.inventory.none') }}</option>
                    @foreach($parentCategories as $p)
                    <option value="{{ $p->id }}" {{ old('parent_id', $category->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </x-select>
                <x-input name="description" :label="__('app.inventory.description')" :value="old('description', $category->description)" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.inventory.update') }}</x-button>
                    <x-button :href="route('categories.index')" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
