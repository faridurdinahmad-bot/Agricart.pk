<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffSalary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffSalaryController extends Controller
{
    public function index(): View
    {
        $salaries = StaffSalary::with('staff')->where('status', 'active')->orderBy('staff_id')->paginate(20);

        return view('payroll.salaries', compact('salaries'));
    }

    public function create(): View
    {
        $staff = Staff::where('status', 'active')->orderBy('name')->get();
        $staffWithSalary = StaffSalary::where('status', 'active')->pluck('staff_id')->toArray();

        return view('payroll.salary-create', compact('staff', 'staffWithSalary'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'allowances' => ['nullable', 'numeric', 'min:0'],
            'deductions' => ['nullable', 'numeric', 'min:0'],
        ]);

        StaffSalary::where('staff_id', $validated['staff_id'])->update(['status' => 'inactive']);

        StaffSalary::create([
            ...$validated,
            'allowances' => $validated['allowances'] ?? 0,
            'deductions' => $validated['deductions'] ?? 0,
            'status' => 'active',
        ]);

        return redirect()->route('payroll.salaries')->with('success', __('app.payroll.salary_saved'));
    }

    public function edit(StaffSalary $staffSalary): View
    {
        $staffSalary->load('staff');

        return view('payroll.salary-edit', compact('staffSalary'));
    }

    public function update(Request $request, StaffSalary $staffSalary): RedirectResponse
    {
        $validated = $request->validate([
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'allowances' => ['nullable', 'numeric', 'min:0'],
            'deductions' => ['nullable', 'numeric', 'min:0'],
        ]);

        $staffSalary->update([
            'basic_salary' => $validated['basic_salary'],
            'allowances' => $validated['allowances'] ?? 0,
            'deductions' => $validated['deductions'] ?? 0,
        ]);

        return redirect()->route('payroll.salaries')->with('success', __('app.payroll.salary_updated'));
    }
}
