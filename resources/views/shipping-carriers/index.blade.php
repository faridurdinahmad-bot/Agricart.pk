@extends('layouts.app')

@section('title', __('app.logistics.carriers') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.logistics.carriers')">
            <x-slot:actions>
                <x-button href="{{ route('shipping-carriers.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.logistics.add_carrier') }}
                </x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <div class="flex gap-2 mb-4">
            <x-tab-link href="{{ route('shipping-carriers.index') }}" :label="__('app.logistics.active')" :active="!request('status')" />
            <x-tab-link href="{{ route('shipping-carriers.index', ['status' => 'inactive']) }}" :label="__('app.logistics.inactive')" :active="request('status') === 'inactive'" />
        </div>

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.logistics.name') }}</th>
                            <th>{{ __('app.logistics.contact_phone') }}</th>
                            <th>{{ __('app.logistics.contact_email') }}</th>
                            <th>{{ __('app.logistics.website') }}</th>
                            <th>{{ __('app.logistics.status') }}</th>
                            <th>{{ __('app.logistics.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carriers as $c)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $c->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $c->contact_phone ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $c->contact_email ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $c->website ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $c->status === 'active' ? 'badge-active' : 'badge-inactive' }}">{{ __('app.logistics.' . $c->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('shipping-carriers.show', $c) }}" variant="secondary" size="sm">{{ __('app.logistics.view') }}</x-button>
                                    <x-button href="{{ route('shipping-carriers.edit', $c) }}" variant="secondary" size="sm">{{ __('app.contacts.edit') }}</x-button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="__('app.logistics.no_carriers')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($carriers->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $carriers->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
