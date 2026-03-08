@extends('layouts.app')

@section('title', ($type === 'income' ? __('app.finance.add_income') : ($type === 'expense' ? __('app.finance.add_expense') : __('app.finance.add_transfer'))) . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('transactions.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">
                {{ $type === 'income' ? __('app.finance.add_income') : ($type === 'expense' ? __('app.finance.add_expense') : __('app.finance.add_transfer')) }}
            </h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.account') }} *</label>
                        <select name="account_id" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="">{{ __('app.finance.select_account') }}</option>
                            @foreach($accounts as $a)
                            <option value="{{ $a->id }}" {{ old('account_id', request('account_id')) == $a->id ? 'selected' : '' }}>{{ $a->name }} ({{ number_format($a->balance, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    @if($type === 'transfer')
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.to_account') }} *</label>
                        <select name="to_account_id" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="">{{ __('app.finance.select_account') }}</option>
                            @foreach($accounts as $a)
                            <option value="{{ $a->id }}" {{ old('to_account_id') == $a->id ? 'selected' : '' }}>{{ $a->name }} ({{ number_format($a->balance, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.amount') }} *</label>
                        <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.date') }} *</label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.reference') }}</label>
                        <input type="text" name="reference" value="{{ old('reference') }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.description') }}</label>
                        <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">{{ old('description') }}</textarea>
                    </div>
                    @if($type !== 'transfer')
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.payee') }}</label>
                        <input type="text" name="payee" value="{{ old('payee') }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.category') }}</label>
                        <input type="text" name="category" value="{{ old('category') }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    @endif
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d]">{{ __('app.finance.save') }}</button>
                    <a href="{{ route('transactions.index') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.finance.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
