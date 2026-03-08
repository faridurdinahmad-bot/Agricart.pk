<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VendorController extends Controller
{
    public function index(Request $request): View
    {
        $vendors = Vendor::query()
            ->with('vendorGroup')
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%"))
            ->when($request->status === 'inactive', fn ($q) => $q->where('status', 'inactive'), fn ($q) => $q->where('status', 'active'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('vendors.index', compact('vendors'));
    }

    public function create(): View
    {
        $vendorGroups = VendorGroup::orderBy('name')->get();

        return view('vendors.create', ['vendor' => new Vendor, 'vendorGroups' => $vendorGroups]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'vendor_group_id' => ['nullable', 'exists:vendor_groups,id'],
            'payment_terms' => ['nullable', 'string', 'max:100'],
        ]);

        Vendor::create([...$validated, 'status' => 'active']);

        return redirect()->route('vendors.index')->with('success', __('app.contacts.vendor_created'));
    }

    public function edit(Vendor $vendor): View
    {
        $vendorGroups = VendorGroup::orderBy('name')->get();

        return view('vendors.edit', compact('vendor', 'vendorGroups'));
    }

    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'vendor_group_id' => ['nullable', 'exists:vendor_groups,id'],
            'payment_terms' => ['nullable', 'string', 'max:100'],
        ]);

        $vendor->update($validated);

        return redirect()->route('vendors.index')->with('success', __('app.contacts.vendor_updated'));
    }

    public function deactivate(Vendor $vendor): RedirectResponse
    {
        $vendor->update(['status' => 'inactive']);

        return redirect()->route('vendors.index')->with('success', __('app.contacts.vendor_deactivated'));
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
            if (empty($data['name'] ?? '')) {
                continue;
            }
            Vendor::create([
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'payment_terms' => $data['payment_terms'] ?? null,
                'status' => 'active',
            ]);
            $imported++;
        }

        return redirect()->route('vendors.index')->with('success', __('app.contacts.vendors_imported', ['count' => $imported]));
    }

    public function export(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="vendors-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['name', 'phone', 'email', 'address', 'city', 'payment_terms', 'status']);

            Vendor::cursor()->each(fn (Vendor $v) => fputcsv($handle, [
                $v->name, $v->phone, $v->email, $v->address, $v->city, $v->payment_terms, $v->status,
            ]));

            fclose($handle);
        }, 200, $headers);
    }
}
