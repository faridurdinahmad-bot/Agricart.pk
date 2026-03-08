@extends('layouts.app')

@section('title', __('app.attendance.mark_attendance') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('attendance.index', ['date' => $date->format('Y-m-d')]) }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.attendance.mark_attendance') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <form method="POST" action="{{ route('attendance.mark.store') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                <div class="mb-4 text-white/80">{{ $date->format('l, F j, Y') }}</div>
                <div class="space-y-3 max-h-[60vh] overflow-auto">
                    @foreach($staff as $s)
                    @php $att = $attendances->get($s->id); @endphp
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/10">
                        <span class="w-40 text-white/90 text-sm shrink-0">{{ $s->name }}</span>
                        <select name="attendance[{{ $loop->index }}][status]" class="px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white text-sm">
                            <option value="present" {{ ($att?->status ?? 'present') === 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ ($att?->status ?? '') === 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="half_day" {{ ($att?->status ?? '') === 'half_day' ? 'selected' : '' }}>Half Day</option>
                        </select>
                        <input type="time" name="attendance[{{ $loop->index }}][check_in]" value="{{ $att?->check_in }}" placeholder="In" class="px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white text-sm w-28">
                        <input type="time" name="attendance[{{ $loop->index }}][check_out]" value="{{ $att?->check_out }}" placeholder="Out" class="px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white text-sm w-28">
                        <input type="hidden" name="attendance[{{ $loop->index }}][staff_id]" value="{{ $s->id }}">
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d]">Save</button>
                    <a href="{{ route('attendance.index') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
