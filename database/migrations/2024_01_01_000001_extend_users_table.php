<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->default('admin')->after('name'); // superadmin, admin, staff
            $table->unsignedBigInteger('company_id')->nullable()->after('user_type');
            $table->unsignedBigInteger('role_id')->nullable()->after('company_id');
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->json('ip_whitelist')->nullable();
            $table->boolean('must_change_password')->default(false);
            $table->timestamp('password_changed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_type', 'company_id', 'role_id', 'phone', 'avatar',
                'is_active', 'two_factor_enabled', 'two_factor_secret',
                'last_login_at', 'last_login_ip', 'ip_whitelist',
                'must_change_password', 'password_changed_at',
            ]);
        });
    }
};
