@extends('layouts.app')

@section('title', __('app.logistics.costs') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.logistics.costs')">
            <x-slot:actions>
                <x-button href="{{ route('logistics-costs.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.logistics.add_cost') }}
                </x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <select name="carrier_id" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <option value="">{{ __('app.logistics.carrier') }}</option>
                @foreach($carriers as $c)
                <option value="{{ $c->id }}" {{ request('carrier_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <x-button type="submit" variant="primary" size="sm">{{ __('app.logistics.filter') }}</x-button>
        </form>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.logistics.date') }}</th>
                            <th>{{ __('app.logistics.category') }}</th>
                            <th>{{ __('app.logistics.carrier') }}</th>
                            <th>{{ __('app.logistics.description') }}</th>
                            <th>{{ __('app.logistics.amount') }}</th>
                            <th>{{ __('app.logistics.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($costs as $cost)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $cost->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $cost->category ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $cost->carrier?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ Str::limit($cost->description, 40) ?: '—' }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium text-right">{{ number_format($cost->amount, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('logistics-costs.show', $cost) }}" variant="secondary" size="sm">{{ __('app.logistics.view') }}</x-button>
                                    <x-button href="{{ route('logistics-costs.edit', $cost) }}" variant="secondary" size="sm">{{ __('app.contacts.edit') }}</x-button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="__('app.logistics.no_costs')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($costs->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $costs->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
