@extends('layouts.app')

@section('title', __('app.finance.add_account') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('accounts.index')" :title="__('app.finance.add_account')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('accounts.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.finance.name') . ' *'" required />
                <x-select name="type" :label="__('app.finance.type') . ' *'" required>
                    <option value="cash" {{ old('type') === 'cash' ? 'selected' : '' }}>{{ __('app.finance.cash') }}</option>
                    <option value="bank" {{ old('type') === 'bank' ? 'selected' : '' }}>{{ __('app.finance.bank') }}</option>
                </x-select>
                <x-input name="account_number" :label="__('app.finance.account_number')" />
                <x-input type="number" name="opening_balance" :label="__('app.finance.opening_balance') . ' *'" :value="old('opening_balance', 0)" step="0.01" required />
                <x-input type="textarea" name="notes" :label="__('app.finance.notes')" :rows="2">{{ old('notes') }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.finance.save') }}</x-button>
                    <x-button :href="route('accounts.index')" variant="secondary">{{ __('app.finance.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
