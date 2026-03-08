@extends('layouts.app')

@section('title', __('app.finance.expenses') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.finance.expenses')">
            <x-slot:actions>
                <x-button href="{{ route('transactions.create', ['type' => 'expense']) }}" variant="primary">{{ __('app.finance.add_expense') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end">
            <select name="account_id" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-[#83b735]">
                <option value="">{{ __('app.finance.all_accounts') }}</option>
                @foreach($accounts as $a)
                <option value="{{ $a->id }}" {{ request('account_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                @endforeach
            </select>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-[#83b735]">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-[#83b735]">
            <x-button type="submit" variant="primary">{{ __('app.finance.filter') }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px]">
                    <thead>
                        <tr class="table-header">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.finance.date') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.finance.account') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.finance.description') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.finance.payee') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.finance.amount') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->account->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->description ?? $t->reference ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->payee ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-red-400 font-medium text-right">{{ number_format($t->amount, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('transactions.show', $t) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.finance.view') }}</a>
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
