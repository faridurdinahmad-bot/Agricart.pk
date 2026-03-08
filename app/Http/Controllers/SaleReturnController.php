<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleReturnController extends Controller
{
    public function index(Request $request): View
    {
        $returns = SaleReturn::query()
            ->with('customer')
            ->when($request->customer_id, fn ($q) => $q->where('customer_id', $request->customer_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $customers = Customer::where('status', 'active')->orderBy('name')->get();

        return view('sale-returns.index', compact('returns', 'customers'));
    }

    public function create(Request $request): View
    {
        $saleId = $request->get('sale_id');
        $sale = $saleId ? Sale::with(['customer', 'items.product.unit'])->find($saleId) : null;
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $sales = Sale::where('status', 'completed')->with('customer')->latest()->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('sale-returns.create', compact('sale', 'customers', 'sales', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sale_id' => ['nullable', 'exists:sales,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'date' => ['required', 'date'],
            'reason' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $seq = SaleReturn::where('reference_number', 'like', 'SR-' . now()->format('Ymd') . '-%')->count() + 1;
        $ref = 'SR-' . now()->format('Ymd') . '-' . str_pad($seq, 3, '0', STR_PAD_LEFT);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += (float) $item['quantity'] * (float) $item['rate'];
        }

        $return = SaleReturn::create([
            'reference_number' => $ref,
            'sale_id' => $validated['sale_id'] ?? null,
            'customer_id' => $validated['customer_id'],
            'date' => $validated['date'],
            'status' => 'draft',
            'total_amount' => $totalAmount,
            'reason' => $validated['reason'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];

            SaleReturnItem::create([
                'sale_return_id' => $return->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $qty * $rate,
            ]);
        }

        return redirect()->route('sale-returns.show', $return)->with('success', __('app.sale.return_created'));
    }

    public function show(SaleReturn $saleReturn): View
    {
        $saleReturn->load(['customer', 'sale', 'items.product.unit']);

        return view('sale-returns.show', compact('saleReturn'));
    }

    public function edit(SaleReturn $saleReturn): View
    {
        if ($saleReturn->status !== 'draft') {
            return redirect()->route('sale-returns.show', $saleReturn)->with('error', __('app.sale.return_cannot_edit'));
        }

        $saleReturn->load(['customer', 'sale', 'items.product.unit']);
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $sales = Sale::where('status', 'completed')->with('customer')->latest()->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('sale-returns.edit', compact('saleReturn', 'customers', 'sales', 'products'));
    }

    public function update(Request $request, SaleReturn $saleReturn): RedirectResponse
    {
        if ($saleReturn->status !== 'draft') {
            return redirect()->route('sale-returns.show', $saleReturn)->with('error', __('app.sale.return_cannot_edit'));
        }

        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
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

        $saleReturn->update([
            'customer_id' => $validated['customer_id'],
            'date' => $validated['date'],
            'reason' => $validated['reason'] ?? null,
            'total_amount' => $totalAmount,
        ]);

        $saleReturn->items()->delete();

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];

            SaleReturnItem::create([
                'sale_return_id' => $saleReturn->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $qty * $rate,
            ]);
        }

        return redirect()->route('sale-returns.show', $saleReturn)->with('success', __('app.sale.return_updated'));
    }

    public function complete(SaleReturn $saleReturn): RedirectResponse
    {
        if ($saleReturn->status === 'completed') {
            return redirect()->route('sale-returns.show', $saleReturn)->with('error', __('app.sale.return_already_completed'));
        }

        foreach ($saleReturn->items as $item) {
            Product::where('id', $item->product_id)->increment('quantity', $item->quantity);
        }

        $saleReturn->update(['status' => 'completed']);

        return redirect()->route('sale-returns.index')->with('success', __('app.sale.return_completed'));
    }
}
