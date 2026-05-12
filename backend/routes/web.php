<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\AdminUserController;
// Masters
use App\Http\Controllers\Masters\UnitController;
use App\Http\Controllers\Masters\CurrencyController;
use App\Http\Controllers\Masters\TaxRateController;
use App\Http\Controllers\Masters\BrandController;
use App\Http\Controllers\Masters\MachineController;
use App\Http\Controllers\Masters\TransporterController;
use App\Http\Controllers\Masters\ShiftController;
use App\Http\Controllers\Masters\ProductionLineController;
use App\Http\Controllers\Masters\ProductionRouteController;
// CRM
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\OpportunityController;
use App\Http\Controllers\CRM\CustomerInquiryController;
use App\Http\Controllers\CRM\QuotationController;
use App\Http\Controllers\CRM\SalesContractController;
use App\Http\Controllers\CRM\PriceListController;
use App\Http\Controllers\CRM\TerritoryController;
use App\Http\Controllers\CRM\CommissionController;
use App\Http\Controllers\CRM\SalesTargetController;
// Procurement
use App\Http\Controllers\Procurement\RfqController;
use App\Http\Controllers\Procurement\SupplierQuotationController;
use App\Http\Controllers\Procurement\BlanketPoController;
use App\Http\Controllers\Procurement\SupplierRateContractController;
use App\Http\Controllers\Procurement\PurchaseReturnController;
use App\Http\Controllers\Procurement\DebitCreditNoteController;
use App\Http\Controllers\Procurement\ServiceReceiptController;
use App\Http\Controllers\Procurement\VendorEvaluationController;
// Inventory
use App\Http\Controllers\Inventory\BinLocationController;
use App\Http\Controllers\Inventory\SerialNumberController;
use App\Http\Controllers\Inventory\StoreRequisitionController;
use App\Http\Controllers\Inventory\MaterialIssueController;
use App\Http\Controllers\Inventory\MaterialReturnController;
use App\Http\Controllers\Inventory\StockCountController;
use App\Http\Controllers\Inventory\SalesReturnController;
// Production
use App\Http\Controllers\Production\FanCostingController;
use App\Http\Controllers\Production\DemandForecastController;
use App\Http\Controllers\Production\MpsController;
use App\Http\Controllers\Production\MrpController;
use App\Http\Controllers\Production\CapacityPlanController;
use App\Http\Controllers\Production\JobCardController;
use App\Http\Controllers\Production\DailyProductionController;
use App\Http\Controllers\Production\ProductionOutputController;
use App\Http\Controllers\Production\ProductionClosingController;
use App\Http\Controllers\Production\ShiftRosterController;
// Shop Floor
use App\Http\Controllers\ShopFloor\ShopFloorEntryController;
use App\Http\Controllers\ShopFloor\MachineDowntimeController;
use App\Http\Controllers\ShopFloor\OeeController;
// Quality Control
use App\Http\Controllers\QualityControl\QcParameterController;
use App\Http\Controllers\QualityControl\NonConformanceController;
use App\Http\Controllers\QualityControl\CapaController;
// Maintenance
use App\Http\Controllers\Maintenance\MaintenanceScheduleController;
use App\Http\Controllers\Maintenance\MaintenanceWorkOrderController;
use App\Http\Controllers\Maintenance\CalibrationController;
// HR
use App\Http\Controllers\HR\AttendanceController;
use App\Http\Controllers\HR\LeaveController;
use App\Http\Controllers\HR\PayrollController;
use App\Http\Controllers\HR\EmployeeLoanController;
use App\Http\Controllers\HR\RecruitmentController;
use App\Http\Controllers\HR\PerformanceEvaluationController;
use App\Http\Controllers\HR\TrainingController;
// Finance
use App\Http\Controllers\Finance\CostCenterController;
use App\Http\Controllers\Finance\BudgetController;
use App\Http\Controllers\Finance\BankAccountController;
use App\Http\Controllers\Finance\BankReconciliationController;
use App\Http\Controllers\Finance\CostSheetController;
// Logistics
use App\Http\Controllers\Logistics\DispatchPlanController;
use App\Http\Controllers\Logistics\GatePassController;
// Documents
use App\Http\Controllers\Documents\DocumentController;
// Compliance
use App\Http\Controllers\Compliance\ComplianceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Landing Page
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Company Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'company.auth'])->name('dashboard');

Route::middleware(['auth', 'company.auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =========================================================
    // MASTERS / SETUP
    // =========================================================
    Route::prefix('masters')->name('masters.')->group(function () {
        Route::resource('units', UnitController::class);
        Route::resource('currencies', CurrencyController::class);
        Route::resource('tax-rates', TaxRateController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('machines', MachineController::class);
        Route::resource('transporters', TransporterController::class);
        Route::resource('shifts', ShiftController::class);
        Route::resource('production-lines', ProductionLineController::class);
        Route::resource('production-routes', ProductionRouteController::class);
    });

    // =========================================================
    // CRM & SALES
    // =========================================================
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('leads', LeadController::class);
        Route::resource('opportunities', OpportunityController::class);
        Route::resource('inquiries', CustomerInquiryController::class);
        Route::resource('quotations', QuotationController::class);
        Route::resource('sales-contracts', SalesContractController::class);
        Route::resource('price-lists', PriceListController::class);
        Route::resource('territories', TerritoryController::class);
        Route::resource('commissions', CommissionController::class);
        Route::resource('sales-targets', SalesTargetController::class);
    });

    // =========================================================
    // PROCUREMENT (EXTENDED)
    // =========================================================
    Route::prefix('procurement')->name('procurement.')->group(function () {
        Route::resource('rfq', RfqController::class);
        Route::resource('supplier-quotations', SupplierQuotationController::class);
        Route::resource('blanket-orders', BlanketPoController::class);
        Route::resource('rate-contracts', SupplierRateContractController::class);
        Route::resource('purchase-returns', PurchaseReturnController::class);
        Route::resource('debit-credit-notes', DebitCreditNoteController::class);
        Route::resource('service-receipts', ServiceReceiptController::class);
        Route::resource('vendor-evaluations', VendorEvaluationController::class);
    });

    // =========================================================
    // INVENTORY (EXTENDED)
    // =========================================================
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('bin-locations', BinLocationController::class);
        Route::resource('serial-numbers', SerialNumberController::class);
        Route::resource('store-requisitions', StoreRequisitionController::class);
        Route::resource('material-issues', MaterialIssueController::class);
        Route::resource('material-returns', MaterialReturnController::class);
        Route::resource('stock-count', StockCountController::class);
        Route::resource('sales-returns', SalesReturnController::class);
    });

    // =========================================================
    // PRODUCTION (EXTENDED)
    // =========================================================
    Route::prefix('production')->name('production.')->group(function () {
        Route::resource('fan-costing', FanCostingController::class);
        Route::resource('demand-forecasts', DemandForecastController::class);
        Route::resource('mps', MpsController::class);
        Route::resource('mrp', MrpController::class);
        Route::resource('capacity-plans', CapacityPlanController::class);
        Route::resource('job-cards', JobCardController::class);
        Route::resource('daily-entries', DailyProductionController::class);
        Route::resource('outputs', ProductionOutputController::class);
        Route::resource('closings', ProductionClosingController::class);
        Route::resource('shift-roster', ShiftRosterController::class);
    });

    // =========================================================
    // SHOP FLOOR
    // =========================================================
    Route::prefix('shop-floor')->name('shop-floor.')->group(function () {
        Route::get('/', fn () => Inertia::render('ShopFloor/Dashboard'))->name('dashboard');
        Route::resource('entries', ShopFloorEntryController::class);
        Route::resource('downtime', MachineDowntimeController::class);
        Route::resource('oee', OeeController::class);
    });

    // =========================================================
    // QUALITY CONTROL (EXTENDED)
    // =========================================================
    Route::prefix('quality')->name('quality.')->group(function () {
        Route::resource('parameters', QcParameterController::class);
        Route::resource('ncr', NonConformanceController::class);
        Route::resource('capa', CapaController::class);
    });

    // =========================================================
    // MAINTENANCE
    // =========================================================
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::resource('schedules', MaintenanceScheduleController::class);
        Route::resource('work-orders', MaintenanceWorkOrderController::class);
        Route::resource('calibration', CalibrationController::class);
    });

    // =========================================================
    // HR & PAYROLL
    // =========================================================
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::resource('attendance', AttendanceController::class);
        Route::resource('leave', LeaveController::class);
        Route::resource('payroll', PayrollController::class);
        Route::resource('loans', EmployeeLoanController::class);
        Route::resource('recruitment', RecruitmentController::class);
        Route::resource('evaluations', PerformanceEvaluationController::class);
        Route::resource('training', TrainingController::class);
    });

    // =========================================================
    // ACCOUNTS & FINANCE (EXTENDED)
    // =========================================================
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::resource('cost-centers', CostCenterController::class);
        Route::resource('budgets', BudgetController::class);
        Route::resource('bank-accounts', BankAccountController::class);
        Route::resource('bank-reconciliation', BankReconciliationController::class);
        Route::resource('cost-sheets', CostSheetController::class);
    });

    // =========================================================
    // LOGISTICS
    // =========================================================
    Route::prefix('logistics')->name('logistics.')->group(function () {
        Route::resource('dispatch-plans', DispatchPlanController::class);
        Route::resource('gate-passes', GatePassController::class);
    });

    // =========================================================
    // DOCUMENT MANAGEMENT
    // =========================================================
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::resource('files', DocumentController::class);
    });

    // =========================================================
    // COMPLIANCE
    // =========================================================
    Route::prefix('compliance')->name('compliance.')->group(function () {
        Route::resource('records', ComplianceController::class);
        Route::get('licenses', fn () => Inertia::render('Compliance/Licenses'))->name('licenses');
    });

    // =========================================================
    // REPORTS & DASHBOARDS
    // =========================================================
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', fn () => Inertia::render('Reports/Index'))->name('index');
        Route::get('production', fn () => Inertia::render('Reports/Production'))->name('production');
        Route::get('sales', fn () => Inertia::render('Reports/Sales'))->name('sales');
        Route::get('purchase', fn () => Inertia::render('Reports/Purchase'))->name('purchase');
        Route::get('inventory', fn () => Inertia::render('Reports/Inventory'))->name('inventory');
        Route::get('finance', fn () => Inertia::render('Reports/Finance'))->name('finance');
        Route::get('hr', fn () => Inertia::render('Reports/Hr'))->name('hr');
        Route::get('machine-performance', fn () => Inertia::render('Reports/MachinePerformance'))->name('machine-performance');
        Route::get('rejection-scrap', fn () => Inertia::render('Reports/RejectionScrap'))->name('rejection-scrap');
        Route::get('mis-daily', fn () => Inertia::render('Reports/MisDaily'))->name('mis-daily');
        Route::get('mis-monthly', fn () => Inertia::render('Reports/MisMonthly'))->name('mis-monthly');
    });
});

// Super Admin Routes
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Company Management
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::patch('/companies/{company}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');

    // Plan Management
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');

    // Admin Users
    Route::get('/admin-users', [AdminUserController::class, 'index'])->name('admin-users.index');
    Route::post('/admin-users', [AdminUserController::class, 'store'])->name('admin-users.store');
    Route::patch('/admin-users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin-users.toggle-status');
    Route::patch('/admin-users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin-users.reset-password');
});

require __DIR__ . '/auth.php';

