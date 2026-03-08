@extends('layouts.app')

@section('title', __('app.logistics.vehicles') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.logistics.vehicles')">
            <x-slot:actions>
                <x-button href="{{ route('delivery-vehicles.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.logistics.add_vehicle') }}
                </x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <div class="flex gap-2 mb-4">
            <x-tab-link href="{{ route('delivery-vehicles.index') }}" :label="__('app.logistics.active')" :active="!request('status')" />
            <x-tab-link href="{{ route('delivery-vehicles.index', ['status' => 'inactive']) }}" :label="__('app.logistics.inactive')" :active="request('status') === 'inactive'" />
        </div>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.logistics.name') }}</th>
                            <th>{{ __('app.logistics.number_plate') }}</th>
                            <th>{{ __('app.logistics.driver_name') }}</th>
                            <th>{{ __('app.logistics.driver_phone') }}</th>
                            <th>{{ __('app.logistics.status') }}</th>
                            <th>{{ __('app.logistics.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $v)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $v->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->number_plate ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->driver_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->driver_phone ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $v->status === 'active' ? 'badge-active' : 'badge-inactive' }}">{{ __('app.logistics.' . $v->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('delivery-vehicles.show', $v) }}" variant="secondary" size="sm">{{ __('app.logistics.view') }}</x-button>
                                    <x-button href="{{ route('delivery-vehicles.edit', $v) }}" variant="secondary" size="sm">{{ __('app.contacts.edit') }}</x-button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="__('app.logistics.no_vehicles')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($vehicles->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $vehicles->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
