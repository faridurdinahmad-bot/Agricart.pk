@extends('layouts.app')

@section('title', __('app.purchase.return_list') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.purchase.return_list')">
            <x-slot:actions>
                <x-button href="{{ route('purchase-returns.create') }}" variant="primary">{{ __('app.purchase.add_return') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
        <x-alert type="error" class="mb-4">{{ session('error') }}</x-alert>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <select name="status" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.purchase.all_status') }}</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>{{ __('app.purchase.draft') }}</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('app.purchase.completed') }}</option>
            </select>
            <select name="vendor_id" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.purchase.all_vendors') }}</option>
                @foreach($vendors as $v)
                <option value="{{ $v->id }}" {{ request('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                @endforeach
            </select>
            <x-button type="submit" variant="primary" size="sm">{{ __('app.purchase.filter') }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.purchase.reference') }}</th>
                            <th>{{ __('app.purchase.vendor') }}</th>
                            <th>{{ __('app.purchase.date') }}</th>
                            <th>{{ __('app.purchase.total') }}</th>
                            <th>{{ __('app.purchase.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($returns as $r)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-mono text-white/90">{{ $r->reference_number }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $r->vendor->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $r->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($r->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $r->status === 'completed' ? 'badge-active' : 'badge-inactive' }}">{{ __('app.purchase.' . $r->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('purchase-returns.show', $r) }}" variant="secondary" size="sm">{{ __('app.purchase.view') }}</x-button>
                                    @if($r->status === 'draft')
                                    <x-button href="{{ route('purchase-returns.edit', $r) }}" variant="secondary" size="sm">{{ __('app.purchase.edit') }}</x-button>
                                    <form method="POST" action="{{ route('purchase-returns.complete', $r) }}" class="inline">@csrf<x-button type="submit" variant="success" size="sm">{{ __('app.purchase.complete_return') }}</x-button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="__('app.purchase.no_returns')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($returns->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $returns->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
