@extends('layouts.app')

@section('title', __('app.finance.accounts') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.finance.accounts')">
            <x-slot:actions>
                <x-button href="{{ route('accounts.create') }}" variant="primary">{{ __('app.finance.add_account') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <select name="type" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.finance.all_types') }}</option>
                <option value="cash" {{ request('type') === 'cash' ? 'selected' : '' }}>{{ __('app.finance.cash') }}</option>
                <option value="bank" {{ request('type') === 'bank' ? 'selected' : '' }}>{{ __('app.finance.bank') }}</option>
            </select>
            <x-button type="submit" variant="primary" size="sm">{{ __('app.finance.filter') }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.finance.name') }}</th>
                            <th>{{ __('app.finance.type') }}</th>
                            <th>{{ __('app.finance.account_number') }}</th>
                            <th>{{ __('app.finance.balance') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $a)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $a->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ __('app.finance.' . $a->type) }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $a->account_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium text-right">{{ number_format($a->balance, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('accounts.show', $a) }}" variant="secondary" size="sm">{{ __('app.finance.view') }}</x-button>
                                    <x-button href="{{ route('accounts.edit', $a) }}" variant="secondary" size="sm">{{ __('app.finance.edit') }}</x-button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5"><x-empty-state :message="__('app.finance.no_accounts')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($accounts->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $accounts->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
