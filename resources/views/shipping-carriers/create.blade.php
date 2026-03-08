@extends('layouts.app')

@section('title', __('app.logistics.add_carrier') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('shipping-carriers.index')" :title="__('app.logistics.add_carrier')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('shipping-carriers.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.logistics.name') . ' *'" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="contact_phone" :label="__('app.logistics.contact_phone')" />
                    <x-input type="email" name="contact_email" :label="__('app.logistics.contact_email')" />
                </div>
                <x-input type="url" name="website" :label="__('app.logistics.website')" placeholder="https://" />
                <x-input type="textarea" name="notes" :label="__('app.logistics.notes')" :rows="3">{{ old('notes') }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.logistics.save') }}</x-button>
                    <x-button :href="route('shipping-carriers.index')" variant="secondary">{{ __('app.logistics.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
