<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveTypeController extends Controller
{
    public function index(): View
    {
        $leaveTypes = LeaveType::orderBy('name')->paginate(15);

        return view('leave-types.index', compact('leaveTypes'));
    }

    public function create(): View
    {
        return view('leave-types.create', ['leaveType' => new LeaveType]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'days_per_year' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        LeaveType::create([...$validated, 'status' => 'active']);

        return redirect()->route('leave-types.index')->with('success', __('app.leave.type_created'));
    }

    public function edit(LeaveType $leaveType): View
    {
        return view('leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'days_per_year' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $leaveType->update($validated);

        return redirect()->route('leave-types.index')->with('success', __('app.leave.type_updated'));
    }

    public function destroy(LeaveType $leaveType): RedirectResponse
    {
        if ($leaveType->leaveRequests()->exists()) {
            return redirect()->route('leave-types.index')->with('error', __('app.leave.type_cannot_delete'));
        }

        $leaveType->delete();

        return redirect()->route('leave-types.index')->with('success', __('app.leave.type_deleted'));
    }
}
