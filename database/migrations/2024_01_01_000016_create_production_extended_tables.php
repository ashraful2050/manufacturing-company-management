<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Demand Forecasts
        Schema::create('demand_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('period'); // 2025-01
            $table->enum('period_type', ['weekly', 'monthly', 'quarterly'])->default('monthly');
            $table->decimal('forecast_qty', 15, 4)->default(0);
            $table->decimal('actual_qty', 15, 4)->default(0);
            $table->string('forecast_method')->default('manual'); // manual, moving_average, exponential
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Master Production Schedule (MPS)
        Schema::create('master_production_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('mps_number')->unique();
            $table->string('period'); // 2025-01
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'released', 'closed'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('mps_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mps_id')->constrained('master_production_schedules')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('demand_qty', 15, 4)->default(0);
            $table->decimal('opening_stock', 15, 4)->default(0);
            $table->decimal('planned_production_qty', 15, 4)->default(0);
            $table->decimal('planned_ending_stock', 15, 4)->default(0);
            $table->timestamps();
        });

        // Material Requirement Planning (MRP)
        Schema::create('mrp_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('mrp_number')->unique();
            $table->date('run_date');
            $table->foreignId('mps_id')->nullable()->constrained('master_production_schedules')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['draft', 'processed', 'released'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('mrp_run_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mrp_run_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('required_qty', 15, 4)->default(0);
            $table->decimal('available_stock', 15, 4)->default(0);
            $table->decimal('on_order_qty', 15, 4)->default(0);
            $table->decimal('net_requirement', 15, 4)->default(0);
            $table->string('action_required')->nullable(); // purchase, produce
            $table->date('required_date')->nullable();
            $table->timestamps();
        });

        // Capacity Planning
        Schema::create('capacity_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('period'); // 2025-01
            $table->foreignId('production_line_id')->nullable()->constrained('production_lines')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->decimal('available_hours', 10, 2)->default(0);
            $table->decimal('required_hours', 10, 2)->default(0);
            $table->decimal('utilization_percentage', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Job Cards
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('card_number')->unique();
            $table->date('card_date');
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained('production_lines')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->string('operation_name')->nullable();
            $table->integer('sequence')->default(1);
            $table->decimal('planned_qty', 15, 4)->default(0);
            $table->decimal('produced_qty', 15, 4)->default(0);
            $table->decimal('rejected_qty', 15, 4)->default(0);
            $table->decimal('setup_time_minutes', 10, 2)->default(0);
            $table->decimal('run_time_minutes', 10, 2)->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'paused', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Daily Production Entries
        Schema::create('daily_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('entry_number')->unique();
            $table->date('production_date');
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained('production_lines')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->decimal('planned_qty', 15, 4)->default(0);
            $table->decimal('produced_qty', 15, 4)->default(0);
            $table->decimal('rejected_qty', 15, 4)->default(0);
            $table->decimal('rework_qty', 15, 4)->default(0);
            $table->decimal('scrap_qty', 15, 4)->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('entered_by')->nullable();
            $table->timestamps();
        });

        // Work-in-Progress Tracking
        Schema::create('production_wip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('stage'); // raw_cut, formed, assembled, painted, packed
            $table->decimal('quantity', 15, 4)->default(0);
            $table->foreignId('production_line_id')->nullable()->constrained('production_lines')->nullOnDelete();
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Production Rework
        Schema::create('production_reworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('rework_number')->unique();
            $table->date('rework_date');
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('daily_production_id')->nullable()->constrained('daily_productions')->nullOnDelete();
            $table->decimal('rework_qty', 15, 4)->default(0);
            $table->decimal('completed_qty', 15, 4)->default(0);
            $table->string('defect_type')->nullable();
            $table->text('defect_description')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();
        });

        // Production Scrap
        Schema::create('production_scraps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('scrap_number')->unique();
            $table->date('scrap_date');
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('scrap_qty', 15, 4)->default(0);
            $table->decimal('scrap_value', 15, 2)->default(0);
            $table->string('scrap_type')->nullable(); // cutting_waste, defective, breakage
            $table->boolean('is_saleable')->default(false);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Production Output (finished goods posting)
        Schema::create('production_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('output_number')->unique();
            $table->date('output_date');
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->decimal('produced_qty', 15, 4)->default(0);
            $table->string('batch_no')->nullable();
            $table->decimal('unit_cost', 15, 4)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'posted'])->default('draft');
            $table->timestamps();
        });

        // Production Variance Tracking
        Schema::create('production_variances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->string('variance_type'); // material, labor, overhead, scrap
            $table->decimal('standard_value', 15, 2)->default(0);
            $table->decimal('actual_value', 15, 2)->default(0);
            $table->decimal('variance_amount', 15, 2)->default(0);
            $table->decimal('variance_percentage', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Production Closings
        Schema::create('production_closings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('closing_number')->unique();
            $table->date('closing_date');
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->decimal('planned_qty', 15, 4)->default(0);
            $table->decimal('produced_qty', 15, 4)->default(0);
            $table->decimal('material_cost', 15, 2)->default(0);
            $table->decimal('labor_cost', 15, 2)->default(0);
            $table->decimal('overhead_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'posted'])->default('draft');
            $table->timestamps();
        });

        // Shift Rosters
        Schema::create('shift_rosters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shift_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->date('roster_date');
            $table->boolean('is_holiday')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'roster_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_rosters');
        Schema::dropIfExists('production_closings');
        Schema::dropIfExists('production_variances');
        Schema::dropIfExists('production_outputs');
        Schema::dropIfExists('production_scraps');
        Schema::dropIfExists('production_reworks');
        Schema::dropIfExists('production_wip');
        Schema::dropIfExists('daily_productions');
        Schema::dropIfExists('job_cards');
        Schema::dropIfExists('capacity_plans');
        Schema::dropIfExists('mrp_run_items');
        Schema::dropIfExists('mrp_runs');
        Schema::dropIfExists('mps_items');
        Schema::dropIfExists('master_production_schedules');
        Schema::dropIfExists('demand_forecasts');
    }
};
