<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->status ?? 'pending';
        $leaveRequests = LeaveRequest::with(['staff', 'leaveType'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('leave-requests.index', compact('leaveRequests', 'status'));
    }

    public function create(): View
    {
        $staff = Staff::where('status', 'active')->orderBy('name')->get();
        $leaveTypes = LeaveType::where('status', 'active')->orderBy('name')->get();

        return view('leave-requests.create', compact('staff', 'leaveTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'leave_type_id' => ['required', 'exists:leave_types,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $days = $start->diffInDays($end) + 1;

        LeaveRequest::create([
            ...$validated,
            'days' => $days,
            'status' => 'pending',
        ]);

        return redirect()->route('leave-requests.index')->with('success', __('app.leave.applied'));
    }

    public function approve(LeaveRequest $leaveRequest): RedirectResponse
    {
        $leaveRequest->update(['status' => 'approved', 'reject_reason' => null]);

        return redirect()->route('leave-requests.index')->with('success', __('app.leave.approved'));
    }

    public function reject(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        $validated = $request->validate(['reason' => ['nullable', 'string', 'max:500']]);

        $leaveRequest->update([
            'status' => 'rejected',
            'reject_reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('leave-requests.index')->with('success', __('app.leave.rejected'));
    }
}
