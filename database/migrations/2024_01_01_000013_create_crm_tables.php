<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Territories / Regions
        Schema::create('territories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('level', ['country', 'division', 'district', 'thana', 'area', 'region'])->default('region');
            $table->unsignedBigInteger('assigned_to')->nullable(); // user_id of sales rep
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Price Lists
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 30)->nullable();
            $table->enum('customer_type', ['retail', 'dealer', 'corporate', 'project', 'wholesale', 'export'])->default('retail');
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->string('currency_code', 10)->default('BDT');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('price_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_list_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('min_qty', 15, 4)->default(1);
            $table->timestamps();
        });

        // Discount Policies
        Schema::create('discount_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('discount_type', ['flat', 'percentage', 'buy_x_get_y', 'qty_break'])->default('percentage');
            $table->decimal('discount_value', 10, 4)->default(0);
            $table->string('applicable_on')->default('all'); // all, category, product, customer_type
            $table->unsignedBigInteger('applicable_id')->nullable();
            $table->decimal('min_order_value', 15, 2)->nullable();
            $table->decimal('min_order_qty', 15, 4)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Sales Targets
        Schema::create('sales_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('period'); // 2025-Q1, 2025-01, 2025
            $table->enum('period_type', ['monthly', 'quarterly', 'yearly'])->default('monthly');
            $table->string('target_for')->default('company'); // company, branch, territory, user, product
            $table->unsignedBigInteger('target_for_id')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('target_qty', 15, 4)->nullable();
            $table->decimal('target_amount', 15, 2)->nullable();
            $table->decimal('achieved_qty', 15, 4)->default(0);
            $table->decimal('achieved_amount', 15, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Sales Commission Setup
        Schema::create('commission_setups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('commission_type', ['percentage', 'flat_per_unit', 'slab'])->default('percentage');
            $table->decimal('commission_rate', 8, 4)->default(0);
            $table->json('slabs')->nullable(); // [{min: 0, max: 100000, rate: 2}, ...]
            $table->string('applicable_on')->default('all'); // all, product, category, territory
            $table->unsignedBigInteger('applicable_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('sales_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('user_id'); // sales rep
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('commission_setup_id')->nullable()->constrained('commission_setups')->nullOnDelete();
            $table->decimal('sales_amount', 15, 2)->default(0);
            $table->decimal('commission_amount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->date('paid_date')->nullable();
            $table->timestamps();
        });

        // Customer Inquiries
        Schema::create('customer_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('inquiry_number')->unique();
            $table->date('inquiry_date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('channel')->default('phone'); // phone, email, walk-in, website, whatsapp
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->text('inquiry_details');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->enum('status', ['new', 'in_progress', 'quoted', 'converted', 'closed', 'cancelled'])->default('new');
            $table->text('response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });

        // Leads
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('lead_number')->nullable();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('source')->default('cold_call'); // cold_call, referral, website, exhibition, social_media
            $table->foreignId('territory_id')->nullable()->constrained('territories')->nullOnDelete();
            $table->text('requirement')->nullable();
            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->enum('status', ['new', 'contacted', 'qualified', 'unqualified', 'converted', 'lost'])->default('new');
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->string('activity_type')->default('call'); // call, email, meeting, demo, visit
            $table->date('activity_date');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('done_by');
            $table->date('next_follow_up')->nullable();
            $table->timestamps();
        });

        // Opportunities
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->string('opportunity_number')->nullable();
            $table->string('name');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->date('expected_close_date')->nullable();
            $table->integer('probability')->default(50); // 0-100 %
            $table->enum('stage', ['prospecting', 'qualification', 'proposal', 'negotiation', 'closed_won', 'closed_lost'])->default('prospecting');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Quotations
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('quotation_number')->unique();
            $table->date('quotation_date');
            $table->date('valid_until')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('opportunity_id')->nullable();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('vat_amount', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2)->default(0);
            $table->string('payment_terms')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected', 'expired', 'converted'])->default('draft');
            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4)->default(1);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('vat_rate', 5, 2)->default(0);
            $table->decimal('line_total', 15, 2)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Sales Contracts
        Schema::create('sales_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('contract_number')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('contract_value', 15, 2)->default(0);
            $table->string('payment_terms')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'active', 'expired', 'terminated'])->default('draft');
            $table->timestamps();
        });

        Schema::create('sales_contract_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('sales_contracts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Customer Communication History
        Schema::create('customer_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('customer_id');
            $table->string('party_type')->default('customer'); // customer, dealer, lead
            $table->string('communication_type')->default('call'); // call, email, sms, meeting, visit
            $table->date('communication_date');
            $table->text('subject')->nullable();
            $table->text('details');
            $table->unsignedBigInteger('done_by');
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_communications');
        Schema::dropIfExists('sales_contract_items');
        Schema::dropIfExists('sales_contracts');
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('opportunities');
        Schema::dropIfExists('lead_activities');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('customer_inquiries');
        Schema::dropIfExists('sales_commissions');
        Schema::dropIfExists('commission_setups');
        Schema::dropIfExists('sales_targets');
        Schema::dropIfExists('discount_policies');
        Schema::dropIfExists('price_list_items');
        Schema::dropIfExists('price_lists');
        Schema::dropIfExists('territories');
    }
};
