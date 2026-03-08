@extends('layouts.app')

@section('title', __('app.attendance.attendance_report') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('attendance.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.attendance.attendance_report') }}</h1>
        </div>

        <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-white/70 mb-1">Start</label>
                <input type="date" name="start" value="{{ $start->format('Y-m-d') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            </div>
            <div>
                <label class="block text-xs text-white/70 mb-1">End</label>
                <input type="date" name="end" value="{{ $end->format('Y-m-d') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            </div>
            <div>
                <label class="block text-xs text-white/70 mb-1">Staff</label>
                <select name="staff_id" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                    <option value="">All</option>
                    @foreach($staff as $s)
                    <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">Filter</button>
        </form>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.date') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.staff') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.check_in') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.check_out') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $a)
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3 text-sm text-white/90">{{ $a->date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $a->staff->name }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $a->check_in ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $a->check_out ?? '—' }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $a->status === 'present' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-red-500/20 text-red-400' }}">{{ ucfirst(str_replace('_', ' ', $a->status)) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-white/60">{{ __('app.attendance.no_records') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($attendances->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $attendances->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
