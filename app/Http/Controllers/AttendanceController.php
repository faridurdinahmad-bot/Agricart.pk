<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $date = $request->date ? Carbon::parse($request->date) : today();
        $attendances = Attendance::with('staff')
            ->whereDate('date', $date)
            ->orderBy('staff_id')
            ->get()
            ->keyBy('staff_id');

        $staff = Staff::where('status', 'active')->orderBy('name')->get();

        return view('attendance.index', compact('attendances', 'staff', 'date'));
    }

    public function mark(Request $request): View
    {
        $date = $request->date ? Carbon::parse($request->date) : today();
        $staff = Staff::where('status', 'active')->orderBy('name')->get();
        $attendances = Attendance::with('staff')
            ->whereDate('date', $date)
            ->get()
            ->keyBy('staff_id');

        return view('attendance.mark', compact('staff', 'attendances', 'date'));
    }

    public function markStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*.staff_id' => ['required', 'exists:staff,id'],
            'attendance.*.status' => ['required', 'in:present,absent,half_day'],
            'attendance.*.check_in' => ['nullable', 'string'],
            'attendance.*.check_out' => ['nullable', 'string'],
        ]);

        foreach ($validated['attendance'] as $row) {
            Attendance::updateOrCreate(
                [
                    'staff_id' => $row['staff_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $row['status'],
                    'check_in' => !empty($row['check_in']) ? $row['check_in'] : null,
                    'check_out' => !empty($row['check_out']) ? $row['check_out'] : null,
                ]
            );
        }

        return redirect()->route('attendance.index', ['date' => $validated['date']])
            ->with('success', __('app.attendance.marked'));
    }

    public function report(Request $request): View
    {
        $start = $request->start ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->end ? Carbon::parse($request->end) : now()->endOfMonth();
        $staffId = $request->staff_id;

        $query = Attendance::with('staff')
            ->whereBetween('date', [$start, $end]);

        if ($staffId) {
            $query->where('staff_id', $staffId);
        }

        $attendances = $query->orderBy('date')->orderBy('staff_id')->paginate(30)->withQueryString();
        $staff = Staff::where('status', 'active')->orderBy('name')->get();

        return view('attendance.report', compact('attendances', 'staff', 'start', 'end'));
    }
}
