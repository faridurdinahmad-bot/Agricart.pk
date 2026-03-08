<?php

namespace App\Http\Controllers;

use App\Models\ShippingCarrier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingCarrierController extends Controller
{
    public function index(Request $request): View
    {
        $carriers = ShippingCarrier::query()
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('shipping-carriers.index', compact('carriers'));
    }

    public function create(): View
    {
        return view('shipping-carriers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email'],
            'website' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        ShippingCarrier::create([
            ...$validated,
            'status' => 'active',
        ]);

        return redirect()->route('shipping-carriers.index')->with('success', __('app.logistics.carrier_created'));
    }

    public function show(ShippingCarrier $shippingCarrier): View
    {
        $shippingCarrier->load('shipments.sale');

        return view('shipping-carriers.show', compact('shippingCarrier'));
    }

    public function edit(ShippingCarrier $shippingCarrier): View
    {
        return view('shipping-carriers.edit', compact('shippingCarrier'));
    }

    public function update(Request $request, ShippingCarrier $shippingCarrier): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email'],
            'website' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string'],
        ]);

        $shippingCarrier->update($validated);

        return redirect()->route('shipping-carriers.index')->with('success', __('app.logistics.carrier_updated'));
    }
}
