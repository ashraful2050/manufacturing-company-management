<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            // Company Setup
            ['module' => 'Company Setup', 'feature_key' => 'company_profile', 'feature_name' => 'Company Profile', 'icon' => 'building', 'sort_order' => 1],
            ['module' => 'Company Setup', 'feature_key' => 'branch_management', 'feature_name' => 'Branch Management', 'icon' => 'git-branch', 'sort_order' => 2],
            ['module' => 'Company Setup', 'feature_key' => 'vat_tax_setup', 'feature_name' => 'VAT & Tax Setup', 'icon' => 'receipt', 'sort_order' => 3],

            // User & Access Control
            ['module' => 'User Management', 'feature_key' => 'user_management', 'feature_name' => 'User Management', 'icon' => 'users', 'sort_order' => 10],
            ['module' => 'User Management', 'feature_key' => 'role_management', 'feature_name' => 'Role Management', 'icon' => 'shield', 'sort_order' => 11],
            ['module' => 'User Management', 'feature_key' => 'permission_management', 'feature_name' => 'Permission Management', 'icon' => 'key', 'sort_order' => 12],
            ['module' => 'User Management', 'feature_key' => 'audit_logs', 'feature_name' => 'Audit Logs', 'icon' => 'activity', 'sort_order' => 13],

            // Product Management
            ['module' => 'Product Management', 'feature_key' => 'product_catalog', 'feature_name' => 'Product Catalog', 'icon' => 'package', 'sort_order' => 20],
            ['module' => 'Product Management', 'feature_key' => 'product_categories', 'feature_name' => 'Product Categories', 'icon' => 'grid', 'sort_order' => 21],
            ['module' => 'Product Management', 'feature_key' => 'bom_management', 'feature_name' => 'BOM Management', 'icon' => 'layers', 'sort_order' => 22],
            ['module' => 'Product Management', 'feature_key' => 'product_pricing', 'feature_name' => 'Product Pricing', 'icon' => 'tag', 'sort_order' => 23],

            // Procurement
            ['module' => 'Procurement', 'feature_key' => 'purchase_requisition', 'feature_name' => 'Purchase Requisition', 'icon' => 'file-text', 'sort_order' => 30],
            ['module' => 'Procurement', 'feature_key' => 'purchase_order', 'feature_name' => 'Purchase Order', 'icon' => 'shopping-cart', 'sort_order' => 31],
            ['module' => 'Procurement', 'feature_key' => 'goods_receive', 'feature_name' => 'Goods Receive (GRN)', 'icon' => 'truck', 'sort_order' => 32],
            ['module' => 'Procurement', 'feature_key' => 'supplier_management', 'feature_name' => 'Supplier Management', 'icon' => 'users', 'sort_order' => 33],

            // Import Management
            ['module' => 'Import Management', 'feature_key' => 'lc_management', 'feature_name' => 'LC Management', 'icon' => 'anchor', 'sort_order' => 40],
            ['module' => 'Import Management', 'feature_key' => 'import_costing', 'feature_name' => 'Import Costing', 'icon' => 'dollar-sign', 'sort_order' => 41],

            // Inventory
            ['module' => 'Inventory', 'feature_key' => 'warehouse_management', 'feature_name' => 'Warehouse Management', 'icon' => 'home', 'sort_order' => 50],
            ['module' => 'Inventory', 'feature_key' => 'stock_management', 'feature_name' => 'Stock Management', 'icon' => 'box', 'sort_order' => 51],
            ['module' => 'Inventory', 'feature_key' => 'stock_transfer', 'feature_name' => 'Stock Transfer', 'icon' => 'arrow-right', 'sort_order' => 52],
            ['module' => 'Inventory', 'feature_key' => 'stock_adjustment', 'feature_name' => 'Stock Adjustment', 'icon' => 'sliders', 'sort_order' => 53],
            ['module' => 'Inventory', 'feature_key' => 'inventory_reports', 'feature_name' => 'Inventory Reports', 'icon' => 'bar-chart', 'sort_order' => 54],

            // Production
            ['module' => 'Production', 'feature_key' => 'production_planning', 'feature_name' => 'Production Planning', 'icon' => 'calendar', 'sort_order' => 60],
            ['module' => 'Production', 'feature_key' => 'work_order', 'feature_name' => 'Work Order', 'icon' => 'clipboard', 'sort_order' => 61],
            ['module' => 'Production', 'feature_key' => 'material_issue', 'feature_name' => 'Material Issue', 'icon' => 'arrow-up', 'sort_order' => 62],
            ['module' => 'Production', 'feature_key' => 'production_costing', 'feature_name' => 'Production Costing', 'icon' => 'calculator', 'sort_order' => 63],

            // Quality Control
            ['module' => 'Quality Control', 'feature_key' => 'incoming_qc', 'feature_name' => 'Incoming QC', 'icon' => 'check-square', 'sort_order' => 70],
            ['module' => 'Quality Control', 'feature_key' => 'in_process_qc', 'feature_name' => 'In-Process QC', 'icon' => 'check-circle', 'sort_order' => 71],
            ['module' => 'Quality Control', 'feature_key' => 'final_qc', 'feature_name' => 'Final QC', 'icon' => 'check', 'sort_order' => 72],

            // Sales
            ['module' => 'Sales', 'feature_key' => 'sales_order', 'feature_name' => 'Sales Order', 'icon' => 'shopping-bag', 'sort_order' => 80],
            ['module' => 'Sales', 'feature_key' => 'sales_invoice', 'feature_name' => 'Sales Invoice', 'icon' => 'file-invoice', 'sort_order' => 81],
            ['module' => 'Sales', 'feature_key' => 'sales_return', 'feature_name' => 'Sales Return', 'icon' => 'rotate-ccw', 'sort_order' => 82],
            ['module' => 'Sales', 'feature_key' => 'delivery_challan', 'feature_name' => 'Delivery Challan', 'icon' => 'truck', 'sort_order' => 83],
            ['module' => 'Sales', 'feature_key' => 'pricing_management', 'feature_name' => 'Pricing Management', 'icon' => 'tag', 'sort_order' => 84],
            ['module' => 'Sales', 'feature_key' => 'sales_reports', 'feature_name' => 'Sales Reports', 'icon' => 'trending-up', 'sort_order' => 85],

            // Dealer Management
            ['module' => 'Dealer Management', 'feature_key' => 'dealer_registration', 'feature_name' => 'Dealer Registration', 'icon' => 'user-plus', 'sort_order' => 90],
            ['module' => 'Dealer Management', 'feature_key' => 'dealer_portal', 'feature_name' => 'Dealer Portal', 'icon' => 'globe', 'sort_order' => 91],
            ['module' => 'Dealer Management', 'feature_key' => 'dealer_incentives', 'feature_name' => 'Dealer Incentives', 'icon' => 'gift', 'sort_order' => 92],

            // CRM
            ['module' => 'CRM', 'feature_key' => 'customer_management', 'feature_name' => 'Customer Management', 'icon' => 'user', 'sort_order' => 100],
            ['module' => 'CRM', 'feature_key' => 'lead_management', 'feature_name' => 'Lead Management', 'icon' => 'target', 'sort_order' => 101],
            ['module' => 'CRM', 'feature_key' => 'customer_feedback', 'feature_name' => 'Customer Feedback', 'icon' => 'message-square', 'sort_order' => 102],

            // Warranty & Service
            ['module' => 'Warranty & Service', 'feature_key' => 'warranty_registration', 'feature_name' => 'Warranty Registration', 'icon' => 'shield-check', 'sort_order' => 110],
            ['module' => 'Warranty & Service', 'feature_key' => 'service_tickets', 'feature_name' => 'Service Tickets', 'icon' => 'tool', 'sort_order' => 111],
            ['module' => 'Warranty & Service', 'feature_key' => 'replacement_management', 'feature_name' => 'Replacement Management', 'icon' => 'refresh-cw', 'sort_order' => 112],
            ['module' => 'Warranty & Service', 'feature_key' => 'service_reports', 'feature_name' => 'Service Reports', 'icon' => 'bar-chart-2', 'sort_order' => 113],

            // Accounts & Finance
            ['module' => 'Accounts & Finance', 'feature_key' => 'chart_of_accounts', 'feature_name' => 'Chart of Accounts', 'icon' => 'book', 'sort_order' => 120],
            ['module' => 'Accounts & Finance', 'feature_key' => 'voucher_entry', 'feature_name' => 'Voucher Entry', 'icon' => 'edit', 'sort_order' => 121],
            ['module' => 'Accounts & Finance', 'feature_key' => 'receivable_payable', 'feature_name' => 'Receivable & Payable', 'icon' => 'credit-card', 'sort_order' => 122],
            ['module' => 'Accounts & Finance', 'feature_key' => 'bank_management', 'feature_name' => 'Bank Management', 'icon' => 'landmark', 'sort_order' => 123],
            ['module' => 'Accounts & Finance', 'feature_key' => 'financial_reports', 'feature_name' => 'Financial Reports', 'icon' => 'pie-chart', 'sort_order' => 124],

            // VAT & Tax
            ['module' => 'VAT & Tax', 'feature_key' => 'vat_management', 'feature_name' => 'VAT Management', 'icon' => 'percent', 'sort_order' => 130],
            ['module' => 'VAT & Tax', 'feature_key' => 'mushak_report', 'feature_name' => 'Mushak Reports', 'icon' => 'file', 'sort_order' => 131],

            // HR & Payroll
            ['module' => 'HR & Payroll', 'feature_key' => 'employee_management', 'feature_name' => 'Employee Management', 'icon' => 'users', 'sort_order' => 140],
            ['module' => 'HR & Payroll', 'feature_key' => 'attendance', 'feature_name' => 'Attendance Management', 'icon' => 'clock', 'sort_order' => 141],
            ['module' => 'HR & Payroll', 'feature_key' => 'leave_management', 'feature_name' => 'Leave Management', 'icon' => 'calendar-off', 'sort_order' => 142],
            ['module' => 'HR & Payroll', 'feature_key' => 'payroll', 'feature_name' => 'Payroll Processing', 'icon' => 'dollar-sign', 'sort_order' => 143],

            // Asset Management
            ['module' => 'Asset Management', 'feature_key' => 'asset_register', 'feature_name' => 'Asset Register', 'icon' => 'server', 'sort_order' => 150],
            ['module' => 'Asset Management', 'feature_key' => 'asset_maintenance', 'feature_name' => 'Asset Maintenance', 'icon' => 'wrench', 'sort_order' => 151],
            ['module' => 'Asset Management', 'feature_key' => 'asset_depreciation', 'feature_name' => 'Asset Depreciation', 'icon' => 'trending-down', 'sort_order' => 152],

            // Dashboard & Reports
            ['module' => 'Dashboard & Reports', 'feature_key' => 'management_dashboard', 'feature_name' => 'Management Dashboard', 'icon' => 'layout', 'sort_order' => 160],
            ['module' => 'Dashboard & Reports', 'feature_key' => 'sales_dashboard', 'feature_name' => 'Sales Dashboard', 'icon' => 'trending-up', 'sort_order' => 161],
            ['module' => 'Dashboard & Reports', 'feature_key' => 'factory_dashboard', 'feature_name' => 'Factory Dashboard', 'icon' => 'cpu', 'sort_order' => 162],
            ['module' => 'Dashboard & Reports', 'feature_key' => 'custom_reports', 'feature_name' => 'Custom Reports', 'icon' => 'file-text', 'sort_order' => 163],

            // Notifications
            ['module' => 'Notifications', 'feature_key' => 'sms_notifications', 'feature_name' => 'SMS Notifications', 'icon' => 'message-circle', 'sort_order' => 170],
            ['module' => 'Notifications', 'feature_key' => 'email_notifications', 'feature_name' => 'Email Notifications', 'icon' => 'mail', 'sort_order' => 171],
            ['module' => 'Notifications', 'feature_key' => 'in_app_alerts', 'feature_name' => 'In-App Alerts', 'icon' => 'bell', 'sort_order' => 172],

            // Integrations
            ['module' => 'Integrations', 'feature_key' => 'barcode_qr', 'feature_name' => 'Barcode/QR Integration', 'icon' => 'maximize', 'sort_order' => 180],
            ['module' => 'Integrations', 'feature_key' => 'payment_gateway', 'feature_name' => 'Payment Gateway', 'icon' => 'credit-card', 'sort_order' => 181],
            ['module' => 'Integrations', 'feature_key' => 'api_access', 'feature_name' => 'API Access', 'icon' => 'code', 'sort_order' => 182],
            ['module' => 'Integrations', 'feature_key' => 'mobile_app', 'feature_name' => 'Mobile App', 'icon' => 'smartphone', 'sort_order' => 183],

            // Approval Workflow
            ['module' => 'Approval Workflow', 'feature_key' => 'approval_workflow', 'feature_name' => 'Approval Workflow Engine', 'icon' => 'check-circle', 'sort_order' => 190],
        ];

        foreach ($features as $feature) {
            Feature::updateOrCreate(
                ['feature_key' => $feature['feature_key']],
                array_merge($feature, ['is_active' => true])
            );
        }
    }
}
