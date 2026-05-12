<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Request For Quotation (RFQ)
        Schema::create('request_for_quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('rfq_number')->unique();
            $table->date('rfq_date');
            $table->date('response_due_date')->nullable();
            $table->unsignedBigInteger('req_id')->nullable(); // from purchase_requisitions
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['draft', 'sent', 'received', 'compared', 'closed'])->default('draft');
            $table->timestamps();
        });

        Schema::create('rfq_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')->constrained('request_for_quotations')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->string('unit', 20)->default('Pcs');
            $table->text('specifications')->nullable();
            $table->timestamps();
        });

        Schema::create('rfq_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')->constrained('request_for_quotations')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['sent', 'responded', 'no_response'])->default('sent');
            $table->date('sent_at')->nullable();
            $table->date('responded_at')->nullable();
            $table->timestamps();
        });

        // Supplier Quotations
        Schema::create('supplier_quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('sq_number')->unique();
            $table->foreignId('rfq_id')->nullable()->constrained('request_for_quotations')->nullOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->date('quotation_date');
            $table->date('valid_until')->nullable();
            $table->string('currency', 10)->default('BDT');
            $table->decimal('exchange_rate', 10, 4)->default(1);
            $table->string('payment_terms')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->decimal('net_amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_selected')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        Schema::create('supplier_quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sq_id')->constrained('supplier_quotations')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('line_total', 15, 2)->default(0);
            $table->integer('lead_time_days')->nullable();
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Blanket Purchase Orders
        Schema::create('blanket_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('bpo_number')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_value', 15, 2)->default(0);
            $table->decimal('consumed_value', 15, 2)->default(0);
            $table->string('currency', 10)->default('BDT');
            $table->text('terms')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'active', 'closed', 'cancelled'])->default('draft');
            $table->timestamps();
        });

        Schema::create('blanket_po_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bpo_id')->constrained('blanket_purchase_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('agreed_qty', 15, 4);
            $table->decimal('released_qty', 15, 4)->default(0);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Supplier Rate Contracts
        Schema::create('supplier_rate_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('contract_number')->unique();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('payment_terms')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'active', 'expired', 'terminated'])->default('draft');
            $table->timestamps();
        });

        Schema::create('supplier_rate_contract_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('supplier_rate_contracts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('max_qty', 15, 4)->nullable();
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Purchase Returns
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('return_number')->unique();
            $table->date('return_date');
            $table->foreignId('grn_id')->nullable()->constrained('goods_receive_notes')->nullOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('return_reason')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'returned', 'credited'])->default('draft');
            $table->timestamps();
        });

        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_return_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('line_total', 15, 2)->default(0);
            $table->string('reason')->nullable();
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Debit / Credit Notes
        Schema::create('debit_credit_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('note_number')->unique();
            $table->date('note_date');
            $table->enum('note_type', ['debit', 'credit'])->default('debit');
            $table->string('party_type')->default('supplier'); // supplier, customer, dealer
            $table->unsignedBigInteger('party_id');
            $table->string('ref_type')->nullable(); // purchase_return, sales_return, manual
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('reason');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'adjusted', 'cancelled'])->default('draft');
            $table->timestamps();
        });

        // Service Receipts (for service-based procurement)
        Schema::create('service_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('receipt_number')->unique();
            $table->date('receipt_date');
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('po_id')->nullable()->constrained('purchase_orders')->nullOnDelete();
            $table->text('service_description');
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2)->default(0);
            $table->unsignedBigInteger('received_by');
            $table->enum('status', ['draft', 'approved', 'invoiced'])->default('draft');
            $table->timestamps();
        });

        // Vendor Performance Evaluations
        Schema::create('vendor_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('period'); // 2025-Q1
            $table->decimal('quality_score', 5, 2)->default(0); // 0-100
            $table->decimal('delivery_score', 5, 2)->default(0);
            $table->decimal('price_score', 5, 2)->default(0);
            $table->decimal('service_score', 5, 2)->default(0);
            $table->decimal('overall_score', 5, 2)->default(0);
            $table->integer('total_orders')->default(0);
            $table->integer('on_time_deliveries')->default(0);
            $table->integer('defective_items')->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('evaluated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_evaluations');
        Schema::dropIfExists('service_receipts');
        Schema::dropIfExists('debit_credit_notes');
        Schema::dropIfExists('purchase_return_items');
        Schema::dropIfExists('purchase_returns');
        Schema::dropIfExists('supplier_rate_contract_items');
        Schema::dropIfExists('supplier_rate_contracts');
        Schema::dropIfExists('blanket_po_items');
        Schema::dropIfExists('blanket_purchase_orders');
        Schema::dropIfExists('supplier_quotation_items');
        Schema::dropIfExists('supplier_quotations');
        Schema::dropIfExists('rfq_suppliers');
        Schema::dropIfExists('rfq_items');
        Schema::dropIfExists('request_for_quotations');
    }
};
