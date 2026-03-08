@extends('layouts.app')

@section('title', __('app.finance.transactions') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.finance.transactions')">
            <x-slot:actions>
                <x-button href="{{ route('transactions.create', ['type' => 'income']) }}" variant="primary">{{ __('app.finance.add_income') }}</x-button>
                <x-button href="{{ route('transactions.create', ['type' => 'expense']) }}" variant="secondary">{{ __('app.finance.add_expense') }}</x-button>
                <x-button href="{{ route('transactions.create', ['type' => 'transfer']) }}" variant="secondary">{{ __('app.finance.add_transfer') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <select name="type" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.finance.all_types') }}</option>
                <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>{{ __('app.finance.income') }}</option>
                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>{{ __('app.finance.expense') }}</option>
                <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>{{ __('app.finance.transfer') }}</option>
            </select>
            <select name="account_id" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.finance.all_accounts') }}</option>
                @foreach($accounts as $a)
                <option value="{{ $a->id }}" {{ request('account_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                @endforeach
            </select>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <x-button type="submit" variant="primary" size="sm">{{ __('app.finance.filter') }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.finance.date') }}</th>
                            <th>{{ __('app.finance.type') }}</th>
                            <th>{{ __('app.finance.account') }}</th>
                            <th>{{ __('app.finance.description') }}</th>
                            <th>{{ __('app.finance.amount') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ __('app.finance.' . $t->type) }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">
                                @if($t->type === 'transfer' && $t->toAccount)
                                    {{ $t->account->name }} → {{ $t->toAccount->name }}
                                @else
                                    {{ $t->account->name }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->description ?? $t->reference ?? $t->payee ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-right {{ $t->amount > 0 ? 'text-[#83b735]' : 'text-red-400' }}">
                                {{ $t->amount >= 0 ? '+' : '' }}{{ number_format($t->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <x-button href="{{ route('transactions.show', $t) }}" variant="secondary" size="sm">{{ __('app.finance.view') }}</x-button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="__('app.finance.no_transactions')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $transactions->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
