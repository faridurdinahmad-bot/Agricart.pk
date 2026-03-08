@extends('layouts.app')

@section('title', __('app.leave.leave_types') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-4xl mx-auto">
        <x-page-heading :title="__('app.leave.leave_types')">
            <x-slot:actions>
                <x-button href="{{ route('leave-types.create') }}" variant="primary">{{ __('app.leave.add_leave_type') ?? 'Add Leave Type' }}</x-button>
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
                            <th>{{ __('app.leave.days_per_year') ?? 'Days/Year' }}</th>
                            <th>{{ __('app.inventory.description') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveTypes as $lt)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $lt->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $lt->days_per_year }}</td>
                            <td class="px-4 py-3 text-sm text-white/80">{{ $lt->description ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('leave-types.edit', $lt) }}" variant="secondary" size="sm">{{ __('app.inventory.edit') }}</x-button>
                                    <form method="POST" action="{{ route('leave-types.destroy', $lt) }}" class="inline" onsubmit="return confirm('{{ __('app.inventory.delete_confirm') }}');">@csrf @method('DELETE')<x-button type="submit" variant="danger" size="sm">{{ __('app.inventory.delete') }}</x-button></form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><x-empty-state :message="__('app.leave.no_leave_types') ?? 'No leave types.'"><x-button href="{{ route('leave-types.create') }}" variant="primary" size="sm">{{ __('app.leave.add_leave_type') ?? 'Add one' }}</x-button></x-empty-state></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($leaveTypes->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $leaveTypes->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
