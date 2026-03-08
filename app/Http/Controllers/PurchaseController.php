<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(Request $request): View
    {
        $purchases = Purchase::query()
            ->with('vendor')
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->vendor_id, fn ($q) => $q->where('vendor_id', $request->vendor_id))
            ->when($request->from_date, fn ($q) => $q->whereDate('date', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('date', '<=', $request->to_date))
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();

        return view('purchases.index', compact('purchases', 'vendors'));
    }

    public function create(Request $request): View
    {
        $type = $request->get('type', 'order');
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('purchases.create', compact('vendors', 'products', 'type'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'type' => ['required', 'in:order,direct'],
            'date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $prefix = $validated['type'] === 'direct' ? 'PUR' : 'PO';
        $seq = Purchase::where('reference_number', 'like', $prefix . '-' . now()->format('Ymd') . '-%')->count() + 1;
        $ref = $prefix . '-' . now()->format('Ymd') . '-' . str_pad($seq, 3, '0', STR_PAD_LEFT);

        $status = $validated['type'] === 'direct' ? 'received' : 'draft';
        $totalAmount = 0;

        foreach ($validated['items'] as $item) {
            $totalAmount += (float) $item['quantity'] * (float) $item['rate'];
        }

        $purchase = Purchase::create([
            'reference_number' => $ref,
            'vendor_id' => $validated['vendor_id'],
            'type' => $validated['type'],
            'date' => $validated['date'],
            'expected_date' => $validated['expected_date'] ?? null,
            'status' => $status,
            'total_amount' => $totalAmount,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];
            $amount = $qty * $rate;
            $receivedQty = $validated['type'] === 'direct' ? $qty : 0;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $amount,
                'received_quantity' => $receivedQty,
            ]);

            if ($validated['type'] === 'direct') {
                Product::where('id', $item['product_id'])->increment('quantity', $qty);
            }
        }

        $msg = $validated['type'] === 'direct'
            ? __('app.purchase.purchase_created')
            : __('app.purchase.order_created');

        return redirect()->route('purchases.show', $purchase)->with('success', $msg);
    }

    public function show(Purchase $purchase): View
    {
        $purchase->load(['vendor', 'items.product.unit']);

        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase): View
    {
        if (!$purchase->isDraft()) {
            return redirect()->route('purchases.show', $purchase)->with('error', __('app.purchase.cannot_edit'));
        }

        $purchase->load(['vendor', 'items.product.unit']);
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('purchases.edit', compact('purchase', 'vendors', 'products'));
    }

    public function update(Request $request, Purchase $purchase): RedirectResponse
    {
        if (!$purchase->isDraft()) {
            return redirect()->route('purchases.show', $purchase)->with('error', __('app.purchase.cannot_edit'));
        }

        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += (float) $item['quantity'] * (float) $item['rate'];
        }

        $purchase->update([
            'vendor_id' => $validated['vendor_id'],
            'date' => $validated['date'],
            'expected_date' => $validated['expected_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'total_amount' => $totalAmount,
        ]);

        $purchase->items()->delete();

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $qty * $rate,
                'received_quantity' => 0,
            ]);
        }

        return redirect()->route('purchases.show', $purchase)->with('success', __('app.purchase.order_updated'));
    }

    public function receive(Purchase $purchase): RedirectResponse
    {
        if ($purchase->isReceived()) {
            return redirect()->route('purchases.show', $purchase)->with('error', __('app.purchase.already_received'));
        }

        if (!$purchase->isOrder()) {
            return redirect()->route('purchases.show', $purchase)->with('error', __('app.purchase.direct_already_received'));
        }

        foreach ($purchase->items as $item) {
            $toReceive = $item->quantity - $item->received_quantity;
            if ($toReceive > 0) {
                Product::where('id', $item->product_id)->increment('quantity', $toReceive);
                $item->update(['received_quantity' => $item->quantity]);
            }
        }

        $purchase->update(['status' => 'received']);

        return redirect()->route('purchases.show', $purchase)->with('success', __('app.purchase.received'));
    }
}
