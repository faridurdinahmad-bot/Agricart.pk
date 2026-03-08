@extends('layouts.app')

@section('title', __('app.contacts.add_group') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('customer-groups.index')" :title="__('app.contacts.add_group')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('customer-groups.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.contacts.name')" required />
                <x-input name="description" :label="__('app.contacts.description')" />
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="number" name="discount_percent" :label="__('app.contacts.discount') . ' (%)'" :value="old('discount_percent', 0)" step="0.01" min="0" max="100" />
                    <x-input name="price_type" :label="__('app.contacts.price_type')" placeholder="e.g. retail, wholesale" />
                </div>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.contacts.save') }}</x-button>
                    <x-button :href="route('customer-groups.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
