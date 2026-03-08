@extends('layouts.app')

@section('title', __('app.contacts.edit_group') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('vendor-groups.index')" :title="__('app.contacts.edit_group')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('vendor-groups.update', $vendorGroup) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="name" :label="__('app.contacts.name')" :value="old('name', $vendorGroup->name)" required />
                <x-input name="description" :label="__('app.contacts.description')" :value="old('description', $vendorGroup->description)" />
                <x-input name="supplier_type" :label="__('app.contacts.supplier_type')" :value="old('supplier_type', $vendorGroup->supplier_type)" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.contacts.update') }}</x-button>
                    <x-button :href="route('vendor-groups.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
