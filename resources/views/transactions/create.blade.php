@extends('layouts.app')

@section('title', ($type === 'income' ? __('app.finance.add_income') : ($type === 'expense' ? __('app.finance.add_expense') : __('app.finance.add_transfer'))) . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('transactions.index')" :title="$type === 'income' ? __('app.finance.add_income') : ($type === 'expense' ? __('app.finance.add_expense') : __('app.finance.add_transfer'))" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('transactions.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <x-select name="account_id" :label="__('app.finance.account') . ' *'" required>
                    <option value="">{{ __('app.finance.select_account') }}</option>
                    @foreach($accounts as $a)
                    <option value="{{ $a->id }}" {{ old('account_id', request('account_id')) == $a->id ? 'selected' : '' }}>{{ $a->name }} ({{ number_format($a->balance, 2) }})</option>
                    @endforeach
                </x-select>
                @if($type === 'transfer')
                <x-select name="to_account_id" :label="__('app.finance.to_account') . ' *'">
                    <option value="">{{ __('app.finance.select_account') }}</option>
                    @foreach($accounts as $a)
                    <option value="{{ $a->id }}" {{ old('to_account_id') == $a->id ? 'selected' : '' }}>{{ $a->name }} ({{ number_format($a->balance, 2) }})</option>
                    @endforeach
                </x-select>
                @endif
                <x-input type="number" name="amount" :label="__('app.finance.amount') . ' *'" :value="old('amount')" step="0.01" min="0.01" required />
                <x-input type="date" name="date" :label="__('app.finance.date') . ' *'" :value="old('date', date('Y-m-d'))" required />
                <x-input name="reference" :label="__('app.finance.reference')" />
                <x-input type="textarea" name="description" :label="__('app.finance.description')" :rows="2">{{ old('description') }}</x-input>
                @if($type !== 'transfer')
                <x-input name="payee" :label="__('app.finance.payee')" />
                <x-input name="category" :label="__('app.finance.category')" />
                @endif
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.finance.save') }}</x-button>
                    <x-button :href="route('transactions.index')" variant="secondary">{{ __('app.finance.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
