<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(): View
    {
        $units = Unit::withCount('products')->orderBy('name')->paginate(15);

        return view('units.index', compact('units'));
    }

    public function create(): View
    {
        return view('units.create', ['unit' => new Unit]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'symbol' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Unit::create($validated);

        return redirect()->route('units.index')->with('success', __('app.inventory.unit_created'));
    }

    public function edit(Unit $unit): View
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'symbol' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $unit->update($validated);

        return redirect()->route('units.index')->with('success', __('app.inventory.unit_updated'));
    }

    public function destroy(Unit $unit): RedirectResponse
    {
        if ($unit->products()->exists()) {
            return redirect()->route('units.index')->with('error', __('app.inventory.unit_cannot_delete'));
        }

        $unit->delete();

        return redirect()->route('units.index')->with('success', __('app.inventory.unit_deleted'));
    }
}
