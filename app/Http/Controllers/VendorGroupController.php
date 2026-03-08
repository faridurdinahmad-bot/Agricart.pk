<?php

namespace App\Http\Controllers;

use App\Models\VendorGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorGroupController extends Controller
{
    public function index(): View
    {
        $vendorGroups = VendorGroup::withCount('vendors')->orderBy('name')->paginate(15);

        return view('vendor-groups.index', compact('vendorGroups'));
    }

    public function create(): View
    {
        return view('vendor-groups.create', ['vendorGroup' => new VendorGroup]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'supplier_type' => ['nullable', 'string', 'max:100'],
        ]);

        VendorGroup::create($validated);

        return redirect()->route('vendor-groups.index')->with('success', __('app.contacts.vendor_group_created'));
    }

    public function edit(VendorGroup $vendorGroup): View
    {
        return view('vendor-groups.edit', compact('vendorGroup'));
    }

    public function update(Request $request, VendorGroup $vendorGroup): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'supplier_type' => ['nullable', 'string', 'max:100'],
        ]);

        $vendorGroup->update($validated);

        return redirect()->route('vendor-groups.index')->with('success', __('app.contacts.vendor_group_updated'));
    }

    public function destroy(VendorGroup $vendorGroup): RedirectResponse
    {
        if ($vendorGroup->vendors()->exists()) {
            return redirect()->route('vendor-groups.index')->with('error', __('app.contacts.vendor_group_cannot_delete'));
        }

        $vendorGroup->delete();

        return redirect()->route('vendor-groups.index')->with('success', __('app.contacts.vendor_group_deleted'));
    }
}
