<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Warranty Registrations
        Schema::create('warranty_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('warranty_number')->unique();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('serial_no')->nullable();
            $table->string('batch_no')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->date('purchase_date');
            $table->date('warranty_expires_at');
            $table->string('qr_code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Service Tickets
        Schema::create('service_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('ticket_number')->unique();
            $table->date('complaint_date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('serial_no')->nullable();
            $table->foreignId('warranty_id')->nullable()->constrained('warranty_registrations')->nullOnDelete();
            $table->string('complaint_type')->nullable(); // noise, no_speed, no_start, physical_damage
            $table->text('complaint_detail')->nullable();
            $table->boolean('is_warranty')->default(false);
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->foreignId('service_branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->text('inspection_notes')->nullable();
            $table->decimal('repair_cost', 15, 2)->default(0);
            $table->decimal('parts_cost', 15, 2)->default(0);
            $table->decimal('labor_cost', 15, 2)->default(0);
            $table->string('resolution_type')->nullable(); // repaired, replaced, refunded, no_fault
            $table->enum('status', ['open', 'assigned', 'in_progress', 'waiting_parts', 'resolved', 'closed', 'cancelled'])->default('open');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->integer('customer_rating')->nullable();
            $table->text('customer_feedback')->nullable();
            $table->timestamps();
        });

        Schema::create('service_ticket_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('service_tickets')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4)->default(1);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->boolean('is_warranty_covered')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_ticket_parts');
        Schema::dropIfExists('service_tickets');
        Schema::dropIfExists('warranty_registrations');
    }
};
