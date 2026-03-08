<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseReturnController extends Controller
{
    public function index(Request $request): View
    {
        $returns = PurchaseReturn::query()
            ->with('vendor')
            ->when($request->vendor_id, fn ($q) => $q->where('vendor_id', $request->vendor_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();

        return view('purchase-returns.index', compact('returns', 'vendors'));
    }

    public function create(Request $request): View
    {
        $purchaseId = $request->get('purchase_id');
        $purchase = $purchaseId ? Purchase::with(['vendor', 'items.product.unit'])->find($purchaseId) : null;
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();
        $purchases = Purchase::where('status', 'received')->with('vendor')->latest()->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('purchase-returns.create', compact('purchase', 'vendors', 'purchases', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'purchase_id' => ['nullable', 'exists:purchases,id'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'date' => ['required', 'date'],
            'reason' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $seq = PurchaseReturn::where('reference_number', 'like', 'PR-' . now()->format('Ymd') . '-%')->count() + 1;
        $ref = 'PR-' . now()->format('Ymd') . '-' . str_pad($seq, 3, '0', STR_PAD_LEFT);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += (float) $item['quantity'] * (float) $item['rate'];
        }

        $return = PurchaseReturn::create([
            'reference_number' => $ref,
            'purchase_id' => $validated['purchase_id'] ?? null,
            'vendor_id' => $validated['vendor_id'],
            'date' => $validated['date'],
            'status' => 'draft',
            'total_amount' => $totalAmount,
            'reason' => $validated['reason'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];

            PurchaseReturnItem::create([
                'purchase_return_id' => $return->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $qty * $rate,
            ]);
        }

        return redirect()->route('purchase-returns.show', $return)->with('success', __('app.purchase.return_created'));
    }

    public function show(PurchaseReturn $purchaseReturn): View
    {
        $purchaseReturn->load(['vendor', 'purchase', 'items.product.unit']);

        return view('purchase-returns.show', compact('purchaseReturn'));
    }

    public function edit(PurchaseReturn $purchaseReturn): View
    {
        if ($purchaseReturn->status !== 'draft') {
            return redirect()->route('purchase-returns.show', $purchaseReturn)->with('error', __('app.purchase.return_cannot_edit'));
        }

        $purchaseReturn->load(['vendor', 'purchase', 'items.product.unit']);
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();
        $purchases = Purchase::where('status', 'received')->with('vendor')->latest()->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('purchase-returns.edit', compact('purchaseReturn', 'vendors', 'purchases', 'products'));
    }

    public function update(Request $request, PurchaseReturn $purchaseReturn): RedirectResponse
    {
        if ($purchaseReturn->status !== 'draft') {
            return redirect()->route('purchase-returns.show', $purchaseReturn)->with('error', __('app.purchase.return_cannot_edit'));
        }

        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'date' => ['required', 'date'],
            'reason' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += (float) $item['quantity'] * (float) $item['rate'];
        }

        $purchaseReturn->update([
            'vendor_id' => $validated['vendor_id'],
            'date' => $validated['date'],
            'reason' => $validated['reason'] ?? null,
            'total_amount' => $totalAmount,
        ]);

        $purchaseReturn->items()->delete();

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];

            PurchaseReturnItem::create([
                'purchase_return_id' => $purchaseReturn->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $qty * $rate,
            ]);
        }

        return redirect()->route('purchase-returns.show', $purchaseReturn)->with('success', __('app.purchase.return_updated'));
    }

    public function complete(PurchaseReturn $purchaseReturn): RedirectResponse
    {
        if ($purchaseReturn->status === 'completed') {
            return redirect()->route('purchase-returns.show', $purchaseReturn)->with('error', __('app.purchase.return_already_completed'));
        }

        foreach ($purchaseReturn->items as $item) {
            Product::where('id', $item->product_id)->decrement('quantity', $item->quantity);
        }

        $purchaseReturn->update(['status' => 'completed']);

        return redirect()->route('purchase-returns.index')->with('success', __('app.purchase.return_completed'));
    }
}
