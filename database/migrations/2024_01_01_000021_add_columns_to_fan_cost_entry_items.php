<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fan_cost_entry_items', function (Blueprint $table) {
            $table->decimal('qty', 15, 4)->default(0)->after('category');
            $table->decimal('unit_price', 15, 4)->default(0)->after('qty');
            $table->decimal('appreciation', 8, 2)->default(0)->after('unit_price'); // % markup/overhead
            $table->enum('source', ['purchase', 'in_house'])->default('purchase')->after('appreciation');
            // amount is now auto: qty × unit_price × (1 + appreciation/100)
        });
    }

    public function down(): void
    {
        Schema::table('fan_cost_entry_items', function (Blueprint $table) {
            $table->dropColumn(['qty', 'unit_price', 'appreciation', 'source']);
        });
    }
};
