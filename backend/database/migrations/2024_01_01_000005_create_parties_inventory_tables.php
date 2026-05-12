<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Suppliers
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('supplier_code')->nullable();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Bangladesh');
            $table->string('trade_license')->nullable();
            $table->string('bin')->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Customers
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('customer_code')->nullable();
            $table->string('name');
            $table->enum('customer_type', ['retail', 'corporate', 'project', 'institutional'])->default('retail');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Dealers
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('dealer_code')->nullable();
            $table->string('name');
            $table->string('owner_name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('territory')->nullable();
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->decimal('security_deposit', 15, 2)->default(0);
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->string('trade_license')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status', ['pending', 'active', 'suspended', 'inactive'])->default('pending');
            $table->timestamps();
        });

        // Warehouses
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable();
            $table->enum('type', ['raw_material', 'finished_goods', 'spare_parts', 'transit', 'wip'])->default('finished_goods');
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Inventory (stock balances)
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_no')->nullable();
            $table->decimal('quantity', 15, 4)->default(0);
            $table->decimal('reserved_qty', 15, 4)->default(0);
            $table->decimal('min_stock', 15, 4)->default(0);
            $table->decimal('reorder_level', 15, 4)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->unique(['company_id', 'warehouse_id', 'product_id', 'batch_no']);
            $table->timestamps();
        });

        // Inventory transactions
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('transaction_type', ['receive', 'issue', 'transfer_in', 'transfer_out', 'adjustment', 'return', 'damage', 'scrap'])->default('receive');
            $table->decimal('quantity', 15, 4);
            $table->string('batch_no')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('ref_type')->nullable(); // grn, sales, work_order, etc.
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('ref_number')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
        Schema::dropIfExists('inventory');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('dealers');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('suppliers');
    }
};
