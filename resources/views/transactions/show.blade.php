@extends('layouts.app')

@section('title', __('app.finance.transaction') . ' #' . $transaction->id . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('transactions.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.finance.'. $transaction->type) }} {{ __('app.finance.transaction') }}</h1>
                <p class="text-sm text-white/60">{{ $transaction->date->format('d M Y') }} • {{ $transaction->account->name }}</p>
            </div>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.type') }}</p>
                    <p class="text-white font-medium">{{ __('app.finance.' . $transaction->type) }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.account') }}</p>
                    <a href="{{ route('accounts.show', $transaction->account) }}" class="text-[#83b735] font-medium hover:underline">{{ $transaction->account->name }}</a>
                </div>
                @if($transaction->toAccount)
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.to_account') }}</p>
                    <a href="{{ route('accounts.show', $transaction->toAccount) }}" class="text-[#83b735] font-medium hover:underline">{{ $transaction->toAccount->name }}</a>
                </div>
                @endif
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.amount') }}</p>
                    <p class="text-xl font-bold {{ $transaction->amount >= 0 ? 'text-[#83b735]' : 'text-red-400' }}">
                        {{ $transaction->amount >= 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.date') }}</p>
                    <p class="text-white font-medium">{{ $transaction->date->format('d M Y') }}</p>
                </div>
                @if($transaction->reference)
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.reference') }}</p>
                    <p class="text-white font-medium">{{ $transaction->reference }}</p>
                </div>
                @endif
                @if($transaction->description)
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.description') }}</p>
                    <p class="text-white font-medium">{{ $transaction->description }}</p>
                </div>
                @endif
                @if($transaction->payee)
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.payee') }}</p>
                    <p class="text-white font-medium">{{ $transaction->payee }}</p>
                </div>
                @endif
                @if($transaction->category)
                <div>
                    <p class="text-xs text-white/60">{{ __('app.finance.category') }}</p>
                    <p class="text-white font-medium">{{ $transaction->category }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
