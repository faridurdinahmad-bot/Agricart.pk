<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = Customer::query()
            ->with('customerGroup')
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%"))
            ->when($request->status === 'inactive', fn ($q) => $q->where('status', 'inactive'), fn ($q) => $q->where('status', 'active'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        $customerGroups = CustomerGroup::orderBy('name')->get();

        return view('customers.create', ['customer' => new Customer, 'customerGroups' => $customerGroups]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'customer_group_id' => ['nullable', 'exists:customer_groups,id'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
        ]);

        Customer::create([
            ...$validated,
            'credit_limit' => $validated['credit_limit'] ?? 0,
            'balance' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('customers.index')->with('success', __('app.contacts.customer_created'));
    }

    public function edit(Customer $customer): View
    {
        $customerGroups = CustomerGroup::orderBy('name')->get();

        return view('customers.edit', compact('customer', 'customerGroups'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'customer_group_id' => ['nullable', 'exists:customer_groups,id'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
        ]);

        $customer->update([
            ...$validated,
            'credit_limit' => $validated['credit_limit'] ?? 0,
        ]);

        return redirect()->route('customers.index')->with('success', __('app.contacts.customer_updated'));
    }

    public function deactivate(Customer $customer): RedirectResponse
    {
        $customer->update(['status' => 'inactive']);

        return redirect()->route('customers.index')->with('success', __('app.contacts.customer_deactivated'));
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
            if (empty($data['name'] ?? '')) {
                continue;
            }
            $email = $data['email'] ?? null;
            if ($email && Customer::where('email', $email)->exists()) {
                continue;
            }
            Customer::create([
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'email' => $email,
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'credit_limit' => (float) ($data['credit_limit'] ?? 0),
                'balance' => 0,
                'status' => 'active',
            ]);
            $imported++;
        }

        return redirect()->route('customers.index')->with('success', __('app.contacts.customers_imported', ['count' => $imported]));
    }

    public function export(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['name', 'phone', 'email', 'address', 'city', 'credit_limit', 'balance', 'status']);

            Customer::cursor()->each(fn (Customer $c) => fputcsv($handle, [
                $c->name, $c->phone, $c->email, $c->address, $c->city, $c->credit_limit, $c->balance, $c->status,
            ]));

            fclose($handle);
        }, 200, $headers);
    }
}
