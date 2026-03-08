@extends('layouts.app')

@section('title', __('app.staff.title') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.staff.title')">
            <x-slot:actions>
                <x-button href="{{ route('staff.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.menu.staff.add_staff') }}
                </x-button>
                <x-button href="{{ route('staff.index', array_filter(['import' => 1, 'status' => request('status')])) }}" variant="secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    {{ __('app.menu.staff.import_staff') }}
                </x-button>
                <x-button href="{{ route('staff.export') }}" variant="secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    {{ __('app.menu.staff.export_staff') }}
                </x-button>
            </x-slot:actions>
        </x-page-heading>

        @if(request('import'))
        <x-card :title="__('app.menu.staff.import_staff')" class="mb-6">
            <form method="POST" action="{{ route('staff.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">CSV File</label>
                    <input type="file" name="file" accept=".csv,.txt" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#83b735] file:text-white file:text-sm">
                    <p class="mt-1.5 text-xs text-white/60">Columns: name, email, phone, role, department</p>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit" variant="primary">{{ __('app.menu.staff.import_staff') }}</x-button>
                    <x-button :href="route('staff.index', array_filter(['status' => request('status')]))" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
        @endif

        <div class="flex gap-2 mb-4">
            <x-tab-link href="{{ route('staff.index') }}" :label="__('app.contacts.active')" :active="!request('status')" />
            <x-tab-link href="{{ route('staff.index', ['status' => 'inactive']) }}" :label="__('app.contacts.inactive')" :active="request('status') === 'inactive'" />
        </div>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.staff.name') }}</th>
                            <th>{{ __('app.staff.email') }}</th>
                            <th>{{ __('app.staff.phone') }}</th>
                            <th>{{ __('app.staff.role') }}</th>
                            <th>{{ __('app.staff.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $s)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->email }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->phone ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->role ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $s->status === 'active' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($s->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('staff.edit', $s) }}" variant="secondary" size="sm">{{ __('app.contacts.edit') }}</x-button>
                                    @if($s->isActive())
                                    <form method="POST" action="{{ route('staff.deactivate', $s) }}" class="inline" onsubmit="return confirm('{{ __('app.staff.deactivate_staff') }}?');">@csrf<x-button type="submit" variant="danger" size="sm">{{ __('app.staff.deactivate_staff') }}</x-button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><x-empty-state :message="request('search') ? __('app.common.no_search_results') : __('app.staff.no_staff')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($staff->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $staff->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
