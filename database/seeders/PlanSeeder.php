<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Feature;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for small fan dealers and showrooms. Get started with essential features.',
                'price_monthly' => 1500,
                'price_yearly' => 15000,
                'max_users' => 5,
                'max_branches' => 1,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'features' => [
                    'company_profile', 'branch_management',
                    'user_management', 'role_management',
                    'product_catalog', 'product_categories',
                    'customer_management',
                    'sales_order', 'sales_invoice', 'delivery_challan',
                    'stock_management', 'inventory_reports',
                    'management_dashboard', 'in_app_alerts',
                ],
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Ideal for growing fan companies with multiple showrooms and dealer networks.',
                'price_monthly' => 4500,
                'price_yearly' => 45000,
                'max_users' => 20,
                'max_branches' => 5,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    'company_profile', 'branch_management', 'vat_tax_setup',
                    'user_management', 'role_management', 'permission_management', 'audit_logs',
                    'product_catalog', 'product_categories', 'bom_management', 'product_pricing',
                    'purchase_requisition', 'purchase_order', 'goods_receive', 'supplier_management',
                    'warehouse_management', 'stock_management', 'stock_transfer', 'stock_adjustment', 'inventory_reports',
                    'customer_management', 'lead_management',
                    'sales_order', 'sales_invoice', 'sales_return', 'delivery_challan', 'pricing_management', 'sales_reports',
                    'dealer_registration',
                    'warranty_registration', 'service_tickets',
                    'chart_of_accounts', 'voucher_entry', 'receivable_payable', 'bank_management', 'financial_reports',
                    'vat_management', 'mushak_report',
                    'employee_management', 'attendance', 'leave_management', 'payroll',
                    'management_dashboard', 'sales_dashboard', 'in_app_alerts', 'email_notifications', 'sms_notifications',
                    'approval_workflow',
                ],
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Complete solution for large fan manufacturers with factories, warehouses, and nationwide dealer networks.',
                'price_monthly' => 12000,
                'price_yearly' => 120000,
                'max_users' => -1, // unlimited
                'max_branches' => -1, // unlimited
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [], // all features
            ],
        ];

        foreach ($plans as $planData) {
            $featureKeys = $planData['features'];
            unset($planData['features']);

            $plan = Plan::updateOrCreate(['slug' => $planData['slug']], $planData);

            if (empty($featureKeys)) {
                // Enterprise gets all features
                $allFeatureIds = Feature::pluck('id');
                $syncData = [];
                foreach ($allFeatureIds as $id) {
                    $syncData[$id] = ['is_enabled' => true];
                }
                $plan->features()->sync($syncData);
            } else {
                $features = Feature::whereIn('feature_key', $featureKeys)->get();
                $syncData = [];
                foreach ($features as $feature) {
                    $syncData[$feature->id] = ['is_enabled' => true];
                }
                $plan->features()->sync($syncData);
            }
        }
    }
}
