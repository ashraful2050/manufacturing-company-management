<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fan_cost_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('entry_number', 50)->unique();
            $table->date('entry_date');
            $table->string('fan_model', 150)->nullable();
            $table->string('title', 200)->nullable();
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->decimal('total_material_cost', 15, 2)->default(0);
            $table->decimal('total_labor_cost', 15, 2)->default(0);
            $table->decimal('total_overhead_cost', 15, 2)->default(0);
            $table->decimal('total_packing_cost', 15, 2)->default(0);
            $table->decimal('total_other_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->decimal('unit_cost', 15, 4)->default(0);
            $table->decimal('gross_profit', 15, 2)->default(0);
            $table->decimal('gross_margin_pct', 8, 2)->default(0);
            $table->enum('status', ['draft', 'finalized'])->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fan_cost_entry_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fan_cost_entry_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('sort_order');
            $table->string('name_bn', 200);
            $table->string('name_en', 200);
            $table->enum('category', ['raw_material', 'labor', 'overhead', 'packing', 'other']);
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fan_cost_entry_items');
        Schema::dropIfExists('fan_cost_entries');
    }
};
