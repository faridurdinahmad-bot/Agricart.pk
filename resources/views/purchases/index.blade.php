@extends('layouts.app')

@section('title', __('app.purchase.purchase_list') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.purchase.purchase_list') }}</h1>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('purchases.create', ['type' => 'order']) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                    {{ __('app.purchase.add_order') }}
                </a>
                <a href="{{ route('purchases.create', ['type' => 'direct']) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    {{ __('app.purchase.add_direct') }}
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-500/20 border border-red-400/40 text-red-300 text-sm">{{ session('error') }}</div>
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
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">{{ __('app.purchase.filter') }}</button>
        </form>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.purchase.reference') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.purchase.vendor') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.purchase.type') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.purchase.date') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.purchase.total') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.purchase.status') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $p)
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="px-4 py-3 text-sm font-mono text-white/90">{{ $p->reference_number }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->vendor->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->type === 'order' ? __('app.purchase.order') : __('app.purchase.direct') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($p->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs {{ $p->status === 'received' ? 'bg-[#83b735]/20 text-[#83b735]' : ($p->status === 'draft' ? 'bg-amber-500/20 text-amber-400' : 'bg-white/20 text-white/70') }}">{{ __('app.purchase.' . $p->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('purchases.show', $p) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.purchase.view') }}</a>
                                @if($p->isDraft())
                                <a href="{{ route('purchases.edit', $p) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.purchase.edit') }}</a>
                                @endif
                                @if($p->isOrder() && !$p->isReceived())
                                <form method="POST" action="{{ route('purchases.receive', $p) }}" class="inline">@csrf<button type="submit" class="px-3 py-1.5 rounded-lg bg-[#83b735]/20 text-[#83b735] text-sm hover:bg-[#83b735]/30">{{ __('app.purchase.receive') }}</button></form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-12 text-center text-white/60">{{ __('app.purchase.no_purchases') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($purchases->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $purchases->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
