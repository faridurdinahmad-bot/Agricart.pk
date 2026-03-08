@extends('layouts.app')

@section('title', __('app.inventory.add_unit') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('units.index')" :title="__('app.inventory.add_unit')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('units.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.inventory.name')" required placeholder="e.g. Kilogram" />
                <x-input name="symbol" :label="__('app.inventory.symbol')" placeholder="e.g. kg" />
                <x-input name="description" :label="__('app.inventory.description')" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.inventory.save') }}</x-button>
                    <x-button :href="route('units.index')" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
