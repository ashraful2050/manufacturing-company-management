<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Shop Floor Production Entries
        Schema::create('shop_floor_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('entry_number')->unique();
            $table->date('entry_date');
            $table->time('entry_time')->nullable();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_card_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained('production_lines')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->string('entry_type')->default('production'); // production, reject, rework, scrap, downtime
            $table->decimal('quantity', 15, 4)->default(0);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('entered_by')->nullable();
            $table->timestamps();
        });

        // Machine Downtime Entries
        Schema::create('machine_downtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('downtime_number')->unique();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->date('downtime_date');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('downtime_type')->default('breakdown'); // planned, breakdown, idle, changeover
            $table->string('reason_category')->nullable(); // electrical, mechanical, hydraulic, operator_error
            $table->text('reason_details')->nullable();
            $table->string('action_taken')->nullable();
            $table->unsignedBigInteger('reported_by')->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
        });

        // Production Interruption Log
        Schema::create('production_interruptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained('production_lines')->nullOnDelete();
            $table->date('interruption_date');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('interruption_type')->default('material_shortage'); // material_shortage, machine_breakdown, quality_issue, power_failure, manpower
            $table->text('description');
            $table->text('corrective_action')->nullable();
            $table->unsignedBigInteger('reported_by')->nullable();
            $table->timestamps();
        });

        // OEE (Overall Equipment Effectiveness) Tracking
        Schema::create('oee_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->date('record_date');
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->decimal('planned_runtime_minutes', 10, 2)->default(0);
            $table->decimal('actual_runtime_minutes', 10, 2)->default(0);
            $table->decimal('downtime_minutes', 10, 2)->default(0);
            $table->decimal('ideal_cycle_time_seconds', 10, 4)->default(0);
            $table->decimal('total_units', 15, 4)->default(0);
            $table->decimal('good_units', 15, 4)->default(0);
            $table->decimal('availability_percentage', 8, 2)->default(0);
            $table->decimal('performance_percentage', 8, 2)->default(0);
            $table->decimal('quality_percentage', 8, 2)->default(0);
            $table->decimal('oee_percentage', 8, 2)->default(0);
            $table->timestamps();
        });

        // QC Parameters Setup
        Schema::create('qc_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_category')->nullable(); // can apply to category
            $table->string('inspection_type')->default('incoming'); // incoming, in_process, final
            $table->string('parameter_type')->default('measurement'); // measurement, visual, functional, count
            $table->string('unit')->nullable(); // mm, kg, RPM, etc.
            $table->decimal('min_value', 15, 4)->nullable();
            $table->decimal('max_value', 15, 4)->nullable();
            $table->string('expected_value')->nullable();
            $table->boolean('is_critical')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('qc_parameter_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained('qc_inspections')->cascadeOnDelete();
            $table->foreignId('parameter_id')->constrained('qc_parameters')->cascadeOnDelete();
            $table->string('actual_value')->nullable();
            $table->boolean('is_passed')->default(true);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        // Non-Conformance Reports (NCR)
        Schema::create('non_conformance_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('ncr_number')->unique();
            $table->date('ncr_date');
            $table->foreignId('inspection_id')->nullable()->constrained('qc_inspections')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('source')->default('incoming'); // incoming, in_process, final, customer_complaint
            $table->string('ref_type')->nullable();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->text('nonconformance_description');
            $table->decimal('affected_qty', 15, 4)->default(0);
            $table->string('disposition')->nullable(); // use_as_is, rework, scrap, return_to_supplier
            $table->text('containment_action')->nullable();
            $table->unsignedBigInteger('raised_by')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->enum('status', ['open', 'under_investigation', 'capa_raised', 'closed'])->default('open');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        // CAPA (Corrective and Preventive Actions)
        Schema::create('capa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('capa_number')->unique();
            $table->date('raised_date');
            $table->foreignId('ncr_id')->nullable()->constrained('non_conformance_reports')->nullOnDelete();
            $table->enum('capa_type', ['corrective', 'preventive'])->default('corrective');
            $table->text('root_cause')->nullable();
            $table->text('corrective_action')->nullable();
            $table->text('preventive_action')->nullable();
            $table->date('target_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->unsignedBigInteger('raised_by')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->enum('status', ['open', 'in_progress', 'completed', 'verified', 'closed'])->default('open');
            $table->text('effectiveness_review')->nullable();
            $table->timestamps();
        });

        // Maintenance Schedules
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->string('schedule_name');
            $table->string('maintenance_type')->default('preventive'); // preventive, predictive, calibration
            $table->integer('frequency_days')->nullable(); // every X days
            $table->string('frequency_type')->default('days'); // days, hours, cycles
            $table->integer('frequency_value')->default(30);
            $table->date('last_done_date')->nullable();
            $table->date('next_due_date')->nullable();
            $table->text('checklist')->nullable(); // JSON or text
            $table->integer('estimated_duration_hours')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Maintenance Work Orders
        Schema::create('maintenance_work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('mwo_number')->unique();
            $table->date('mwo_date');
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('maintenance_schedules')->nullOnDelete();
            $table->string('maintenance_type')->default('preventive'); // preventive, breakdown, corrective
            $table->text('problem_description')->nullable();
            $table->date('planned_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->integer('actual_duration_hours')->nullable();
            $table->decimal('labor_cost', 15, 2)->default(0);
            $table->decimal('parts_cost', 15, 2)->default(0);
            $table->decimal('external_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->unsignedBigInteger('assigned_to')->nullable(); // technician
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'pending', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->text('work_done')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('mwo_spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mwo_id')->constrained('maintenance_work_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('line_total', 15, 2)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->timestamps();
        });

        // Calibration Schedules
        Schema::create('calibration_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->string('instrument_name')->nullable();
            $table->integer('frequency_months')->default(12);
            $table->date('last_calibration_date')->nullable();
            $table->date('next_calibration_date')->nullable();
            $table->string('calibrated_by')->nullable(); // internal or vendor name
            $table->string('certificate_number')->nullable();
            $table->string('certificate_file')->nullable();
            $table->enum('status', ['due', 'completed', 'overdue'])->default('due');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calibration_schedules');
        Schema::dropIfExists('mwo_spare_parts');
        Schema::dropIfExists('maintenance_work_orders');
        Schema::dropIfExists('maintenance_schedules');
        Schema::dropIfExists('capa');
        Schema::dropIfExists('non_conformance_reports');
        Schema::dropIfExists('qc_parameter_results');
        Schema::dropIfExists('qc_parameters');
        Schema::dropIfExists('oee_records');
        Schema::dropIfExists('production_interruptions');
        Schema::dropIfExists('machine_downtimes');
        Schema::dropIfExists('shop_floor_entries');
    }
};
