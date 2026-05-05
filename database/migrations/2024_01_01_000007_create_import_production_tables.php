<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Import (LC) Management
        Schema::create('import_lcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('lc_number')->unique();
            $table->date('lc_date');
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('bank_name')->nullable();
            $table->decimal('lc_value', 15, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->decimal('exchange_rate', 10, 4)->default(1);
            $table->string('pi_number')->nullable();
            $table->string('shipment_mode')->nullable(); // air, sea, land
            $table->date('shipment_date')->nullable();
            $table->date('eta')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('port_of_discharge')->nullable();
            $table->string('container_number')->nullable();
            $table->string('bl_number')->nullable();
            $table->decimal('freight_cost', 15, 2)->default(0);
            $table->decimal('insurance', 15, 2)->default(0);
            $table->decimal('customs_duty', 15, 2)->default(0);
            $table->decimal('vat_on_import', 15, 2)->default(0);
            $table->decimal('clearing_charges', 15, 2)->default(0);
            $table->decimal('transport_charges', 15, 2)->default(0);
            $table->decimal('other_charges', 15, 2)->default(0);
            $table->decimal('total_landed_cost', 15, 2)->default(0);
            $table->enum('status', ['draft', 'open', 'shipped', 'arrived', 'cleared', 'received', 'closed'])->default('draft');
            $table->timestamps();
        });

        // Production Work Orders
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('wo_number')->unique();
            $table->date('wo_date');
            $table->date('target_date')->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bom_id')->nullable()->constrained('boms')->nullOnDelete();
            $table->decimal('planned_qty', 15, 4);
            $table->decimal('produced_qty', 15, 4)->default(0);
            $table->decimal('rejected_qty', 15, 4)->default(0);
            $table->string('shift')->nullable();
            $table->string('production_line')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'in_progress', 'paused', 'completed', 'cancelled'])->default('draft');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('work_order_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wo_id')->constrained('work_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('planned_qty', 15, 4);
            $table->decimal('issued_qty', 15, 4)->default(0);
            $table->decimal('actual_qty', 15, 4)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // QC Inspections
        Schema::create('qc_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('inspection_number')->unique();
            $table->date('inspection_date');
            $table->string('inspection_type')->default('incoming'); // incoming, in_process, final
            $table->string('ref_type')->nullable(); // grn, work_order, etc.
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('sample_qty', 15, 4)->default(0);
            $table->decimal('passed_qty', 15, 4)->default(0);
            $table->decimal('failed_qty', 15, 4)->default(0);
            $table->enum('result', ['passed', 'failed', 'conditional'])->default('passed');
            $table->text('defect_details')->nullable();
            $table->unsignedBigInteger('inspected_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qc_inspections');
        Schema::dropIfExists('work_order_materials');
        Schema::dropIfExists('work_orders');
        Schema::dropIfExists('import_lcs');
    }
};
