<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ReturnPolicy;
use App\Models\Unit;
use App\Models\Warranty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['category', 'brand', 'unit'])
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('sku', 'like', "%{$request->search}%"))
            ->when($request->status === 'inactive', fn ($q) => $q->where('status', 'inactive'), fn ($q) => $q->where('status', 'active'))
            ->when($request->low_stock, fn ($q) => $q->whereColumn('quantity', '<=', 'reorder_level')->where('reorder_level', '>', 0))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $warranties = Warranty::orderBy('days')->get();
        $returnPolicies = ReturnPolicy::orderBy('days')->get();

        return view('products.create', [
            'product' => new Product,
            'categories' => $categories,
            'brands' => $brands,
            'units' => $units,
            'warranties' => $warranties,
            'returnPolicies' => $returnPolicies,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'warranty_id' => ['nullable', 'exists:warranties,id'],
            'return_policy_id' => ['nullable', 'exists:return_policies,id'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'numeric', 'min:0'],
            'reorder_level' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        Product::create([
            ...$validated,
            'purchase_price' => $validated['purchase_price'] ?? 0,
            'sale_price' => $validated['sale_price'] ?? 0,
            'quantity' => $validated['quantity'] ?? 0,
            'reorder_level' => $validated['reorder_level'] ?? 0,
            'status' => 'active',
        ]);

        return redirect()->route('products.index')->with('success', __('app.inventory.product_created'));
    }

    public function edit(Product $product): View
    {
        $product->load(['category', 'brand', 'unit', 'warranty', 'returnPolicy']);
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $warranties = Warranty::orderBy('days')->get();
        $returnPolicies = ReturnPolicy::orderBy('days')->get();

        return view('products.edit', compact('product', 'categories', 'brands', 'units', 'warranties', 'returnPolicies'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku,' . $product->id],
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'warranty_id' => ['nullable', 'exists:warranties,id'],
            'return_policy_id' => ['nullable', 'exists:return_policies,id'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'numeric', 'min:0'],
            'reorder_level' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $product->update([
            ...$validated,
            'purchase_price' => $validated['purchase_price'] ?? 0,
            'sale_price' => $validated['sale_price'] ?? 0,
            'quantity' => $validated['quantity'] ?? 0,
            'reorder_level' => $validated['reorder_level'] ?? 0,
        ]);

        return redirect()->route('products.index')->with('success', __('app.inventory.product_updated'));
    }

    public function deactivate(Product $product): RedirectResponse
    {
        $product->update(['status' => 'inactive']);

        return redirect()->route('products.index')->with('success', __('app.inventory.product_deactivated'));
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:2048']]);

        $path = $request->file('file')->getRealPath();
        $rows = array_map('str_getcsv', file($path));
        $header = array_shift($rows);

        $imported = 0;
        foreach ($rows as $row) {
            $data = @array_combine($header, array_pad($row, count($header), null)) ?: [];
            $data = array_change_key_case($data ?? [], CASE_LOWER);
            $sku = trim($data['sku'] ?? '');
            $name = trim($data['name'] ?? '');
            if (empty($sku) || empty($name)) {
                continue;
            }
            if (Product::where('sku', $sku)->exists()) {
                continue;
            }
            $unitId = Unit::where('name', $data['unit'] ?? '')->orWhere('symbol', $data['unit'] ?? '')->value('id');
            if (!$unitId) {
                continue;
            }
            Product::create([
                'sku' => $sku,
                'name' => $name,
                'category_id' => Category::where('name', $data['category'] ?? '')->value('id'),
                'brand_id' => Brand::where('name', $data['brand'] ?? '')->value('id'),
                'unit_id' => $unitId,
                'purchase_price' => (float) ($data['purchase_price'] ?? 0),
                'sale_price' => (float) ($data['sale_price'] ?? 0),
                'quantity' => (float) ($data['quantity'] ?? 0),
                'reorder_level' => (float) ($data['reorder_level'] ?? 0),
                'status' => 'active',
            ]);
            $imported++;
        }

        return redirect()->route('products.index')->with('success', __('app.inventory.products_imported', ['count' => $imported]));
    }

    public function export(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['sku', 'name', 'category', 'brand', 'unit', 'purchase_price', 'sale_price', 'quantity', 'reorder_level', 'status']);

            Product::with(['category', 'brand', 'unit'])->cursor()->each(fn (Product $p) => fputcsv($handle, [
                $p->sku,
                $p->name,
                $p->category?->name,
                $p->brand?->name,
                $p->unit?->name,
                $p->purchase_price,
                $p->sale_price,
                $p->quantity,
                $p->reorder_level,
                $p->status,
            ]));

            fclose($handle);
        }, 200, $headers);
    }
}
