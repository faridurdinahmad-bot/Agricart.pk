@extends('layouts.app')

@section('title', __('app.attendance.title') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-heading :title="__('app.attendance.title')">
            <x-slot:actions>
                <x-button href="{{ route('attendance.mark', ['date' => $date->format('Y-m-d')]) }}" variant="primary">{{ __('app.menu.attendance_leave.mark_attendance') }}</x-button>
                <x-button href="{{ route('attendance.report') }}" variant="secondary">{{ __('app.menu.attendance_leave.attendance_report') }}</x-button>
            </x-slot:actions>
        </x-page-heading>

        <div class="mb-4 flex gap-2 items-center">
            <form method="GET" class="flex gap-2">
                <input type="date" name="date" value="{{ $date->format('Y-m-d') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <x-button type="submit" variant="primary" size="sm">{{ __('app.attendance.go') ?? 'Go' }}</x-button>
            </form>
        </div>

        @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <x-card :padding="false" class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th>{{ __('app.attendance.staff') }}</th>
                            <th>{{ __('app.attendance.check_in') }}</th>
                            <th>{{ __('app.attendance.check_out') }}</th>
                            <th>{{ __('app.attendance.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $s)
                        @php $att = $attendances->get($s->id); @endphp
                        <tr class="table-row">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $att?->check_in ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $att?->check_out ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if($att)
                                <span class="{{ $att->status === 'present' ? 'badge-active' : ($att->status === 'absent' ? 'badge-inactive' : 'badge-inactive') }}">{{ ucfirst(str_replace('_', ' ', $att->status)) }}</span>
                                @else
                                <span class="text-white/50">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><x-empty-state :message="__('app.attendance.no_records')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
@endsection
