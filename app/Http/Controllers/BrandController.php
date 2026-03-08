<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::withCount('products')->orderBy('name')->paginate(15);

        return view('brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('brands.create', ['brand' => new Brand]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Brand::create($validated);

        return redirect()->route('brands.index')->with('success', __('app.inventory.brand_created'));
    }

    public function edit(Brand $brand): View
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $brand->update($validated);

        return redirect()->route('brands.index')->with('success', __('app.inventory.brand_updated'));
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->products()->exists()) {
            return redirect()->route('brands.index')->with('error', __('app.inventory.brand_cannot_delete'));
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', __('app.inventory.brand_deleted'));
    }
}
