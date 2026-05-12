<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('user_type')->nullable();
            $table->string('action'); // created, updated, deleted, viewed, approved, rejected
            $table->string('table_name')->nullable();
            $table->unsignedBigInteger('record_id')->nullable();
            $table->string('record_label')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'created_at']);
            $table->index(['company_id', 'created_at']);
            $table->index(['table_name', 'record_id']);
        });

        // System Notifications
        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('type'); // due_reminder, low_stock, complaint_pending, approval_pending
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Approval Workflows
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('module'); // purchase, sales, payment, warranty_replacement
            $table->string('name');
            $table->json('levels'); // [{level: 1, role_id: x, min_amount: 0, max_amount: 1000}, ...]
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Approval Requests
        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workflow_id')->constrained('approval_workflows')->cascadeOnDelete();
            $table->string('ref_type');
            $table->unsignedBigInteger('ref_id');
            $table->string('ref_number')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->unsignedBigInteger('requested_by');
            $table->integer('current_level')->default(1);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('final_approved_by')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        // Email/SMS templates
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('type')->default('email'); // email, sms
            $table->string('subject')->nullable();
            $table->text('body');
            $table->json('variables')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['company_id', 'slug', 'type']);
        });

        // Login history
        Schema::create('login_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('is_successful')->default(true);
            $table->string('failure_reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_history');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('approval_requests');
        Schema::dropIfExists('approval_workflows');
        Schema::dropIfExists('system_notifications');
        Schema::dropIfExists('audit_logs');
    }
};
