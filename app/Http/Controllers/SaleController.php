<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $sales = Sale::query()
            ->with('customer')
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->customer_id, fn ($q) => $q->where('customer_id', $request->customer_id))
            ->when($request->from_date, fn ($q) => $q->whereDate('date', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('date', '<=', $request->to_date))
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $customers = Customer::where('status', 'active')->orderBy('name')->get();

        return view('sales.index', compact('sales', 'customers'));
    }

    public function hold(Request $request): View
    {
        $sales = Sale::query()
            ->with('customer')
            ->where('status', 'hold')
            ->when($request->customer_id, fn ($q) => $q->where('customer_id', $request->customer_id))
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $customers = Customer::where('status', 'active')->orderBy('name')->get();

        return view('sales.hold', compact('sales', 'customers'));
    }

    public function create(Request $request): View
    {
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'date' => ['required', 'date'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'action' => ['required', 'in:complete,hold'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $seq = Sale::where('reference_number', 'like', 'INV-' . now()->format('Ymd') . '-%')->count() + 1;
        $ref = 'INV-' . now()->format('Ymd') . '-' . str_pad($seq, 3, '0', STR_PAD_LEFT);

        $status = $validated['action'] === 'complete' ? 'completed' : 'hold';
        $totalAmount = 0;

        foreach ($validated['items'] as $item) {
            $totalAmount += (float) $item['quantity'] * (float) $item['rate'];
        }

        $sale = Sale::create([
            'reference_number' => $ref,
            'customer_id' => $validated['customer_id'],
            'type' => 'sale',
            'date' => $validated['date'],
            'due_date' => $validated['due_date'] ?? null,
            'status' => $status,
            'total_amount' => $totalAmount,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];
            $amount = $qty * $rate;

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $amount,
            ]);

            if ($status === 'completed') {
                Product::where('id', $item['product_id'])->decrement('quantity', $qty);
            }
        }

        $msg = $status === 'completed'
            ? __('app.sale.sale_created')
            : __('app.sale.sale_held');

        return redirect()->route('sales.show', $sale)->with('success', $msg);
    }

    public function show(Sale $sale): View
    {
        $sale->load(['customer', 'items.product.unit']);

        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale): View
    {
        if ($sale->isCompleted()) {
            return redirect()->route('sales.show', $sale)->with('error', __('app.sale.cannot_edit'));
        }

        $sale->load(['customer', 'items.product.unit']);
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $products = Product::where('status', 'active')->with('unit')->orderBy('name')->get();

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, Sale $sale): RedirectResponse
    {
        if ($sale->isCompleted()) {
            return redirect()->route('sales.show', $sale)->with('error', __('app.sale.cannot_edit'));
        }

        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'date' => ['required', 'date'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'action' => ['required', 'in:complete,hold'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += (float) $item['quantity'] * (float) $item['rate'];
        }

        $newStatus = $validated['action'] === 'complete' ? 'completed' : 'hold';

        $sale->update([
            'customer_id' => $validated['customer_id'],
            'date' => $validated['date'],
            'due_date' => $validated['due_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => $newStatus,
            'total_amount' => $totalAmount,
        ]);

        $sale->items()->delete();

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['quantity'];
            $rate = (float) $item['rate'];

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $qty * $rate,
            ]);

            if ($newStatus === 'completed') {
                Product::where('id', $item['product_id'])->decrement('quantity', $qty);
            }
        }

        return redirect()->route('sales.show', $sale)->with('success', __('app.sale.sale_updated'));
    }

    public function complete(Sale $sale): RedirectResponse
    {
        if ($sale->isCompleted()) {
            return redirect()->route('sales.show', $sale)->with('error', __('app.sale.already_completed'));
        }

        foreach ($sale->items as $item) {
            Product::where('id', $item->product_id)->decrement('quantity', $item->quantity);
        }

        $sale->update(['status' => 'completed']);

        return redirect()->route('sales.show', $sale)->with('success', __('app.sale.completed'));
    }
}
