@extends('layouts.app')

@section('title', __('app.sale.sales_list') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.sale.sales_list')">
            <x-slot:actions>
                <x-button href="{{ route('sales.create') }}" variant="primary">{{ __('app.sale.new_sale') }}</x-button>
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
            <x-button type="submit" variant="primary" size="sm">{{ __('app.sale.filter') }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.sale.reference') }}</th>
                            <th>{{ __('app.sale.customer') }}</th>
                            <th>{{ __('app.sale.date') }}</th>
                            <th>{{ __('app.sale.total') }}</th>
                            <th>{{ __('app.sale.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $s)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-mono text-white/90">{{ $s->reference_number }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->customer->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($s->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $s->status === 'completed' ? 'badge-active' : 'badge-inactive' }}">{{ __('app.sale.' . $s->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('sales.show', $s) }}" variant="secondary" size="sm">{{ __('app.sale.view') }}</x-button>
                                    @if($s->isDraft() || $s->isHold())
                                    <x-button href="{{ route('sales.edit', $s) }}" variant="secondary" size="sm">{{ __('app.sale.edit') }}</x-button>
                                    @endif
                                    @if($s->isHold())
                                    <form method="POST" action="{{ route('sales.complete', $s) }}" class="inline">@csrf<x-button type="submit" variant="success" size="sm">{{ __('app.sale.complete') }}</x-button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="__('app.sale.no_sales')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sales->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $sales->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
