@extends('layouts.app')

@section('title', __('app.inventory.add_return_policy') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('return-policies.index')" :title="__('app.inventory.add_return_policy')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('return-policies.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.inventory.name')" required placeholder="e.g. 7 Days Return" />
                <x-input type="number" name="days" :label="__('app.inventory.days')" :value="old('days', 7)" min="0" required />
                <x-input name="terms" :label="__('app.inventory.terms')" />
                <x-input name="description" :label="__('app.inventory.description')" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.inventory.save') }}</x-button>
                    <x-button :href="route('return-policies.index')" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
