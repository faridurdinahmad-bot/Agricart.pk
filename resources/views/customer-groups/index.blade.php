@extends('layouts.app')

@section('title', __('app.contacts.customer_groups') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-4xl mx-auto">
        <x-page-heading :title="__('app.contacts.customer_groups')">
            <x-slot:actions>
                <x-button href="{{ route('customer-groups.create') }}" variant="primary">{{ __('app.contacts.add_group') }}</x-button>
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
                            <th>{{ __('app.contacts.name') }}</th>
                            <th>{{ __('app.contacts.description') }}</th>
                            <th>{{ __('app.contacts.discount') }}</th>
                            <th>{{ __('app.contacts.customers_count') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customerGroups as $g)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $g->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/80">{{ $g->description ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $g->discount_percent }}%</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $g->customers_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('customer-groups.edit', $g) }}" variant="secondary" size="sm">{{ __('app.contacts.edit') }}</x-button>
                                    <form method="POST" action="{{ route('customer-groups.destroy', $g) }}" class="inline" onsubmit="return confirm('{{ __('app.contacts.delete_confirm') }}');">@csrf @method('DELETE')<x-button type="submit" variant="danger" size="sm">{{ __('app.contacts.delete') }}</x-button></form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5"><x-empty-state :message="__('app.contacts.no_customer_groups')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($customerGroups->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $customerGroups->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
