<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Attendance
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->date('attendance_date');
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->integer('working_minutes')->nullable();
            $table->integer('overtime_minutes')->default(0);
            $table->enum('status', ['present', 'absent', 'half_day', 'late', 'on_leave', 'holiday', 'weekend'])->default('present');
            $table->string('source')->default('manual'); // manual, biometric, mobile
            $table->string('biometric_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'attendance_date']);
        });

        // Leave Types
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('days_per_year')->default(0);
            $table->boolean('is_paid')->default(true);
            $table->boolean('carry_forward')->default(false);
            $table->integer('max_carry_forward_days')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Leave Requests
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leave_type_id')->constrained()->cascadeOnDelete();
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('total_days')->default(1);
            $table->text('reason');
            $table->string('supporting_document')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->text('approval_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        // Leave Balances
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leave_type_id')->constrained()->cascadeOnDelete();
            $table->integer('year');
            $table->decimal('entitled_days', 8, 1)->default(0);
            $table->decimal('taken_days', 8, 1)->default(0);
            $table->decimal('remaining_days', 8, 1)->default(0);
            $table->timestamps();
            $table->unique(['employee_id', 'leave_type_id', 'year']);
        });

        // Payroll Processing
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('payroll_number')->unique();
            $table->string('period'); // 2025-01
            $table->date('period_from');
            $table->date('period_to');
            $table->date('payment_date')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total_gross', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('total_net', 15, 2)->default(0);
            $table->integer('employee_count')->default(0);
            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'paid', 'cancelled'])->default('draft');
            $table->timestamps();
        });

        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->integer('working_days')->default(0);
            $table->integer('present_days')->default(0);
            $table->integer('absent_days')->default(0);
            $table->integer('leave_days')->default(0);
            $table->integer('overtime_hours')->default(0);
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->decimal('house_allowance', 15, 2)->default(0);
            $table->decimal('medical_allowance', 15, 2)->default(0);
            $table->decimal('transport_allowance', 15, 2)->default(0);
            $table->decimal('production_incentive', 15, 2)->default(0);
            $table->decimal('overtime_pay', 15, 2)->default(0);
            $table->decimal('other_allowances', 15, 2)->default(0);
            $table->decimal('gross_salary', 15, 2)->default(0);
            $table->decimal('income_tax', 15, 2)->default(0);
            $table->decimal('provident_fund', 15, 2)->default(0);
            $table->decimal('loan_deduction', 15, 2)->default(0);
            $table->decimal('advance_deduction', 15, 2)->default(0);
            $table->decimal('other_deductions', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('net_salary', 15, 2)->default(0);
            $table->string('payment_method')->default('bank'); // bank, cash
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });

        // Employee Loans & Advances
        Schema::create('employee_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('loan_number')->unique();
            $table->enum('loan_type', ['loan', 'advance'])->default('loan');
            $table->date('loan_date');
            $table->decimal('loan_amount', 15, 2)->default(0);
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->integer('installment_months')->default(1);
            $table->decimal('monthly_installment', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('balance_amount', 15, 2)->default(0);
            $table->date('first_deduction_month')->nullable();
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['pending', 'approved', 'active', 'closed', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Recruitment
        Schema::create('recruitment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('rr_number')->unique();
            $table->date('req_date');
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('vacancies')->default(1);
            $table->string('employment_type')->default('permanent'); // permanent, contract, probation
            $table->date('required_by')->nullable();
            $table->text('job_description')->nullable();
            $table->text('requirements')->nullable();
            $table->unsignedBigInteger('requested_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['draft', 'approved', 'published', 'shortlisting', 'filled', 'cancelled'])->default('draft');
            $table->timestamps();
        });

        Schema::create('job_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('req_id')->constrained('recruitment_requests')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('resume')->nullable();
            $table->date('applied_date');
            $table->string('source')->default('referral'); // job_portal, referral, walk_in, linkedin
            $table->decimal('expected_salary', 15, 2)->nullable();
            $table->integer('experience_years')->nullable();
            $table->enum('status', ['applied', 'shortlisted', 'interviewed', 'offered', 'hired', 'rejected'])->default('applied');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Performance Evaluations
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('period'); // 2025-H1, 2025
            $table->enum('evaluation_type', ['probation', 'annual', 'quarterly', 'project_based'])->default('annual');
            $table->decimal('overall_score', 5, 2)->nullable();
            $table->enum('rating', ['outstanding', 'exceeds_expectations', 'meets_expectations', 'needs_improvement', 'unsatisfactory'])->nullable();
            $table->text('strengths')->nullable();
            $table->text('improvements')->nullable();
            $table->text('goals')->nullable();
            $table->unsignedBigInteger('evaluated_by')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'closed'])->default('draft');
            $table->date('evaluation_date')->nullable();
            $table->timestamps();
        });

        // Training Programs
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('program_name');
            $table->string('training_type')->default('technical'); // technical, safety, soft_skills, compliance
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_hours')->nullable();
            $table->string('venue')->nullable();
            $table->string('trainer_name')->nullable();
            $table->decimal('cost', 15, 2)->default(0);
            $table->integer('max_participants')->nullable();
            $table->text('objectives')->nullable();
            $table->text('materials')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();
        });

        Schema::create('training_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('training_programs')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->enum('attendance_status', ['registered', 'attended', 'absent', 'certified'])->default('registered');
            $table->decimal('score', 5, 2)->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('certificate_file')->nullable();
            $table->date('certification_date')->nullable();
            $table->timestamps();
        });

        // Employee Documents
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('document_type'); // nid, passport, tin, academic, experience, contract
            $table->string('title');
            $table->string('file_path');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
        Schema::dropIfExists('training_participants');
        Schema::dropIfExists('training_programs');
        Schema::dropIfExists('performance_evaluations');
        Schema::dropIfExists('job_applicants');
        Schema::dropIfExists('recruitment_requests');
        Schema::dropIfExists('employee_loans');
        Schema::dropIfExists('payroll_items');
        Schema::dropIfExists('payrolls');
        Schema::dropIfExists('leave_balances');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('attendances');
    }
};
