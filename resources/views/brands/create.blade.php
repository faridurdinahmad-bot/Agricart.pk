@extends('layouts.app')

@section('title', __('app.inventory.add_brand') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('brands.index')" :title="__('app.inventory.add_brand')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('brands.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.inventory.name')" required />
                <x-input name="description" :label="__('app.inventory.description')" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.inventory.save') }}</x-button>
                    <x-button :href="route('brands.index')" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
