@extends('layouts.app')

@section('title', $shippingCarrier->name . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('shipping-carriers.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $shippingCarrier->name }}</h1>
                    <p class="text-sm text-white/60">{{ __('app.logistics.' . $shippingCarrier->status) }}</p>
                </div>
            </div>
            <a href="{{ route('shipping-carriers.edit', $shippingCarrier) }}" class="px-4 py-2.5 rounded-xl bg-white/10 text-white text-sm hover:bg-[#83b735]/20">{{ __('app.contacts.edit') }}</a>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.contact_phone') }}</p>
                    <p class="text-white/90">{{ $shippingCarrier->contact_phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.contact_email') }}</p>
                    <p class="text-white/90">{{ $shippingCarrier->contact_email ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.website') }}</p>
                    <p class="text-white/90">{{ $shippingCarrier->website ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/60">{{ __('app.logistics.status') }}</p>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $shippingCarrier->status === 'active' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-white/20 text-white/70' }}">{{ __('app.logistics.' . $shippingCarrier->status) }}</span>
                </div>
            </div>
            @if($shippingCarrier->notes)
            <div class="mt-4 pt-4 border-t border-white/10">
                <p class="text-xs text-white/60 mb-1">{{ __('app.logistics.notes') }}</p>
                <p class="text-white/90">{{ $shippingCarrier->notes }}</p>
            </div>
            @endif
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-white/20 flex justify-between items-center">
                <h3 class="text-sm font-bold text-white/90">{{ __('app.logistics.shipments') }}</h3>
                <a href="{{ route('shipments.index', ['carrier_id' => $shippingCarrier->id]) }}" class="text-sm text-[#83b735] hover:underline">{{ __('app.menu.logistics_menu.view_all_shipments') }}</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.logistics.tracking_number') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.logistics.sale') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.logistics.status') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90">{{ __('app.logistics.ship_date') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90">{{ __('app.logistics.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shippingCarrier->shipments as $s)
                        <tr class="border-b border-white/10">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->tracking_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->sale ? '#' . $s->sale->id . ' - ' . ($s->sale->customer?->name ?? '—') : '—' }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $s->status === 'delivered' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-white/20 text-white/70' }}">{{ __('app.logistics.' . $s->status) }}</span></td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->ship_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('shipments.show', $s) }}" class="text-sm text-[#83b735] hover:underline">{{ __('app.logistics.view') }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-white/60">{{ __('app.logistics.no_shipments') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
