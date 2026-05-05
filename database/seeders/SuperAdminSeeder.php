<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Role;
use App\Models\Feature;
use App\Models\RolePermission;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin user
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@fancompany.com'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@fancompany.com',
                'password' => Hash::make('SuperAdmin@2024'),
                'user_type' => 'superadmin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info("SuperAdmin created: superadmin@fancompany.com / SuperAdmin@2024");

        // Create a demo company with enterprise plan
        $plan = Plan::where('slug', 'enterprise')->first();

        $company = Company::updateOrCreate(
            ['slug' => 'demo-fan-company'],
            [
                'name' => 'Demo Fan Company Ltd.',
                'slug' => 'demo-fan-company',
                'address' => '123 Industrial Zone, Gazipur',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'phone' => '01700000000',
                'email' => 'info@demofan.com',
                'trade_license' => 'TL-2024-001',
                'bin' => '000000000-0101',
                'tin' => '000000000',
                'plan_id' => $plan?->id,
                'is_active' => true,
                'trial_ends_at' => now()->addDays(30),
            ]
        );

        // Create demo admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@demofan.com'],
            [
                'name' => 'Company Admin',
                'email' => 'admin@demofan.com',
                'password' => Hash::make('Admin@2024'),
                'user_type' => 'admin',
                'company_id' => $company->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $company->update(['owner_user_id' => $adminUser->id]);

        // Create default branch (Head Office)
        Branch::updateOrCreate(
            ['company_id' => $company->id, 'code' => 'HO'],
            [
                'company_id' => $company->id,
                'name' => 'Head Office',
                'code' => 'HO',
                'type' => 'head_office',
                'address' => '123 Industrial Zone, Gazipur',
                'city' => 'Dhaka',
                'phone' => '01700000000',
                'is_active' => true,
            ]
        );

        // Create default roles for demo company
        $systemRoles = [
            ['name' => 'Management / Director', 'slug' => 'director'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Accounts Officer', 'slug' => 'accounts_officer'],
            ['name' => 'Purchase Officer', 'slug' => 'purchase_officer'],
            ['name' => 'Store Officer', 'slug' => 'store_officer'],
            ['name' => 'Factory Manager', 'slug' => 'factory_manager'],
            ['name' => 'Production Officer', 'slug' => 'production_officer'],
            ['name' => 'QC Officer', 'slug' => 'qc_officer'],
            ['name' => 'Sales Officer', 'slug' => 'sales_officer'],
            ['name' => 'Dealer Manager', 'slug' => 'dealer_manager'],
            ['name' => 'HR Officer', 'slug' => 'hr_officer'],
            ['name' => 'Service Center Executive', 'slug' => 'service_executive'],
            ['name' => 'Branch Manager', 'slug' => 'branch_manager'],
            ['name' => 'Showroom Salesman', 'slug' => 'showroom_salesman'],
            ['name' => 'Auditor', 'slug' => 'auditor'],
            ['name' => 'Customer Portal User', 'slug' => 'customer_portal'],
            ['name' => 'Dealer Portal User', 'slug' => 'dealer_portal'],
        ];

        foreach ($systemRoles as $roleData) {
            Role::updateOrCreate(
                ['company_id' => $company->id, 'slug' => $roleData['slug']],
                array_merge($roleData, ['company_id' => $company->id, 'is_system_role' => true])
            );
        }

        // Give admin role all permissions
        $adminRole = Role::where('company_id', $company->id)->where('slug', 'admin')->first();
        if ($adminRole) {
            $features = Feature::all();
            foreach ($features as $feature) {
                RolePermission::updateOrCreate(
                    ['role_id' => $adminRole->id, 'feature_id' => $feature->id],
                    [
                        'can_view' => true,
                        'can_create' => true,
                        'can_edit' => true,
                        'can_delete' => true,
                        'can_approve' => true,
                        'can_export' => true,
                    ]
                );
            }
            $adminUser->update(['role_id' => $adminRole->id]);
        }

        $this->command->info("Demo Company Admin created: admin@demofan.com / Admin@2024");
    }
}
