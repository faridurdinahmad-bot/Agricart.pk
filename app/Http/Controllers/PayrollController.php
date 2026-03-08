<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\PayrollItem;
use App\Models\PayrollRun;
use App\Models\Staff;
use App\Models\StaffSalary;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayrollController extends Controller
{
    public function index(): View
    {
        $payrolls = PayrollRun::withCount('items')->latest('year')->latest('month')->paginate(12);

        return view('payroll.index', compact('payrolls'));
    }

    public function create(): View
    {
        $month = now()->month;
        $year = now()->year;
        $exists = PayrollRun::where('month', $month)->where('year', $year)->exists();

        return view('payroll.create', compact('month', 'year', 'exists'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'min:2020', 'max:2100'],
        ]);

        if (PayrollRun::where('month', $validated['month'])->where('year', $validated['year'])->exists()) {
            return redirect()->route('payroll.create')->with('error', __('app.payroll.already_exists'));
        }

        $start = Carbon::create($validated['year'], $validated['month'], 1);
        $end = $start->copy()->endOfMonth();
        $totalDays = $end->day;

        $run = PayrollRun::create([
            'month' => $validated['month'],
            'year' => $validated['year'],
            'status' => 'draft',
            'total_amount' => 0,
        ]);

        $staff = Staff::where('status', 'active')->get();
        $totalAmount = 0;

        foreach ($staff as $s) {
            $salary = StaffSalary::where('staff_id', $s->id)->where('status', 'active')->latest()->first();
            $basic = $salary?->basic_salary ?? 0;
            $allowances = $salary?->allowances ?? 0;
            $deductions = $salary?->deductions ?? 0;

            $presentDays = Attendance::where('staff_id', $s->id)
                ->whereBetween('date', [$start, $end])
                ->whereIn('status', ['present', 'half_day'])
                ->count();
            $halfDays = Attendance::where('staff_id', $s->id)
                ->whereBetween('date', [$start, $end])
                ->where('status', 'half_day')
                ->count();
            $absentDays = $totalDays - $presentDays;
            if ($absentDays < 0) {
                $absentDays = 0;
            }

            $perDay = $totalDays > 0 ? $basic / $totalDays : 0;
            $deductAbsent = $absentDays * $perDay;
            $deductHalf = ($halfDays * $perDay) / 2;
            $netSalary = max(0, $basic + $allowances - $deductions - $deductAbsent - $deductHalf);

            PayrollItem::create([
                'payroll_run_id' => $run->id,
                'staff_id' => $s->id,
                'basic_salary' => $basic,
                'allowances' => $allowances,
                'deductions' => $deductions + $deductAbsent + $deductHalf,
                'attendance_days' => $presentDays,
                'absent_days' => $absentDays,
                'net_salary' => $netSalary,
            ]);

            $totalAmount += $netSalary;
        }

        $run->update(['total_amount' => $totalAmount]);

        return redirect()->route('payroll.show', $run)->with('success', __('app.payroll.generated'));
    }

    public function show(PayrollRun $payroll): View
    {
        $payroll->load('items.staff');

        return view('payroll.show', compact('payroll'));
    }

    public function process(PayrollRun $payroll): RedirectResponse
    {
        $payroll->update(['status' => 'processed']);

        return redirect()->route('payroll.index')->with('success', __('app.payroll.processed'));
    }

    public function slip(PayrollRun $payroll, Staff $staff): View
    {
        $item = PayrollItem::where('payroll_run_id', $payroll->id)->where('staff_id', $staff->id)->firstOrFail();
        $item->load('staff');

        return view('payroll.slip', compact('payroll', 'item'));
    }
}
