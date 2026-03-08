<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Shipment;
use App\Models\ShippingCarrier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    public function index(Request $request): View
    {
        $shipments = Shipment::query()
            ->with(['sale.customer', 'carrier'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->carrier_id, fn ($q) => $q->where('carrier_id', $request->carrier_id))
            ->when($request->from_date, fn ($q) => $q->whereDate('ship_date', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('ship_date', '<=', $request->to_date))
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $carriers = ShippingCarrier::where('status', 'active')->orderBy('name')->get();

        return view('shipments.index', compact('shipments', 'carriers'));
    }

    public function create(Request $request): View
    {
        $saleId = $request->get('sale_id');
        $sale = $saleId ? Sale::with('customer')->find($saleId) : null;
        $carriers = ShippingCarrier::where('status', 'active')->orderBy('name')->get();
        $sales = Sale::where('status', 'completed')->with('customer')->latest()->get();

        return view('shipments.create', compact('sale', 'carriers', 'sales'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sale_id' => ['nullable', 'exists:sales,id'],
            'carrier_id' => ['nullable', 'exists:shipping_carriers,id'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:pending,shipped,in_transit,delivered,cancelled'],
            'ship_date' => ['nullable', 'date'],
            'expected_delivery' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        Shipment::create($validated);

        return redirect()->route('shipments.index')->with('success', __('app.logistics.shipment_created'));
    }

    public function show(Shipment $shipment): View
    {
        $shipment->load(['sale.customer', 'carrier', 'logisticsCosts']);

        return view('shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment): View
    {
        $shipment->load(['sale', 'carrier']);
        $carriers = ShippingCarrier::where('status', 'active')->orderBy('name')->get();
        $sales = Sale::where('status', 'completed')->with('customer')->latest()->get();

        return view('shipments.edit', compact('shipment', 'carriers', 'sales'));
    }

    public function update(Request $request, Shipment $shipment): RedirectResponse
    {
        $validated = $request->validate([
            'sale_id' => ['nullable', 'exists:sales,id'],
            'carrier_id' => ['nullable', 'exists:shipping_carriers,id'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:pending,shipped,in_transit,delivered,cancelled'],
            'ship_date' => ['nullable', 'date'],
            'expected_delivery' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $shipment->update($validated);

        return redirect()->route('shipments.show', $shipment)->with('success', __('app.logistics.shipment_updated'));
    }
}
