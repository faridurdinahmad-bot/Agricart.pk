<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $accounts = Account::query()
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderBy('type')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('accounts.index', compact('accounts'));
    }

    public function create(): View
    {
        return view('accounts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:cash,bank'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'opening_balance' => ['required', 'numeric'],
            'notes' => ['nullable', 'string'],
        ]);

        $balance = (float) $validated['opening_balance'];

        Account::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'account_number' => $validated['account_number'] ?? null,
            'opening_balance' => $balance,
            'balance' => $balance,
            'status' => 'active',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('accounts.index')->with('success', __('app.finance.account_created'));
    }

    public function show(Account $account): View
    {
        $account->load(['transactions' => fn ($q) => $q->latest('date')->latest('id')->limit(50)]);

        return view('accounts.show', compact('account'));
    }

    public function edit(Account $account): View
    {
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:cash,bank'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $account->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'account_number' => $validated['account_number'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('accounts.index')->with('success', __('app.finance.account_updated'));
    }
}
