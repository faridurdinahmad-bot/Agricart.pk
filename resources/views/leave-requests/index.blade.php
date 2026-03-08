@extends('layouts.app')

@section('title', __('app.leave.title') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.leave.title')">
            <x-slot:actions>
                <x-button href="{{ route('leave-requests.create') }}" variant="primary">{{ __('app.menu.attendance_leave.apply_leave') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        <div class="flex gap-2 mb-4">
            <x-tab-link href="{{ route('leave-requests.index', ['status' => 'pending']) }}" :label="__('app.leave.pending') ?? 'Pending'" :active="($status ?? 'pending') === 'pending'" />
            <x-tab-link href="{{ route('leave-requests.index', ['status' => 'approved']) }}" :label="__('app.leave.approved') ?? 'Approved'" :active="($status ?? '') === 'approved'" />
            <x-tab-link href="{{ route('leave-requests.index', ['status' => 'rejected']) }}" :label="__('app.leave.rejected') ?? 'Rejected'" :active="($status ?? '') === 'rejected'" />
        </div>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.staff.title') }}</th>
                            <th>{{ __('app.leave.leave_type') ?? 'Leave Type' }}</th>
                            <th>{{ __('app.leave.start_date') }}</th>
                            <th>{{ __('app.leave.end_date') }}</th>
                            <th>{{ __('app.leave.days') }}</th>
                            <th>{{ __('app.staff.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveRequests as $lr)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $lr->staff->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $lr->leaveType->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $lr->start_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $lr->end_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $lr->days }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $lr->status === 'approved' ? 'badge-active' : ($lr->status === 'rejected' ? 'badge-inactive' : 'badge-inactive') }}">{{ ucfirst($lr->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($lr->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('leave-requests.approve', $lr) }}" class="inline">@csrf<x-button type="submit" variant="success" size="sm">{{ __('app.leave.approve') ?? 'Approve' }}</x-button></form>
                                    <form method="POST" action="{{ route('leave-requests.reject', $lr) }}" class="inline" onsubmit="return confirm('{{ __('app.leave.reject_confirm') ?? 'Reject?' }}');">@csrf<x-button type="submit" variant="danger" size="sm">{{ __('app.leave.reject') ?? 'Reject' }}</x-button></form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7"><x-empty-state :message="__('app.leave.no_requests')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($leaveRequests->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $leaveRequests->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
