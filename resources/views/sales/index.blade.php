@extends('layouts.app')

@section('title', __('app.sale.sales_list') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.sale.sales_list') }}</h1>
            <a href="{{ route('sales.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                {{ __('app.sale.new_sale') }}
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-500/20 border border-red-400/40 text-red-300 text-sm">{{ session('error') }}</div>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <select name="status" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.sale.all_status') }}</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>{{ __('app.sale.draft') }}</option>
                <option value="hold" {{ request('status') === 'hold' ? 'selected' : '' }}>{{ __('app.sale.hold') }}</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('app.sale.completed') }}</option>
            </select>
            <select name="customer_id" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.sale.all_customers') }}</option>
                @foreach($customers as $c)
                <option value="{{ $c->id }}" {{ request('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">{{ __('app.sale.filter') }}</button>
        </form>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.sale.reference') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.sale.customer') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.sale.date') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.sale.total') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.sale.status') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $s)
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="px-4 py-3 text-sm font-mono text-white/90">{{ $s->reference_number }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->customer->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($s->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs {{ $s->status === 'completed' ? 'bg-[#83b735]/20 text-[#83b735]' : ($s->status === 'hold' ? 'bg-amber-500/20 text-amber-400' : 'bg-white/20 text-white/70') }}">{{ __('app.sale.' . $s->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('sales.show', $s) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.sale.view') }}</a>
                                @if($s->isDraft() || $s->isHold())
                                <a href="{{ route('sales.edit', $s) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.sale.edit') }}</a>
                                @endif
                                @if($s->isHold())
                                <form method="POST" action="{{ route('sales.complete', $s) }}" class="inline">@csrf<button type="submit" class="px-3 py-1.5 rounded-lg bg-[#83b735]/20 text-[#83b735] text-sm hover:bg-[#83b735]/30">{{ __('app.sale.complete') }}</button></form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-white/60">{{ __('app.sale.no_sales') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sales->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $sales->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
