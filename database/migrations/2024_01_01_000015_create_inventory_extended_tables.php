<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bin / Location-wise stock storage
        Schema::create('bin_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('code', 30);
            $table->string('name');
            $table->string('aisle')->nullable();
            $table->string('rack')->nullable();
            $table->string('level')->nullable();
            $table->string('bin')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['warehouse_id', 'code']);
        });

        // Serial Number Tracking
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('serial_number');
            $table->string('batch_no')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bin_id')->nullable()->constrained('bin_locations')->nullOnDelete();
            $table->enum('status', ['in_stock', 'sold', 'returned', 'scrapped', 'under_warranty', 'in_service'])->default('in_stock');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('grn_id')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
            $table->unique(['company_id', 'serial_number']);
        });

        // Store Requisitions (material request from store)
        Schema::create('store_requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('sr_number')->unique();
            $table->date('req_date');
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('req_type')->default('production'); // production, maintenance, office
            $table->unsignedBigInteger('work_order_id')->nullable();
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'issued', 'rejected'])->default('draft');
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('store_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sr_id')->constrained('store_requisitions')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('required_qty', 15, 4);
            $table->decimal('approved_qty', 15, 4)->default(0);
            $table->decimal('issued_qty', 15, 4)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Material Issues (from store to production/department)
        Schema::create('material_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('issue_number')->unique();
            $table->date('issue_date');
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('sr_id')->nullable();
            $table->unsignedBigInteger('work_order_id')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('issue_to')->nullable(); // production_line, department, employee
            $table->unsignedBigInteger('issued_by');
            $table->unsignedBigInteger('received_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('material_issue_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('material_issues')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('requested_qty', 15, 4)->default(0);
            $table->decimal('issued_qty', 15, 4);
            $table->string('batch_no')->nullable();
            $table->foreignId('bin_id')->nullable()->constrained('bin_locations')->nullOnDelete();
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Material Returns (from production back to store)
        Schema::create('material_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('return_number')->unique();
            $table->date('return_date');
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('work_order_id')->nullable();
            $table->unsignedBigInteger('issue_id')->nullable();
            $table->string('return_reason')->nullable();
            $table->unsignedBigInteger('returned_by');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('material_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_return_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->string('batch_no')->nullable();
            $table->string('condition')->default('good'); // good, damaged, scrap
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Stock Count / Physical Inventory
        Schema::create('stock_count_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('session_number')->unique();
            $table->date('count_date');
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('count_type')->default('full'); // full, cycle, spot
            $table->string('status_flow')->nullable(); // category, location, product filter
            $table->unsignedBigInteger('conducted_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'in_progress', 'completed', 'approved', 'posted'])->default('draft');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_count_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('stock_count_sessions')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_no')->nullable();
            $table->foreignId('bin_id')->nullable()->constrained('bin_locations')->nullOnDelete();
            $table->decimal('system_qty', 15, 4)->default(0);
            $table->decimal('counted_qty', 15, 4)->default(0);
            $table->decimal('variance_qty', 15, 4)->default(0);
            $table->string('variance_reason')->nullable();
            $table->timestamps();
        });

        // Sales Returns
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('return_number')->unique();
            $table->date('return_date');
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('return_reason')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'restocked', 'credited'])->default('draft');
            $table->timestamps();
        });

        Schema::create('sales_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_return_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('line_total', 15, 2)->default(0);
            $table->string('condition')->default('good'); // good, damaged, defective
            $table->string('reason')->nullable();
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_return_items');
        Schema::dropIfExists('sales_returns');
        Schema::dropIfExists('stock_count_items');
        Schema::dropIfExists('stock_count_sessions');
        Schema::dropIfExists('material_return_items');
        Schema::dropIfExists('material_returns');
        Schema::dropIfExists('material_issue_items');
        Schema::dropIfExists('material_issues');
        Schema::dropIfExists('store_requisition_items');
        Schema::dropIfExists('store_requisitions');
        Schema::dropIfExists('serial_numbers');
        Schema::dropIfExists('bin_locations');
    }
};
