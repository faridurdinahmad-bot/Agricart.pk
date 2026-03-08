@extends('layouts.app')

@section('title', __('app.inventory.brands') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-4xl mx-auto">
        <x-page-heading :title="__('app.inventory.brands')">
            <x-slot:actions>
                <x-button href="{{ route('brands.create') }}" variant="primary">{{ __('app.inventory.add_brand') }}</x-button>
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
                            <th>{{ __('app.inventory.description') }}</th>
                            <th>{{ __('app.inventory.products_count') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $b)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $b->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/80">{{ $b->description ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $b->products_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('brands.edit', $b) }}" variant="secondary" size="sm">{{ __('app.inventory.edit') }}</x-button>
                                    <form method="POST" action="{{ route('brands.destroy', $b) }}" class="inline" onsubmit="return confirm('{{ __('app.inventory.delete_confirm') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">{{ __('app.inventory.delete') }}</x-button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><x-empty-state :message="__('app.inventory.no_brands')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($brands->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $brands->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
