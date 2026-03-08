<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StaffController extends Controller
{
    public function index(Request $request): View
    {
        $staff = Staff::query()
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->status === 'inactive', fn ($q) => $q->where('status', 'inactive'), fn ($q) => $q->where('status', 'active'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staff.index', compact('staff'));
    }

    public function create(): View
    {
        return view('staff.create', ['staff' => new Staff]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:staff,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'role' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
        ]);

        Staff::create([...$validated, 'status' => 'active']);

        return redirect()->route('staff.index')->with('success', __('app.staff.created'));
    }

    public function edit(Staff $staff): View
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:staff,email,' . $staff->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'role' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
        ]);

        $staff->update($validated);

        return redirect()->route('staff.index')->with('success', __('app.staff.updated'));
    }

    public function deactivate(Staff $staff): RedirectResponse
    {
        $staff->update(['status' => 'inactive']);

        return redirect()->route('staff.index')->with('success', __('app.staff.deactivated'));
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:2048']]);

        $path = $request->file('file')->getRealPath();
        $rows = array_map('str_getcsv', file($path));
        $header = array_shift($rows);

        $imported = 0;
        foreach ($rows as $row) {
            $data = @array_combine($header, array_pad($row, count($header), null)) ?: [];
            if (empty($data['name'] ?? '') || empty($data['email'] ?? '')) {
                continue;
            }
            if (! Staff::where('email', $data['email'])->exists()) {
                Staff::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'role' => $data['role'] ?? null,
                    'department' => $data['department'] ?? null,
                    'status' => 'active',
                ]);
                $imported++;
            }
        }

        return redirect()->route('staff.index')->with('success', __('app.staff.imported', ['count' => $imported]));
    }

    public function export(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="staff-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['name', 'email', 'phone', 'role', 'department', 'status']);

            Staff::cursor()->each(fn (Staff $s) => fputcsv($handle, [
                $s->name, $s->email, $s->phone, $s->role, $s->department, $s->status,
            ]));

            fclose($handle);
        }, 200, $headers);
    }
}
