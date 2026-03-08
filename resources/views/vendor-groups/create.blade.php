@extends('layouts.app')

@section('title', __('app.contacts.add_group') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('vendor-groups.index')" :title="__('app.contacts.add_group')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('vendor-groups.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.contacts.name')" required />
                <x-input name="description" :label="__('app.contacts.description')" />
                <x-input name="supplier_type" :label="__('app.contacts.supplier_type')" placeholder="e.g. Seeds, Fertilizers, Equipment" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.contacts.save') }}</x-button>
                    <x-button :href="route('vendor-groups.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
