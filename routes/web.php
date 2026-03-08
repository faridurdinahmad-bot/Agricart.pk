<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\StaffSalaryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorGroupController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\ReturnPolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ShippingCarrierController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DeliveryVehicleController;
use App\Http\Controllers\LogisticsCostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::post('/locale', [LocaleController::class, 'switch'])->name('locale.switch')->middleware('throttle:60,1');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email')->middleware('throttle:3,1');
    Route::view('/register', 'auth.placeholder')->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('staff', StaffController::class)->except(['destroy', 'show']);
    Route::post('staff/import', [StaffController::class, 'import'])->name('staff.import');
    Route::get('staff-export', [StaffController::class, 'export'])->name('staff.export');
    Route::post('staff/{staff}/deactivate', [StaffController::class, 'deactivate'])->name('staff.deactivate');

    Route::get('roles-assign', [RoleController::class, 'assign'])->name('roles.assign');
    Route::post('roles-assign', [RoleController::class, 'assignStore'])->name('roles.assign.store');
    Route::post('roles/{role}/copy', [RoleController::class, 'copy'])->name('roles.copy');
    Route::resource('roles', RoleController::class)->except(['show']);

    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
    Route::post('attendance/mark', [AttendanceController::class, 'markStore'])->name('attendance.mark.store');
    Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

    Route::get('leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
    Route::get('leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
    Route::post('leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
    Route::post('leave-requests/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
    Route::post('leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');

    Route::resource('leave-types', LeaveTypeController::class)->except(['show']);

    Route::get('payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
    Route::post('payroll', [PayrollController::class, 'store'])->name('payroll.store');
    Route::get('payroll/salaries', [StaffSalaryController::class, 'index'])->name('payroll.salaries');
    Route::get('payroll/salaries/create', [StaffSalaryController::class, 'create'])->name('payroll.salaries.create');
    Route::post('payroll/salaries', [StaffSalaryController::class, 'store'])->name('payroll.salaries.store');
    Route::get('payroll/salaries/{staffSalary}/edit', [StaffSalaryController::class, 'edit'])->name('payroll.salaries.edit');
    Route::put('payroll/salaries/{staffSalary}', [StaffSalaryController::class, 'update'])->name('payroll.salaries.update');
    Route::get('payroll/{payroll}', [PayrollController::class, 'show'])->name('payroll.show');
    Route::post('payroll/{payroll}/process', [PayrollController::class, 'process'])->name('payroll.process');
    Route::get('payroll/{payroll}/slip/{staff}', [PayrollController::class, 'slip'])->name('payroll.slip');

    Route::resource('customers', CustomerController::class)->except(['destroy', 'show']);
    Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::get('customers-export', [CustomerController::class, 'export'])->name('customers.export');
    Route::post('customers/{customer}/deactivate', [CustomerController::class, 'deactivate'])->name('customers.deactivate');

    Route::resource('customer-groups', CustomerGroupController::class)->except(['show']);

    Route::resource('vendors', VendorController::class)->except(['destroy', 'show']);
    Route::post('vendors/import', [VendorController::class, 'import'])->name('vendors.import');
    Route::get('vendors-export', [VendorController::class, 'export'])->name('vendors.export');
    Route::post('vendors/{vendor}/deactivate', [VendorController::class, 'deactivate'])->name('vendors.deactivate');

    Route::resource('vendor-groups', VendorGroupController::class)->except(['show']);

    Route::resource('units', UnitController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('brands', BrandController::class)->except(['show']);
    Route::resource('warranties', WarrantyController::class)->except(['show']);
    Route::resource('return-policies', ReturnPolicyController::class)->except(['show']);

    Route::resource('products', ProductController::class)->except(['destroy', 'show']);
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('products-export', [ProductController::class, 'export'])->name('products.export');
    Route::post('products/{product}/deactivate', [ProductController::class, 'deactivate'])->name('products.deactivate');

    Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::post('purchases/{purchase}/receive', [PurchaseController::class, 'receive'])->name('purchases.receive');

    Route::get('purchase-returns', [PurchaseReturnController::class, 'index'])->name('purchase-returns.index');
    Route::get('purchase-returns/create', [PurchaseReturnController::class, 'create'])->name('purchase-returns.create');
    Route::post('purchase-returns', [PurchaseReturnController::class, 'store'])->name('purchase-returns.store');
    Route::get('purchase-returns/{purchaseReturn}', [PurchaseReturnController::class, 'show'])->name('purchase-returns.show');
    Route::get('purchase-returns/{purchaseReturn}/edit', [PurchaseReturnController::class, 'edit'])->name('purchase-returns.edit');
    Route::put('purchase-returns/{purchaseReturn}', [PurchaseReturnController::class, 'update'])->name('purchase-returns.update');
    Route::post('purchase-returns/{purchaseReturn}/complete', [PurchaseReturnController::class, 'complete'])->name('purchase-returns.complete');

    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/hold', [SaleController::class, 'hold'])->name('sales.hold');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
    Route::put('sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
    Route::post('sales/{sale}/complete', [SaleController::class, 'complete'])->name('sales.complete');

    Route::get('sale-returns', [SaleReturnController::class, 'index'])->name('sale-returns.index');
    Route::get('sale-returns/create', [SaleReturnController::class, 'create'])->name('sale-returns.create');
    Route::post('sale-returns', [SaleReturnController::class, 'store'])->name('sale-returns.store');
    Route::get('sale-returns/{saleReturn}', [SaleReturnController::class, 'show'])->name('sale-returns.show');
    Route::get('sale-returns/{saleReturn}/edit', [SaleReturnController::class, 'edit'])->name('sale-returns.edit');
    Route::put('sale-returns/{saleReturn}', [SaleReturnController::class, 'update'])->name('sale-returns.update');
    Route::post('sale-returns/{saleReturn}/complete', [SaleReturnController::class, 'complete'])->name('sale-returns.complete');

    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');
    Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('accounts/{account}', [AccountController::class, 'update'])->name('accounts.update');

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/income', [TransactionController::class, 'income'])->name('transactions.income');
    Route::get('transactions/expenses', [TransactionController::class, 'expenses'])->name('transactions.expenses');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

    Route::resource('shipping-carriers', ShippingCarrierController::class)->except(['destroy']);
    Route::resource('shipments', ShipmentController::class)->except(['destroy']);
    Route::resource('delivery-vehicles', DeliveryVehicleController::class)->except(['destroy']);
    Route::resource('logistics-costs', LogisticsCostController::class)->except(['destroy']);

    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
    Route::get('reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('reports/finance', [ReportController::class, 'finance'])->name('reports.finance');
    Route::get('reports/logistics', [ReportController::class, 'logistics'])->name('reports.logistics');
    Route::get('reports/staff-contacts', [ReportController::class, 'staffContacts'])->name('reports.staff-contacts');

    Route::get('settings/business', [SettingsController::class, 'business'])->name('settings.business');
    Route::put('settings/business', [SettingsController::class, 'businessUpdate'])->name('settings.business.update');
    Route::get('settings/theme', [SettingsController::class, 'theme'])->name('settings.theme');
    Route::get('settings/sync', [SettingsController::class, 'sync'])->name('settings.sync');
    Route::get('settings/backup', [SettingsController::class, 'backup'])->name('settings.backup');
    Route::get('settings/sms-email', [SettingsController::class, 'smsEmail'])->name('settings.sms-email');
});

Route::fallback(function () {
    return redirect()->route('welcome');
});
