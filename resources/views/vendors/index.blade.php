@extends('layouts.app')

@section('title', __('app.contacts.vendors') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.contacts.vendors')">
            <x-slot:actions>
                <x-button href="{{ route('vendors.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.contacts.add_vendor') }}
                </x-button>
                <x-button href="{{ route('vendors.index', array_filter(['import' => 1, 'status' => request('status')])) }}" variant="secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    {{ __('app.contacts.import_vendors') }}
                </x-button>
                <x-button href="{{ route('vendors.export') }}" variant="secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    {{ __('app.contacts.export_vendors') }}
                </x-button>
                <x-button href="{{ route('vendor-groups.index') }}" variant="secondary">{{ __('app.contacts.vendor_groups') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(request('import'))
        <x-card :title="__('app.contacts.import_vendors')" class="mb-6">
            <form method="POST" action="{{ route('vendors.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">CSV File</label>
                    <input type="file" name="file" accept=".csv,.txt" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#83b735] file:text-white file:text-sm">
                    <p class="mt-1.5 text-xs text-white/60">Columns: name, phone, email, address, city, payment_terms</p>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit" variant="primary">{{ __('app.contacts.import_vendors') }}</x-button>
                    <x-button :href="route('vendors.index', array_filter(['status' => request('status')]))" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
        @endif

        <div class="flex gap-2 mb-4">
            <x-tab-link href="{{ route('vendors.index') }}" :label="__('app.contacts.active')" :active="!request('status')" />
            <x-tab-link href="{{ route('vendors.index', ['status' => 'inactive']) }}" :label="__('app.contacts.inactive')" :active="request('status') === 'inactive'" />
        </div>

        <form method="GET" class="mb-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('app.contacts.search') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 w-full max-w-xs">
        </form>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
        <x-alert type="error" class="mb-4">{{ session('error') }}</x-alert>
        @endif

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.contacts.name') }}</th>
                            <th>{{ __('app.contacts.phone') }}</th>
                            <th>{{ __('app.contacts.email') }}</th>
                            <th>{{ __('app.contacts.group') }}</th>
                            <th>{{ __('app.contacts.payment_terms') }}</th>
                            <th>{{ __('app.staff.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $v)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $v->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->phone ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->email ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->vendorGroup?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->payment_terms ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $v->status === 'active' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($v->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('vendors.edit', $v) }}" variant="secondary" size="sm">{{ __('app.contacts.edit') }}</x-button>
                                    @if($v->isActive())
                                    <form method="POST" action="{{ route('vendors.deactivate', $v) }}" class="inline" onsubmit="return confirm('{{ __('app.contacts.deactivate_vendor') }}?');">@csrf<x-button type="submit" variant="danger" size="sm">{{ __('app.contacts.deactivate') }}</x-button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7"><x-empty-state :message="request('search') ? __('app.common.no_search_results') : __('app.contacts.no_vendors')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($vendors->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $vendors->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
