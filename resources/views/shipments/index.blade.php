@extends('layouts.app')

@section('title', __('app.logistics.shipments') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.logistics.shipments') }}</h1>
            <a href="{{ route('shipments.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('app.logistics.add_shipment') }}
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
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
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">{{ __('app.logistics.filter') ?? 'Filter' }}</button>
        </form>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.tracking_number') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.sale') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.carrier') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.status') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.ship_date') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $s)
                        <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $s->tracking_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->sale ? '#' . $s->sale->id . ' - ' . ($s->sale->customer?->name ?? '—') : '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->carrier?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $s->status === 'delivered' ? 'bg-[#83b735]/20 text-[#83b735]' : ($s->status === 'cancelled' ? 'bg-red-500/20 text-red-400' : 'bg-white/20 text-white/70') }}">{{ __('app.logistics.' . $s->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->ship_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('shipments.show', $s) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.logistics.view') }}</a>
                                    <a href="{{ route('shipments.edit', $s) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.contacts.edit') }}</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-white/60">{{ __('app.logistics.no_shipments') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($shipments->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $shipments->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
