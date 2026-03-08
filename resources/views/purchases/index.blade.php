@extends('layouts.app')

@section('title', __('app.purchase.purchase_list') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.purchase.purchase_list')">
            <x-slot:actions>
                <x-button href="{{ route('purchases.create', ['type' => 'order']) }}" variant="primary">{{ __('app.purchase.add_order') }}</x-button>
                <x-button href="{{ route('purchases.create', ['type' => 'direct']) }}" variant="secondary">{{ __('app.purchase.add_direct') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
        <x-alert type="error" class="mb-4">{{ session('error') }}</x-alert>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <select name="type" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.purchase.all_types') }}</option>
                <option value="order" {{ request('type') === 'order' ? 'selected' : '' }}>{{ __('app.purchase.order') }}</option>
                <option value="direct" {{ request('type') === 'direct' ? 'selected' : '' }}>{{ __('app.purchase.direct') }}</option>
            </select>
            <select name="status" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.purchase.all_status') }}</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>{{ __('app.purchase.draft') }}</option>
                <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>{{ __('app.purchase.sent') }}</option>
                <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>{{ __('app.purchase.received') }}</option>
            </select>
            <select name="vendor_id" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.purchase.all_vendors') }}</option>
                @foreach($vendors as $v)
                <option value="{{ $v->id }}" {{ request('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                @endforeach
            </select>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <x-button type="submit" variant="primary" size="sm">{{ __('app.purchase.filter') }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.purchase.reference') }}</th>
                            <th>{{ __('app.purchase.vendor') }}</th>
                            <th>{{ __('app.purchase.type') }}</th>
                            <th>{{ __('app.purchase.date') }}</th>
                            <th>{{ __('app.purchase.total') }}</th>
                            <th>{{ __('app.purchase.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $p)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-mono text-white/90">{{ $p->reference_number }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->vendor->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->type === 'order' ? __('app.purchase.order') : __('app.purchase.direct') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($p->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $p->status === 'received' ? 'badge-active' : 'badge-inactive' }}">{{ __('app.purchase.' . $p->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('purchases.show', $p) }}" variant="secondary" size="sm">{{ __('app.purchase.view') }}</x-button>
                                    @if($p->isDraft())
                                    <x-button href="{{ route('purchases.edit', $p) }}" variant="secondary" size="sm">{{ __('app.purchase.edit') }}</x-button>
                                    @endif
                                    @if($p->isOrder() && !$p->isReceived())
                                    <form method="POST" action="{{ route('purchases.receive', $p) }}" class="inline">@csrf<x-button type="submit" variant="success" size="sm">{{ __('app.purchase.receive') }}</x-button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7"><x-empty-state :message="__('app.purchase.no_purchases')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($purchases->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $purchases->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
