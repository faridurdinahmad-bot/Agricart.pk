@extends('layouts.app')

@section('title', __('app.roles.title') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.roles.title')">
            <x-slot:actions>
                <x-button href="{{ route('roles.create') }}" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.menu.roles_menu.add_role') }}
                </x-button>
                <x-button href="{{ route('roles.assign') }}" variant="secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    {{ __('app.menu.roles_menu.assign_to_staff') }}
                </x-button>
            </x-slot:actions>
        </x-page-heading>

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
                            <th>{{ __('app.roles.name') }}</th>
                            <th>{{ __('app.roles.description') }}</th>
                            <th>{{ __('app.roles.staff_count') }}</th>
                            <th>{{ __('app.roles.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $role->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/80">{{ $role->description ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $role->staff_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('roles.edit', $role) }}" variant="secondary" size="sm">{{ __('app.menu.roles_menu.edit_role') }}</x-button>
                                    <form method="POST" action="{{ route('roles.copy', $role) }}" class="inline">@csrf<x-button type="submit" variant="secondary" size="sm">{{ __('app.menu.roles_menu.copy_role') }}</x-button></form>
                                    <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline" onsubmit="return confirm('{{ __('app.menu.roles_menu.delete_role') }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">{{ __('app.menu.roles_menu.delete_role') }}</x-button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><x-empty-state :message="__('app.roles.no_roles')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($roles->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $roles->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
