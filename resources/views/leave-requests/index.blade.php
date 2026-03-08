@extends('layouts.app')

@section('title', __('app.leave.title') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.leave.title') }}</h1>
            <a href="{{ route('leave-requests.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                {{ __('app.menu.attendance_leave.apply_leave') }}
            </a>
        </div>

        <div class="flex gap-2 mb-4">
            <a href="{{ route('leave-requests.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm {{ ($status ?? 'pending') === 'pending' ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80' }}">Pending</a>
            <a href="{{ route('leave-requests.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl text-sm {{ $status === 'approved' ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80' }}">Approved</a>
            <a href="{{ route('leave-requests.index', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl text-sm {{ $status === 'rejected' ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80' }}">Rejected</a>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">Staff</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">Leave Type</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.leave.start_date') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.leave.end_date') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.leave.days') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveRequests as $lr)
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3 text-sm text-white/90">{{ $lr->staff->name }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $lr->leaveType->name }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $lr->start_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $lr->end_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $lr->days }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $lr->status === 'approved' ? 'bg-[#83b735]/20 text-[#83b735]' : ($lr->status === 'rejected' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400') }}">{{ ucfirst($lr->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($lr->status === 'pending')
                            <form method="POST" action="{{ route('leave-requests.approve', $lr) }}" class="inline">@csrf<button type="submit" class="px-3 py-1.5 rounded-lg bg-[#83b735]/20 text-[#83b735] text-sm hover:bg-[#83b735]/30">Approve</button></form>
                            <form method="POST" action="{{ route('leave-requests.reject', $lr) }}" class="inline" onsubmit="return confirm('Reject?');">@csrf<button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 text-sm">Reject</button></form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-white/60">{{ __('app.leave.no_requests') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($leaveRequests->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $leaveRequests->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
