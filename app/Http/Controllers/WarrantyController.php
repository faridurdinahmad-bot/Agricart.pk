<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarrantyController extends Controller
{
    public function index(): View
    {
        $warranties = Warranty::withCount('products')->orderBy('days')->paginate(15);

        return view('warranties.index', compact('warranties'));
    }

    public function create(): View
    {
        return view('warranties.create', ['warranty' => new Warranty]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'days' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Warranty::create($validated);

        return redirect()->route('warranties.index')->with('success', __('app.inventory.warranty_created'));
    }

    public function edit(Warranty $warranty): View
    {
        return view('warranties.edit', compact('warranty'));
    }

    public function update(Request $request, Warranty $warranty): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'days' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $warranty->update($validated);

        return redirect()->route('warranties.index')->with('success', __('app.inventory.warranty_updated'));
    }

    public function destroy(Warranty $warranty): RedirectResponse
    {
        if ($warranty->products()->exists()) {
            return redirect()->route('warranties.index')->with('error', __('app.inventory.warranty_cannot_delete'));
        }

        $warranty->delete();

        return redirect()->route('warranties.index')->with('success', __('app.inventory.warranty_deleted'));
    }
}
