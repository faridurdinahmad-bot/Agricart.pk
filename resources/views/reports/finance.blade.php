@extends('layouts.app')

@section('title', __('app.reports.finance') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-back :href="route('dashboard')" :title="__('app.reports.finance')" />

        <form method="GET" class="mb-6 flex flex-wrap gap-2 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-medium text-white/70">From</label>
                <input type="date" name="from" value="{{ $from }}" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-[#83b735]">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-medium text-white/70">To</label>
                <input type="date" name="to" value="{{ $to }}" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-[#83b735]">
            </div>
            <x-button type="submit" variant="primary">{{ __('app.reports.filter') }}</x-button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <x-metric-card :label="__('app.reports.total_balance')" :value="number_format($totalBalance, 2)" variant="success" />
            <x-metric-card :label="__('app.reports.income') . ' (' . $from . ' - ' . $to . ')'" :value="number_format($income, 2)" variant="success" />
            <x-metric-card :label="__('app.reports.expense') . ' (' . $from . ' - ' . $to . ')'" :value="number_format($expense, 2)" variant="danger" />
            <x-metric-card :label="__('app.reports.net_sales')" :value="number_format($income - $expense, 2)" :variant="($income - $expense) >= 0 ? 'success' : 'danger'" />
        </div>

        <x-card :padding="false" class="overflow-hidden mb-6">
            <div class="px-4 py-3 border-b border-white/20">
                <h3 class="text-sm font-bold text-white/90">{{ __('app.finance.accounts') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.finance.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.finance.type') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.finance.balance') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $a)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $a->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ __('app.finance.' . $a->type) }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium text-right">{{ number_format($a->balance, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3"><x-empty-state :message="__('app.finance.no_accounts')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <div class="flex flex-wrap gap-2">
            <x-button href="{{ route('accounts.index') }}" variant="primary">{{ __('app.menu.reports_menu.view_accounts') }}</x-button>
            <x-button href="{{ route('transactions.index') }}" variant="secondary">{{ __('app.menu.reports_menu.view_transactions') }}</x-button>
            <x-button href="{{ route('transactions.income') }}" variant="secondary">{{ __('app.menu.reports_menu.view_income') }}</x-button>
            <x-button href="{{ route('transactions.expenses') }}" variant="secondary">{{ __('app.menu.reports_menu.view_expenses') }}</x-button>
        </div>
    </div>
</div>
@endsection
