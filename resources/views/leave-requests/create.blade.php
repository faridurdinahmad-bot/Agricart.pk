@extends('layouts.app')

@section('title', __('app.leave.apply_leave') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('leave-requests.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.leave.apply_leave') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('leave-requests.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">Staff</label>
                    <select name="staff_id" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                        <option value="">Select Staff</option>
                        @foreach($staff as $s)
                        <option value="{{ $s->id }}" {{ old('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">Leave Type</label>
                    <select name="leave_type_id" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                        <option value="">Select Type</option>
                        @foreach($leaveTypes as $lt)
                        <option value="{{ $lt->id }}" {{ old('leave_type_id') == $lt->id ? 'selected' : '' }}>{{ $lt->name }} ({{ $lt->days_per_year }}/year)</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.leave.start_date') }}</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.leave.end_date') }}</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.leave.reason') }}</label>
                    <textarea name="reason" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">{{ old('reason') }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d]">Apply</button>
                    <a href="{{ route('leave-requests.index') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
