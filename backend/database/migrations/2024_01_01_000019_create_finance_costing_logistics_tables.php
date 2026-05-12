<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cost Centers
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('code', 30)->nullable();
            $table->string('name');
            $table->string('cost_center_type')->default('department'); // department, project, product_line, machine
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Budget Heads
        Schema::create('budget_heads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category')->default('opex'); // capex, opex, revenue
            $table->foreignId('account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Budgets
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('budget_number')->unique();
            $table->string('period'); // 2025-01 or FY-2025
            $table->enum('period_type', ['monthly', 'quarterly', 'yearly'])->default('yearly');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('cost_center_id')->nullable()->constrained()->nullOnDelete();
            $table->string('budget_type')->default('expense'); // revenue, expense, capex
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'active', 'closed'])->default('draft');
            $table->timestamps();
        });

        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->cascadeOnDelete();
            $table->foreignId('budget_head_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->decimal('budgeted_amount', 15, 2)->default(0);
            $table->decimal('actual_amount', 15, 2)->default(0);
            $table->decimal('variance', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Bank Accounts
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('branch_name')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('currency', 10)->default('BDT');
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->foreignId('account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Bank Reconciliation
        Schema::create('bank_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('reconciliation_number')->unique();
            $table->foreignId('bank_account_id')->constrained()->cascadeOnDelete();
            $table->date('statement_date');
            $table->date('reconciled_up_to');
            $table->decimal('book_balance', 15, 2)->default(0);
            $table->decimal('bank_balance', 15, 2)->default(0);
            $table->decimal('outstanding_deposits', 15, 2)->default(0);
            $table->decimal('outstanding_payments', 15, 2)->default(0);
            $table->decimal('adjusted_balance', 15, 2)->default(0);
            $table->decimal('difference', 15, 2)->default(0);
            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'closed'])->default('draft');
            $table->timestamps();
        });

        Schema::create('bank_reconciliation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reconciliation_id')->constrained('bank_reconciliations')->cascadeOnDelete();
            $table->date('transaction_date');
            $table->string('description');
            $table->string('transaction_type')->default('debit'); // debit, credit
            $table->decimal('amount', 15, 2)->default(0);
            $table->boolean('is_reconciled')->default(false);
            $table->string('reference')->nullable();
            $table->timestamps();
        });

        // Costing - Overhead Pools
        Schema::create('overhead_pools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('period'); // 2025-01
            $table->string('allocation_base')->default('machine_hours'); // machine_hours, labor_hours, direct_cost, units
            $table->decimal('total_overhead', 15, 2)->default(0);
            $table->decimal('total_base_units', 15, 4)->default(0);
            $table->decimal('overhead_rate', 15, 4)->default(0);
            $table->timestamps();
        });

        // Cost Sheets
        Schema::create('cost_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('cost_sheet_number')->unique();
            $table->string('costing_type')->default('standard'); // standard, actual, job, batch, process
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('work_order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('period')->nullable(); // 2025-01
            $table->decimal('production_qty', 15, 4)->default(0);
            $table->decimal('raw_material_cost', 15, 2)->default(0);
            $table->decimal('packing_material_cost', 15, 2)->default(0);
            $table->decimal('direct_labor_cost', 15, 2)->default(0);
            $table->decimal('machine_cost', 15, 2)->default(0);
            $table->decimal('overhead_cost', 15, 2)->default(0);
            $table->decimal('other_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->decimal('unit_cost', 15, 4)->default(0);
            $table->decimal('selling_price', 15, 4)->default(0);
            $table->decimal('gross_profit', 15, 2)->default(0);
            $table->decimal('gross_margin_percentage', 8, 2)->default(0);
            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'finalized'])->default('draft');
            $table->timestamps();
        });

        Schema::create('cost_sheet_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_sheet_id')->constrained()->cascadeOnDelete();
            $table->string('cost_category'); // raw_material, labor, machine, overhead, other
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('description');
            $table->decimal('quantity', 15, 4)->default(0);
            $table->decimal('unit_rate', 15, 4)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('standard_amount', 15, 2)->default(0);
            $table->decimal('variance', 15, 2)->default(0);
            $table->timestamps();
        });

        // Logistics - Dispatch Plans
        Schema::create('dispatch_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('plan_number')->unique();
            $table->date('dispatch_date');
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('transporter_id')->nullable()->constrained()->nullOnDelete();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone', 20)->nullable();
            $table->text('route_details')->nullable();
            $table->decimal('total_weight_kg', 10, 2)->nullable();
            $table->decimal('transport_cost', 15, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['planned', 'in_transit', 'delivered', 'cancelled'])->default('planned');
            $table->timestamps();
        });

        Schema::create('dispatch_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dispatch_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('challan_id')->nullable()->constrained('delivery_challans')->nullOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->text('delivery_address')->nullable();
            $table->enum('status', ['pending', 'delivered', 'failed'])->default('pending');
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });

        // Gate Passes
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('gp_number')->unique();
            $table->date('gp_date');
            $table->string('gp_type')->default('outward'); // inward, outward, returnable
            $table->string('party_name')->nullable();
            $table->string('party_type')->nullable(); // customer, supplier, visitor, own
            $table->unsignedBigInteger('party_id')->nullable();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->string('vehicle_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->text('purpose')->nullable();
            $table->datetime('in_time')->nullable();
            $table->datetime('out_time')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['pending', 'approved', 'returned', 'closed'])->default('pending');
            $table->timestamps();
        });

        Schema::create('gate_pass_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gate_pass_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_description')->nullable();
            $table->decimal('quantity', 15, 4)->default(1);
            $table->string('unit', 20)->default('Pcs');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Document Management
        Schema::create('document_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('module')->nullable(); // purchase, sales, qc, hr, production
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('folder_id')->nullable()->constrained('document_folders')->nullOnDelete();
            $table->string('title');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->nullable(); // pdf, docx, xlsx, jpg
            $table->integer('file_size')->nullable(); // in KB
            $table->string('module')->nullable(); // purchase, sales, qc, hr
            $table->string('ref_type')->nullable();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('version')->default('v1');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'pending_approval', 'approved', 'archived'])->default('draft');
            $table->timestamps();
        });

        // Compliance Records
        Schema::create('compliance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('compliance_type'); // vat, labor_law, environmental, safety, iso, fire
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->string('responsible_person')->nullable();
            $table->foreignId('document_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'overdue', 'not_applicable'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Licenses & Certificates
        Schema::create('license_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('license_type'); // trade_license, fire, environment, bsti, iso, export
            $table->string('license_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('issuing_authority')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('alert_before_days')->default(30);
            $table->enum('status', ['active', 'expired', 'pending_renewal'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('license_certificates');
        Schema::dropIfExists('compliance_records');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('document_folders');
        Schema::dropIfExists('gate_pass_items');
        Schema::dropIfExists('gate_passes');
        Schema::dropIfExists('dispatch_plan_items');
        Schema::dropIfExists('dispatch_plans');
        Schema::dropIfExists('cost_sheet_items');
        Schema::dropIfExists('cost_sheets');
        Schema::dropIfExists('overhead_pools');
        Schema::dropIfExists('bank_reconciliation_items');
        Schema::dropIfExists('bank_reconciliations');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('budget_items');
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('budget_heads');
        Schema::dropIfExists('cost_centers');
    }
};
