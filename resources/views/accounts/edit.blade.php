@extends('layouts.app')

@section('title', __('app.finance.edit_account') . ' - ' . $account->name . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('accounts.show', $account) }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.finance.edit_account') }} - {{ $account->name }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('accounts.update', $account) }}">
                @csrf
                @method('PUT')
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.name') }} *</label>
                        <input type="text" name="name" value="{{ old('name', $account->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.type') }} *</label>
                        <select name="type" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                            <option value="cash" {{ old('type', $account->type) === 'cash' ? 'selected' : '' }}>{{ __('app.finance.cash') }}</option>
                            <option value="bank" {{ old('type', $account->type) === 'bank' ? 'selected' : '' }}>{{ __('app.finance.bank') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.account_number') }}</label>
                        <input type="text" name="account_number" value="{{ old('account_number', $account->account_number) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.finance.notes') }}</label>
                        <textarea name="notes" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">{{ old('notes', $account->notes) }}</textarea>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d]">{{ __('app.finance.update') }}</button>
                    <a href="{{ route('accounts.show', $account) }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.finance.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
