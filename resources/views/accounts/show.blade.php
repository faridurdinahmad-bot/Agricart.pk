@extends('layouts.app')

@section('title', $account->name . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('accounts.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $account->name }}</h1>
                    <p class="text-sm text-white/60">{{ __('app.finance.' . $account->type) }} {{ $account->account_number ? '• ' . $account->account_number : '' }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('accounts.edit', $account) }}" class="px-4 py-2.5 rounded-xl bg-white/10 text-white text-sm hover:bg-[#83b735]/20">{{ __('app.finance.edit') }}</a>
                <a href="{{ route('transactions.create', ['type' => 'income', 'account_id' => $account->id]) }}" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.finance.add_income') }}</a>
                <a href="{{ route('transactions.create', ['type' => 'expense', 'account_id' => $account->id]) }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.finance.add_expense') }}</a>
            </div>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.balance') }}</p>
                    <p class="text-2xl font-bold text-[#83b735]">{{ number_format($account->balance, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.opening_balance') }}</p>
                    <p class="text-lg text-white/90">{{ number_format($account->opening_balance, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-white/20 flex justify-between items-center">
                <h3 class="text-sm font-bold text-white/90">{{ __('app.finance.recent_transactions') }}</h3>
                <a href="{{ route('transactions.index', ['account_id' => $account->id]) }}" class="text-sm text-[#83b735] hover:underline">{{ __('app.finance.view_all') }}</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.finance.date') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.finance.type') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.finance.description') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90">{{ __('app.finance.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($account->transactions as $t)
                        <tr class="border-b border-white/10">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ __('app.finance.' . $t->type) }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $t->description ?? $t->reference ?? '—' }}</td>
                            @php
                                $isInflow = $t->type === 'income' || ($t->type === 'transfer' && $t->to_account_id === $account->id);
                                $displayAmount = $isInflow ? abs($t->amount) : -abs($t->amount);
                            @endphp
                            <td class="px-4 py-3 text-sm text-right {{ $isInflow ? 'text-[#83b735]' : 'text-red-400' }}">
                                {{ $displayAmount >= 0 ? '+' : '' }}{{ number_format($displayAmount, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><x-empty-state :message="__('app.finance.no_transactions')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
