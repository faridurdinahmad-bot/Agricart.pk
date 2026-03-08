<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = Transaction::query()
            ->with(['account', 'toAccount'])
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->account_id, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('account_id', $request->account_id)
                    ->orWhere('to_account_id', $request->account_id);
            }))
            ->when($request->from_date, fn ($q) => $q->whereDate('date', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('date', '<=', $request->to_date))
            ->latest('date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $accounts = Account::where('status', 'active')->orderBy('name')->get();

        return view('transactions.index', compact('transactions', 'accounts'));
    }

    public function income(Request $request): View
    {
        $transactions = Transaction::query()
            ->with(['account'])
            ->where('type', 'income')
            ->when($request->account_id, fn ($q) => $q->where('account_id', $request->account_id))
            ->when($request->from_date, fn ($q) => $q->whereDate('date', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('date', '<=', $request->to_date))
            ->latest('date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $accounts = Account::where('status', 'active')->orderBy('name')->get();

        return view('transactions.income', compact('transactions', 'accounts'));
    }

    public function expenses(Request $request): View
    {
        $transactions = Transaction::query()
            ->with(['account'])
            ->where('type', 'expense')
            ->when($request->account_id, fn ($q) => $q->where('account_id', $request->account_id))
            ->when($request->from_date, fn ($q) => $q->whereDate('date', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('date', '<=', $request->to_date))
            ->latest('date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $accounts = Account::where('status', 'active')->orderBy('name')->get();

        return view('transactions.expenses', compact('transactions', 'accounts'));
    }

    public function create(Request $request): View
    {
        $type = $request->get('type', 'income');
        $accounts = Account::where('status', 'active')->orderBy('name')->get();

        return view('transactions.create', compact('type', 'accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense,transfer'],
            'account_id' => ['required', 'exists:accounts,id'],
            'to_account_id' => ['nullable', 'required_if:type,transfer', 'exists:accounts,id', 'different:account_id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'reference' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'payee' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
        ]);

        $amount = (float) $validated['amount'];
        $account = Account::findOrFail($validated['account_id']);

        if ($validated['type'] === 'income') {
            $account->increment('balance', $amount);
            Transaction::create([
                'account_id' => $validated['account_id'],
                'type' => 'income',
                'amount' => $amount,
                'date' => $validated['date'],
                'reference' => $validated['reference'] ?? null,
                'description' => $validated['description'] ?? null,
                'payee' => $validated['payee'] ?? null,
                'category' => $validated['category'] ?? null,
            ]);
            $msg = __('app.finance.income_created');
        } elseif ($validated['type'] === 'expense') {
            $account->decrement('balance', $amount);
            Transaction::create([
                'account_id' => $validated['account_id'],
                'type' => 'expense',
                'amount' => $amount,
                'date' => $validated['date'],
                'reference' => $validated['reference'] ?? null,
                'description' => $validated['description'] ?? null,
                'payee' => $validated['payee'] ?? null,
                'category' => $validated['category'] ?? null,
            ]);
            $msg = __('app.finance.expense_created');
        } else {
            $toAccount = Account::findOrFail($validated['to_account_id']);
            $account->decrement('balance', $amount);
            $toAccount->increment('balance', $amount);
            Transaction::create([
                'account_id' => $validated['account_id'],
                'type' => 'transfer',
                'amount' => -$amount,
                'date' => $validated['date'],
                'reference' => $validated['reference'] ?? null,
                'description' => $validated['description'] ?? null,
                'to_account_id' => $validated['to_account_id'],
            ]);
            Transaction::create([
                'account_id' => $validated['to_account_id'],
                'type' => 'transfer',
                'amount' => $amount,
                'date' => $validated['date'],
                'reference' => $validated['reference'] ?? null,
                'description' => $validated['description'] ?? null,
                'to_account_id' => $validated['account_id'],
            ]);
            $msg = __('app.finance.transfer_created');
        }

        return redirect()->route('transactions.index')->with('success', $msg);
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['account', 'toAccount']);

        return view('transactions.show', compact('transaction'));
    }
}
