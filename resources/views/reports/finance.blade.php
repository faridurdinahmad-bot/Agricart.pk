@extends('layouts.app')

@section('title', __('app.reports.finance') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.reports.finance') }}</h1>
        </div>

        <form method="GET" class="mb-6 flex flex-wrap gap-2">
            <input type="date" name="from" value="{{ $from }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to" value="{{ $to }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">{{ __('app.reports.filter') }}</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.total_balance') }}</p>
                <p class="text-2xl font-bold text-[#83b735]">{{ number_format($totalBalance, 2) }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.income') }} ({{ $from }} - {{ $to }})</p>
                <p class="text-2xl font-bold text-[#83b735]">{{ number_format($income, 2) }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.expense') }} ({{ $from }} - {{ $to }})</p>
                <p class="text-2xl font-bold text-red-400">{{ number_format($expense, 2) }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.net_sales') }}</p>
                <p class="text-2xl font-bold {{ ($income - $expense) >= 0 ? 'text-[#83b735]' : 'text-red-400' }}">{{ number_format($income - $expense, 2) }}</p>
            </div>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden mb-6">
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
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $a->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ __('app.finance.' . $a->type) }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium text-right">{{ number_format($a->balance, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-4 py-12 text-center text-white/60">{{ __('app.finance.no_accounts') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('accounts.index') }}" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.menu.reports_menu.view_accounts') }}</a>
            <a href="{{ route('transactions.index') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.view_transactions') }}</a>
            <a href="{{ route('transactions.income') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.view_income') }}</a>
            <a href="{{ route('transactions.expenses') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.view_expenses') }}</a>
        </div>
    </div>
</div>
@endsection
