<?php

namespace App\Http\Controllers;

use App\Models\DeliveryVehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryVehicleController extends Controller
{
    public function index(Request $request): View
    {
        $vehicles = DeliveryVehicle::query()
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('delivery-vehicles.index', compact('vehicles'));
    }

    public function create(): View
    {
        return view('delivery-vehicles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'number_plate' => ['nullable', 'string', 'max:50'],
            'driver_name' => ['nullable', 'string', 'max:255'],
            'driver_phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        DeliveryVehicle::create([
            ...$validated,
            'status' => 'active',
        ]);

        return redirect()->route('delivery-vehicles.index')->with('success', __('app.logistics.vehicle_created'));
    }

    public function show(DeliveryVehicle $deliveryVehicle): View
    {
        return view('delivery-vehicles.show', compact('deliveryVehicle'));
    }

    public function edit(DeliveryVehicle $deliveryVehicle): View
    {
        return view('delivery-vehicles.edit', compact('deliveryVehicle'));
    }

    public function update(Request $request, DeliveryVehicle $deliveryVehicle): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'number_plate' => ['nullable', 'string', 'max:50'],
            'driver_name' => ['nullable', 'string', 'max:255'],
            'driver_phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string'],
        ]);

        $deliveryVehicle->update($validated);

        return redirect()->route('delivery-vehicles.index')->with('success', __('app.logistics.vehicle_updated'));
    }
}
