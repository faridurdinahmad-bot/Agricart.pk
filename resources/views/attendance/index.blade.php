@extends('layouts.app')

@section('title', __('app.attendance.title') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.attendance.title') }}</h1>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('attendance.mark', ['date' => $date->format('Y-m-d')]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                    {{ __('app.menu.attendance_leave.mark_attendance') }}
                </a>
                <a href="{{ route('attendance.report') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    {{ __('app.menu.attendance_leave.attendance_report') }}
                </a>
            </div>
        </div>

        <div class="mb-4 flex gap-2 items-center">
            <form method="GET" class="flex gap-2">
                <input type="date" name="date" value="{{ $date->format('Y-m-d') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#83b735] text-white text-sm">Go</button>
            </form>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.staff') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.check_in') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.check_out') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.attendance.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $s)
                    @php $att = $attendances->get($s->id); @endphp
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3 text-sm text-white/90">{{ $s->name }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $att?->check_in ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $att?->check_out ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if($att)
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $att->status === 'present' ? 'bg-[#83b735]/20 text-[#83b735]' : ($att->status === 'absent' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400') }}">
                                {{ ucfirst(str_replace('_', ' ', $att->status)) }}
                            </span>
                            @else
                            <span class="text-white/50">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-12 text-center text-white/60">{{ __('app.attendance.no_records') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
