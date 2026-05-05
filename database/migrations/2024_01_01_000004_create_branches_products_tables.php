<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Branches / Units
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable();
            $table->enum('type', ['head_office', 'factory', 'warehouse', 'showroom', 'service_center', 'dealer_point'])->default('head_office');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Product categories
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
        });

        // Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('product_code')->unique();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->enum('type', ['ceiling_fan', 'wall_fan', 'table_fan', 'stand_fan', 'exhaust_fan', 'industrial_fan', 'smart_fan', 'spare_part', 'accessory'])->default('ceiling_fan');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('specifications')->nullable();
            $table->integer('warranty_months')->default(12);
            $table->boolean('is_serial_tracked')->default(false);
            $table->boolean('is_batch_tracked')->default(false);
            $table->decimal('price_mrp', 10, 2)->default(0);
            $table->decimal('price_dealer', 10, 2)->default(0);
            $table->decimal('price_wholesale', 10, 2)->default(0);
            $table->decimal('price_project', 10, 2)->default(0);
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->string('unit', 20)->default('Pcs');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Bill of Materials
        Schema::create('boms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('version')->default('v1');
            $table->boolean('is_current')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('quantity', 10, 4);
            $table->string('unit', 20)->default('Pcs');
            $table->decimal('waste_percentage', 5, 2)->default(0);
            $table->boolean('is_alternate')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bom_items');
        Schema::dropIfExists('boms');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('branches');
    }
};
