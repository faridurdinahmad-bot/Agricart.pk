<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\LogisticsCost;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Shipment;
use App\Models\ShippingCarrier;
use App\Models\Staff;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function sales(Request $request): View
    {
        $from = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->get('to', now()->format('Y-m-d'));

        $query = Sale::where('status', 'completed')
            ->whereBetween('date', [$from, $to]);

        $totalSales = (clone $query)->sum('total_amount');
        $count = (clone $query)->count();
        $returnsTotal = SaleReturn::whereBetween('date', [$from, $to])->sum('total_amount');

        return view('reports.sales', compact('totalSales', 'count', 'returnsTotal', 'from', 'to'));
    }

    public function purchase(Request $request): View
    {
        $from = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->get('to', now()->format('Y-m-d'));

        $query = Purchase::whereIn('status', ['received', 'completed', 'partial'])
            ->whereBetween('date', [$from, $to]);

        $totalPurchases = (clone $query)->sum('total_amount');
        $count = (clone $query)->count();

        return view('reports.purchase', compact('totalPurchases', 'count', 'from', 'to'));
    }

    public function inventory(Request $request): View
    {
        $products = Product::where('status', 'active')->with(['category', 'unit'])->get();
        $totalValue = $products->sum(fn ($p) => $p->quantity * $p->purchase_price);
        $lowStockCount = $products->filter(fn ($p) => $p->reorder_level > 0 && $p->quantity <= $p->reorder_level)->count();

        return view('reports.inventory', compact('products', 'totalValue', 'lowStockCount'));
    }

    public function finance(Request $request): View
    {
        $accounts = Account::where('status', 'active')->get();
        $totalBalance = $accounts->sum('balance');

        $from = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->get('to', now()->format('Y-m-d'));

        $income = Transaction::where('type', 'income')->whereBetween('date', [$from, $to])->sum('amount');
        $expense = Transaction::where('type', 'expense')->whereBetween('date', [$from, $to])->sum('amount');

        return view('reports.finance', compact('accounts', 'totalBalance', 'income', 'expense', 'from', 'to'));
    }

    public function logistics(Request $request): View
    {
        $carriersCount = ShippingCarrier::where('status', 'active')->count();
        $shipmentsCount = Shipment::count();
        $pendingShipments = Shipment::whereIn('status', ['pending', 'shipped', 'in_transit'])->count();
        $deliveredCount = Shipment::where('status', 'delivered')->count();

        $from = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->get('to', now()->format('Y-m-d'));
        $totalCosts = LogisticsCost::whereBetween('date', [$from, $to])->sum('amount');

        return view('reports.logistics', compact('carriersCount', 'shipmentsCount', 'pendingShipments', 'deliveredCount', 'totalCosts', 'from', 'to'));
    }

    public function staffContacts(): View
    {
        $staffCount = Staff::where('status', 'active')->count();
        $customersCount = Customer::where('status', 'active')->count();
        $vendorsCount = Vendor::where('status', 'active')->count();

        return view('reports.staff-contacts', compact('staffCount', 'customersCount', 'vendorsCount'));
    }
}
