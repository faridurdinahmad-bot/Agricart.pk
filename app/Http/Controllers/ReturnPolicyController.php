<?php

namespace App\Http\Controllers;

use App\Models\ReturnPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnPolicyController extends Controller
{
    public function index(): View
    {
        $returnPolicies = ReturnPolicy::withCount('products')->orderBy('days')->paginate(15);

        return view('return-policies.index', compact('returnPolicies'));
    }

    public function create(): View
    {
        return view('return-policies.create', ['returnPolicy' => new ReturnPolicy]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'days' => ['required', 'integer', 'min:0'],
            'terms' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        ReturnPolicy::create($validated);

        return redirect()->route('return-policies.index')->with('success', __('app.inventory.return_policy_created'));
    }

    public function edit(ReturnPolicy $returnPolicy): View
    {
        return view('return-policies.edit', compact('returnPolicy'));
    }

    public function update(Request $request, ReturnPolicy $returnPolicy): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'days' => ['required', 'integer', 'min:0'],
            'terms' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $returnPolicy->update($validated);

        return redirect()->route('return-policies.index')->with('success', __('app.inventory.return_policy_updated'));
    }

    public function destroy(ReturnPolicy $returnPolicy): RedirectResponse
    {
        if ($returnPolicy->products()->exists()) {
            return redirect()->route('return-policies.index')->with('error', __('app.inventory.return_policy_cannot_delete'));
        }

        $returnPolicy->delete();

        return redirect()->route('return-policies.index')->with('success', __('app.inventory.return_policy_deleted'));
    }
}
