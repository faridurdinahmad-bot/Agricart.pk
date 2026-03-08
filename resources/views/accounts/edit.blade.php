@extends('layouts.app')

@section('title', __('app.finance.edit_account') . ' - ' . $account->name . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('accounts.show', $account)" :title="__('app.finance.edit_account') . ' - ' . $account->name" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('accounts.update', $account) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="name" :label="__('app.finance.name') . ' *'" :value="old('name', $account->name)" required />
                <x-select name="type" :label="__('app.finance.type') . ' *'" required>
                    <option value="cash" {{ old('type', $account->type) === 'cash' ? 'selected' : '' }}>{{ __('app.finance.cash') }}</option>
                    <option value="bank" {{ old('type', $account->type) === 'bank' ? 'selected' : '' }}>{{ __('app.finance.bank') }}</option>
                </x-select>
                <x-input name="account_number" :label="__('app.finance.account_number')" :value="old('account_number', $account->account_number)" />
                <x-input type="textarea" name="notes" :label="__('app.finance.notes')" :rows="2">{{ old('notes', $account->notes) }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.finance.update') }}</x-button>
                    <x-button :href="route('accounts.show', $account)" variant="secondary">{{ __('app.finance.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
