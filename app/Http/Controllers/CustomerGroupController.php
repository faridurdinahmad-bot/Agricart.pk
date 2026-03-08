<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerGroupController extends Controller
{
    public function index(): View
    {
        $customerGroups = CustomerGroup::withCount('customers')->orderBy('name')->paginate(15);

        return view('customer-groups.index', compact('customerGroups'));
    }

    public function create(): View
    {
        return view('customer-groups.create', ['customerGroup' => new CustomerGroup]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'price_type' => ['nullable', 'string', 'max:50'],
        ]);

        CustomerGroup::create([
            ...$validated,
            'discount_percent' => $validated['discount_percent'] ?? 0,
        ]);

        return redirect()->route('customer-groups.index')->with('success', __('app.contacts.customer_group_created'));
    }

    public function edit(CustomerGroup $customerGroup): View
    {
        return view('customer-groups.edit', compact('customerGroup'));
    }

    public function update(Request $request, CustomerGroup $customerGroup): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'price_type' => ['nullable', 'string', 'max:50'],
        ]);

        $customerGroup->update([
            ...$validated,
            'discount_percent' => $validated['discount_percent'] ?? 0,
        ]);

        return redirect()->route('customer-groups.index')->with('success', __('app.contacts.customer_group_updated'));
    }

    public function destroy(CustomerGroup $customerGroup): RedirectResponse
    {
        if ($customerGroup->customers()->exists()) {
            return redirect()->route('customer-groups.index')->with('error', __('app.contacts.customer_group_cannot_delete'));
        }

        $customerGroup->delete();

        return redirect()->route('customer-groups.index')->with('success', __('app.contacts.customer_group_deleted'));
    }
}
