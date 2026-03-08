@extends('layouts.app')

@section('title', __('app.inventory.warranties') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-4xl mx-auto">
        <x-page-heading :title="__('app.inventory.warranties')">
            <x-slot:actions>
                <x-button href="{{ route('warranties.create') }}" variant="primary">{{ __('app.inventory.add_warranty') }}</x-button>
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
                            <th>{{ __('app.inventory.name') }}</th>
                            <th>{{ __('app.inventory.days') }}</th>
                            <th>{{ __('app.inventory.products_count') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warranties as $w)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $w->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $w->days }} {{ __('app.inventory.days') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $w->products_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('warranties.edit', $w) }}" variant="secondary" size="sm">{{ __('app.inventory.edit') }}</x-button>
                                    <form method="POST" action="{{ route('warranties.destroy', $w) }}" class="inline" onsubmit="return confirm('{{ __('app.inventory.delete_confirm') }}');">@csrf @method('DELETE')<x-button type="submit" variant="danger" size="sm">{{ __('app.inventory.delete') }}</x-button></form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><x-empty-state :message="__('app.inventory.no_warranties')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($warranties->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $warranties->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
