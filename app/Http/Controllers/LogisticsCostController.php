<?php

namespace App\Http\Controllers;

use App\Models\LogisticsCost;
use App\Models\Shipment;
use App\Models\ShippingCarrier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogisticsCostController extends Controller
{
    public function index(Request $request): View
    {
        $costs = LogisticsCost::query()
            ->with(['shipment', 'carrier'])
            ->when($request->carrier_id, fn ($q) => $q->where('carrier_id', $request->carrier_id))
            ->when($request->from_date, fn ($q) => $q->whereDate('date', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('date', '<=', $request->to_date))
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $carriers = ShippingCarrier::where('status', 'active')->orderBy('name')->get();

        return view('logistics-costs.index', compact('costs', 'carriers'));
    }

    public function create(Request $request): View
    {
        $shipments = Shipment::with(['sale', 'carrier'])->latest()->get();
        $carriers = ShippingCarrier::where('status', 'active')->orderBy('name')->get();

        return view('logistics-costs.create', compact('shipments', 'carriers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shipment_id' => ['nullable', 'exists:shipments,id'],
            'carrier_id' => ['nullable', 'exists:shipping_carriers,id'],
            'category' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        LogisticsCost::create($validated);

        return redirect()->route('logistics-costs.index')->with('success', __('app.logistics.cost_created'));
    }

    public function show(LogisticsCost $logisticsCost): View
    {
        $logisticsCost->load(['shipment', 'carrier']);

        return view('logistics-costs.show', compact('logisticsCost'));
    }

    public function edit(LogisticsCost $logisticsCost): View
    {
        $logisticsCost->load(['shipment', 'carrier']);
        $shipments = Shipment::with(['sale', 'carrier'])->latest()->get();
        $carriers = ShippingCarrier::where('status', 'active')->orderBy('name')->get();

        return view('logistics-costs.edit', compact('logisticsCost', 'shipments', 'carriers'));
    }

    public function update(Request $request, LogisticsCost $logisticsCost): RedirectResponse
    {
        $validated = $request->validate([
            'shipment_id' => ['nullable', 'exists:shipments,id'],
            'carrier_id' => ['nullable', 'exists:shipping_carriers,id'],
            'category' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $logisticsCost->update($validated);

        return redirect()->route('logistics-costs.index')->with('success', __('app.logistics.cost_updated'));
    }
}
