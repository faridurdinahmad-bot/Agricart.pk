@extends('layouts.app')

@section('title', __('app.logistics.shipments') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.logistics.shipments')">
            <x-slot:actions>
                <x-button href="{{ route('shipments.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.logistics.add_shipment') }}
                </x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <select name="status" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.logistics.status') }}</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('app.logistics.pending') }}</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>{{ __('app.logistics.shipped') }}</option>
                <option value="in_transit" {{ request('status') === 'in_transit' ? 'selected' : '' }}>{{ __('app.logistics.in_transit') }}</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>{{ __('app.logistics.delivered') }}</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>{{ __('app.logistics.cancelled') }}</option>
            </select>
            <select name="carrier_id" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.logistics.carrier') }}</option>
                @foreach($carriers as $c)
                <option value="{{ $c->id }}" {{ request('carrier_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <x-button type="submit" variant="primary" size="sm">{{ __('app.logistics.filter') ?? 'Filter' }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.logistics.tracking_number') }}</th>
                            <th>{{ __('app.logistics.sale') }}</th>
                            <th>{{ __('app.logistics.carrier') }}</th>
                            <th>{{ __('app.logistics.status') }}</th>
                            <th>{{ __('app.logistics.ship_date') }}</th>
                            <th>{{ __('app.logistics.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $s)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $s->tracking_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->sale ? '#' . $s->sale->id . ' - ' . ($s->sale->customer?->name ?? '—') : '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->carrier?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $s->status === 'delivered' ? 'badge-active' : ($s->status === 'cancelled' ? 'badge-inactive' : 'badge-inactive') }}">{{ __('app.logistics.' . $s->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->ship_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('shipments.show', $s) }}" variant="secondary" size="sm">{{ __('app.logistics.view') }}</x-button>
                                    <x-button href="{{ route('shipments.edit', $s) }}" variant="secondary" size="sm">{{ __('app.contacts.edit') }}</x-button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="__('app.logistics.no_shipments')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($shipments->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $shipments->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
