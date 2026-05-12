<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Purchase Requisitions
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('req_number')->unique();
            $table->date('req_date');
            $table->string('req_type')->default('general'); // general, raw_material, spare_parts
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'closed'])->default('draft');
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('req_id')->constrained('purchase_requisitions')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->string('unit', 20)->default('Pcs');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Purchase Orders
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('po_number')->unique();
            $table->date('po_date');
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('req_id')->nullable();
            $table->string('po_type')->default('local'); // local, import
            $table->date('expected_date')->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2)->default(0);
            $table->string('currency', 10)->default('BDT');
            $table->decimal('exchange_rate', 10, 4)->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'partial', 'received', 'cancelled'])->default('draft');
            $table->text('terms')->nullable();
            $table->timestamps();
        });

        Schema::create('po_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('po_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('received_qty', 15, 4)->default(0);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('line_total', 15, 2)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Goods Receive Notes
        Schema::create('goods_receive_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('grn_number')->unique();
            $table->date('grn_date');
            $table->foreignId('po_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('received_by');
            $table->enum('status', ['draft', 'qc_pending', 'accepted', 'partially_accepted', 'rejected'])->default('draft');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('grn_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_id')->constrained('goods_receive_notes')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('ordered_qty', 15, 4);
            $table->decimal('received_qty', 15, 4);
            $table->decimal('accepted_qty', 15, 4)->default(0);
            $table->decimal('rejected_qty', 15, 4)->default(0);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->string('batch_no')->nullable();
            $table->text('serial_nos')->nullable();
            $table->string('unit', 20)->default('Pcs');
            $table->string('qc_status')->default('pending'); // pending, passed, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grn_items');
        Schema::dropIfExists('goods_receive_notes');
        Schema::dropIfExists('po_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchase_requisition_items');
        Schema::dropIfExists('purchase_requisitions');
    }
};
