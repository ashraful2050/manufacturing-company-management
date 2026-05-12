<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Units of Measurement
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('symbol', 20);
            $table->string('unit_type')->default('quantity'); // quantity, weight, volume, length, area
            $table->decimal('conversion_factor', 15, 6)->default(1);
            $table->unsignedBigInteger('base_unit_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Currencies
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->string('symbol', 10);
            $table->decimal('exchange_rate', 15, 6)->default(1);
            $table->boolean('is_base')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tax / VAT rates
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('rate', 8, 4)->default(0);
            $table->string('tax_type')->default('vat'); // vat, income_tax, excise, customs, withholding
            $table->string('applicable_on')->nullable(); // sales, purchase, both
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Brands
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Product Sub-categories (extended)
        Schema::create('product_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Machines / Equipment Master
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('machine_code')->nullable();
            $table->string('name');
            $table->string('machine_type')->nullable(); // stamping, assembly, testing, packing
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 15, 2)->default(0);
            $table->integer('capacity_per_hour')->nullable();
            $table->string('capacity_unit')->default('Pcs');
            $table->integer('ideal_run_time_per_day')->nullable(); // in minutes
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->date('last_calibration_date')->nullable();
            $table->date('next_calibration_date')->nullable();
            $table->enum('status', ['active', 'idle', 'under_maintenance', 'breakdown', 'retired'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Transporters / Logistics Partners
        Schema::create('transporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('vehicle_types')->nullable(); // truck, pickup, van
            $table->decimal('rate_per_km', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Vehicles (owned/contracted)
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transporter_id')->nullable()->constrained('transporters')->nullOnDelete();
            $table->string('registration_number');
            $table->string('vehicle_type')->default('truck'); // truck, pickup, van, motorcycle
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->decimal('capacity_kg', 10, 2)->nullable();
            $table->decimal('capacity_cbm', 10, 2)->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone', 20)->nullable();
            $table->string('driver_license')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Shifts
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_hours')->nullable();
            $table->integer('break_minutes')->default(0);
            $table->boolean('overnight')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Production Lines
        Schema::create('production_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable();
            $table->string('line_type')->nullable(); // assembly, fabrication, packaging, testing
            $table->integer('capacity_per_shift')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Production Routes / Routing Management
        Schema::create('production_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('version')->default('v1');
            $table->boolean('is_current')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('production_route_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('production_routes')->cascadeOnDelete();
            $table->integer('sequence');
            $table->string('operation_name');
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained('production_lines')->nullOnDelete();
            $table->decimal('setup_time_minutes', 8, 2)->default(0);
            $table->decimal('run_time_per_unit_minutes', 8, 2)->default(0);
            $table->integer('labor_count')->default(1);
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_route_operations');
        Schema::dropIfExists('production_routes');
        Schema::dropIfExists('production_lines');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('transporters');
        Schema::dropIfExists('machines');
        Schema::dropIfExists('product_sub_categories');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('tax_rates');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('units');
    }
};
