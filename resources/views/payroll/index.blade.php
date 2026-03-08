@extends('layouts.app')

@section('title', __('app.payroll.title') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.payroll.title')">
            <x-slot:actions>
                <x-button href="{{ route('payroll.create') }}" variant="primary">{{ __('app.payroll.generate') }}</x-button>
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
                            <th>{{ __('app.payroll.period') }}</th>
                            <th>{{ __('app.payroll.staff_count') }}</th>
                            <th>{{ __('app.payroll.total_amount') }}</th>
                            <th>{{ __('app.payroll.status') }}</th>
                            <th>{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $p)
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $p->period }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $p->items_count }}</td>
                            <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($p->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $p->status === 'processed' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($p->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button href="{{ route('payroll.show', $p) }}" variant="secondary" size="sm">{{ __('app.payroll.view') }}</x-button>
                                    @if($p->status === 'draft')
                                    <form method="POST" action="{{ route('payroll.process', $p) }}" class="inline">@csrf<x-button type="submit" variant="success" size="sm">{{ __('app.payroll.process') }}</x-button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5"><x-empty-state :message="__('app.payroll.no_records')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($payrolls->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $payrolls->links() }}</div>
            @endif
        </x-card>
    </div>
</div>
@endsection
