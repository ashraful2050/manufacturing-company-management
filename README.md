# Fan Company Management Software

A comprehensive **multi-tenant SaaS ERP** built specifically for fan manufacturing companies. It covers the entire business lifecycle — from raw material procurement and production to sales, warranty management, HR, and accounting — all within a single, role-controlled platform.

---

## Tech Stack

| Layer      | Technology               |
| ---------- | ------------------------ |
| Backend    | Laravel 11 (PHP)         |
| Frontend   | React (JSX) + Inertia.js |
| Styling    | Tailwind CSS             |
| Build Tool | Vite                     |
| Database   | MySQL (via XAMPP)        |

---

## Table of Contents

1. [Multi-Tenant SaaS Architecture](#1-multi-tenant-saas-architecture)
2. [SuperAdmin Panel](#2-superadmin-panel)
3. [Subscription Plans & Feature Gating](#3-subscription-plans--feature-gating)
4. [Authentication & Security](#4-authentication--security)
5. [Role-Based Access Control (RBAC)](#5-role-based-access-control-rbac)
6. [Company & Branch Management](#6-company--branch-management)
7. [Product & Category Management](#7-product--category-management)
8. [Bill of Materials (BOM)](#8-bill-of-materials-bom)
9. [Party Management — Suppliers, Customers & Dealers](#9-party-management--suppliers-customers--dealers)
10. [Warehouse & Inventory Management](#10-warehouse--inventory-management)
11. [Procurement Management](#11-procurement-management)
12. [Import & LC Management](#12-import--lc-management)
13. [Production Management](#13-production-management)
14. [Quality Control (QC) Inspections](#14-quality-control-qc-inspections)
15. [Sales Management](#15-sales-management)
16. [Delivery & Logistics](#16-delivery--logistics)
17. [Payment Management](#17-payment-management)
18. [Warranty & After-Sales Service](#18-warranty--after-sales-service)
19. [Human Resources (HR)](#19-human-resources-hr)
20. [Accounting & Finance](#20-accounting--finance)
21. [Approval Workflows](#21-approval-workflows)
22. [Notifications System](#22-notifications-system)
23. [Audit Logs & Login History](#23-audit-logs--login-history)
24. [Installation](#24-installation)

---

## 1. Multi-Tenant SaaS Architecture

The system is built on a **shared-database, tenant-isolated** architecture where each company (tenant) operates in complete data isolation.

- Every database record is scoped to a `company_id`, so tenants never see each other's data.
- A single deployment serves unlimited companies simultaneously.
- Each company has its own users, roles, branches, products, and transactions.
- Companies are provisioned instantly by the SuperAdmin and immediately get a dedicated admin user and default role.
- Trial period support — a `trial_ends_at` date controls free access windows before a paid subscription is required.

---

## 2. SuperAdmin Panel

A dedicated `/superadmin` area reserved for the platform owner to manage the entire SaaS operation.

### Company Management

- Create, view, edit, and delete tenant companies.
- Set the subscribed plan, owner, trade license, BIN, and TIN at creation time.
- Automatically creates: the company admin user account, a default `Administrator` role, and the first subscription record.
- Toggle company active/inactive status to suspend access without deleting data.

### Plan Management

- Full CRUD for subscription plans.
- Assign features to plans with per-feature enable/disable flags and optional numeric limits (e.g. max invoices/month).
- Plans have both monthly and yearly pricing, and a featured flag for marketing.

### Admin User Management

- View all company admin users across all tenants.
- Create new admin users and assign them to a company.
- Toggle user active/inactive status.
- Reset user passwords directly from the panel.

### SuperAdmin Dashboard

- Live platform statistics: total companies, active companies, total users, total revenue.
- Recent companies list with subscription status.
- Plan-wise subscription breakdown.

---

## 3. Subscription Plans & Feature Gating

Each company is on a subscription plan that controls what modules they can access.

- **Plans** have monthly and yearly pricing, max users limit, max branches limit, and a featured flag.
- **Features** are system modules (e.g. `purchase`, `sales`, `production`, `hr`) with a unique `feature_key`.
- **Plan–Feature mapping** (`plan_features`) links features to plans with `is_enabled` and an optional `limit_value`.
- When a company's subscription expires, access is restricted accordingly.
- Subscription history is retained in `company_subscriptions` (status: `active`, `expired`, `cancelled`, `trial`).

---

## 4. Authentication & Security

### User Types

- `superadmin` — Platform owner with full access to the SuperAdmin panel.
- `admin` — Company-level administrator provisioned when a company is created.
- `staff` — Regular company employees with RBAC-controlled access.

### Security Features

- **Two-Factor Authentication (2FA)** — per-user opt-in with a TOTP secret.
- **IP Whitelisting** — a JSON list of allowed IPs per user; access is block if the IP is not on the list.
- **Must-Change Password** — flag forces users to set a new password on next login.
- **Password Change Audit** — `password_changed_at` timestamp is recorded.
- **Last Login Tracking** — stores the timestamp and IP of the most recent successful login.
- **Login History** — full log of all login attempts (successful or failed) with IP address, user agent, and failure reason.

---

## 5. Role-Based Access Control (RBAC)

Fine-grained, module-level permission system scoped per company.

- Each company defines its own **Roles** (e.g. Sales Manager, Warehouse Keeper, Accountant).
- Roles are linked to system **Features** via `role_permissions`.
- Each permission record controls six granular capabilities:
    - `can_view` — read the module
    - `can_create` — add new records
    - `can_edit` — modify existing records
    - `can_delete` — remove records
    - `can_approve` — approve pending items (purchase orders, payments, etc.)
    - `can_export` — export data to Excel/PDF
- System roles (`is_system_role = true`) are protected from accidental deletion.
- Users are assigned exactly one role per company.

---

## 6. Company & Branch Management

### Company Profile

- Name, logo, address, city, country, phone, email, and website.
- Regulatory details: trade license number, BIN (Business Identification Number), and TIN (Tax Identification Number).
- Linked to a subscription plan and an owner user.

### Branch / Unit Management

Supports managing multiple physical locations under one company.

| Branch Type      | Description                    |
| ---------------- | ------------------------------ |
| `head_office`    | Main corporate office          |
| `factory`        | Manufacturing plant            |
| `warehouse`      | Storage/distribution hub       |
| `showroom`       | Retail display outlet          |
| `service_center` | After-sales repair center      |
| `dealer_point`   | Authorized dealership location |

Each branch stores its address, city, phone, email, and an assigned manager.

---

## 7. Product & Category Management

### Product Categories

- Hierarchical categories with `parent_id` support (multi-level tree).
- Unique slugs per company for URL-friendly references.

### Products

Full product master for all goods sold or manufactured by the company.

**Fan types supported:**
`ceiling_fan` · `wall_fan` · `table_fan` · `stand_fan` · `exhaust_fan` · `industrial_fan` · `smart_fan` · `spare_part` · `accessory`

**Product fields:**

- Unique product code, name, brand, model, and description.
- Product image and JSON-based specifications (wattage, RPM, blade span, colors, etc.).
- Unit of measurement (Pcs, Set, etc.).
- **Four pricing tiers:** MRP, Dealer Price, Wholesale Price, Project Price — plus Cost Price.
- Warranty duration in months.
- **Serial Number Tracking** (`is_serial_tracked`) — track individual units by serial number.
- **Batch Tracking** (`is_batch_tracked`) — group units into production batches.
- Active/inactive status.

---

## 8. Bill of Materials (BOM)

Defines the raw materials and components needed to manufacture each product.

- **Versioned BOMs** — each product can have multiple BOM versions (v1, v2, …) with one marked as current.
- **BOM Items** — each line specifies:
    - The material/component (linked to a product record).
    - Required quantity and unit.
    - **Waste percentage** — automatically inflates issued quantity to account for manufacturing loss.
    - **Alternate material** flag — marks a component as a drop-in replacement.
- BOM is consumed automatically during production work order material planning.

---

## 9. Party Management — Suppliers, Customers & Dealers

### Suppliers

- Supplier code, name, contact person, phone, email, address, and city.
- Regulatory fields: trade license and BIN.
- Bank name and account for payment transfers.
- Opening balance for carry-forward from legacy systems.

### Customers

| Customer Type   | Use Case                |
| --------------- | ----------------------- |
| `retail`        | Walk-in buyer           |
| `corporate`     | B2B institutional buyer |
| `project`       | One-off large project   |
| `institutional` | Government or NGO       |

- Credit limit and opening balance per customer.
- Optionally linked to a system user for self-service portal access.

### Dealers

Territory-based distribution network management.

- Dealer code, owner name, district, thana, and territory classification.
- Credit limit and security deposit tracking.
- Status lifecycle: `pending` → `active` → `suspended` → `inactive`.
- Optionally linked to a system user for dealer portal access.

---

## 10. Warehouse & Inventory Management

### Warehouses

Multiple warehouses per branch, each typed for its purpose:
`raw_material` · `finished_goods` · `spare_parts` · `transit` · `wip` (Work-in-Progress)

### Inventory Balances (`inventory` table)

- Real-time stock quantity per product per warehouse (optionally per batch).
- **Reserved quantity** — quantity committed to open sales orders.
- **Min stock level** and **reorder level** — triggers low-stock notifications.

### Inventory Transactions (`inventory_transactions`)

Every stock movement generates an immutable transaction record:

| Transaction Type               | Trigger                      |
| ------------------------------ | ---------------------------- |
| `receive`                      | GRN acceptance               |
| `issue`                        | Work order material issuance |
| `transfer_in` / `transfer_out` | Inter-warehouse transfer     |
| `adjustment`                   | Manual stock correction      |
| `return`                       | Customer/supplier return     |
| `damage`                       | Damaged goods write-off      |
| `scrap`                        | Production scrap disposal    |

Each transaction records batch number, serial number, reference document (GRN, sales order, work order), and the creating user.

---

## 11. Procurement Management

End-to-end purchase cycle with approval workflow integration.

### Purchase Requisitions (PR)

- Raised by any department against a branch.
- Requisition types: `general`, `raw_material`, `spare_parts`.
- Status flow: `draft` → `pending` → `approved` / `rejected` → `closed`.
- Approval tracked with approver and approval timestamp.

### Purchase Orders (PO)

- Generated from an approved PR (or independently).
- **Local and import** PO types with multi-currency support and exchange rate recording.
- Line items with unit price, tax rate, and line total.
- Received quantity tracked per line to identify outstanding deliveries.
- Status flow: `draft` → `pending` → `approved` → `partial` → `received` → `cancelled`.
- Terms and conditions field for contractual notes.

### Goods Receive Notes (GRN)

- Created against a PO when goods physically arrive at a warehouse.
- Per-line tracking of: ordered qty, received qty, accepted qty, and rejected qty.
- QC status per line: `pending` / `passed` / `failed`.
- Batch number and serial numbers captured at receiving.
- Overall GRN status: `draft` → `qc_pending` → `accepted` / `partially_accepted` / `rejected`.
- Accepting a GRN automatically updates inventory balances.

---

## 12. Import & LC Management

Full Letter of Credit lifecycle for international procurement.

- LC number, date, bank name, and linked supplier.
- LC value in foreign currency with exchange rate.
- Proforma Invoice (PI) number reference.
- Shipment details: mode (`air` / `sea` / `land`), shipment date, ETA, port of loading, port of discharge.
- Document references: container number, Bill of Lading (B/L) number.
- **Complete landed cost computation:**
    - Freight cost
    - Insurance
    - Customs duty
    - VAT on import
    - Clearing and forwarding charges
    - Transport / inland charges
    - Other miscellaneous charges
    - **Total landed cost** (auto-calculated sum)
- Status flow: `draft` → `open` → `shipped` → `arrived` → `cleared` → `received` → `closed`.

---

## 13. Production Management

### Work Orders (WO)

- Raised per product per branch with a target completion date.
- Linked to the current BOM version for automatic material planning.
- Tracks planned, produced, and rejected quantities.
- Shift and production line assignment for factory floor scheduling.
- Status flow: `draft` → `approved` → `in_progress` → `paused` → `completed` → `cancelled`.
- Timestamps for actual start and completion times.

### Work Order Materials

- BOM-exploded material requirements attached to each work order.
- Planned quantity (from BOM × production quantity + waste).
- Issued quantity (actual raw material pulled from warehouse).
- Actual quantity consumed — variance analysis between planned and actual.
- Material issuance automatically reduces raw material inventory.

---

## 14. Quality Control (QC) Inspections

Three-stage quality gate covering the full production flow:

| Inspection Type | When                                              |
| --------------- | ------------------------------------------------- |
| `incoming`      | On receipt of goods from supplier (linked to GRN) |
| `in_process`    | Mid-production check (linked to work order)       |
| `final`         | Before dispatch of finished fans                  |

Each inspection record captures:

- Unique inspection number and date.
- Sample size, passed quantity, and failed quantity.
- Overall result: `passed` / `failed` / `conditional`.
- Defect details (free text) for root cause tracking.
- Assigned inspector and remarks.

---

## 15. Sales Management

### Multi-Channel Sales Orders

Sales can be recorded across five channels:
`dealer` · `retail` · `corporate` · `ecommerce` · `project`

- Orders linked to either a customer or a dealer.
- Payment type: `cash` / `credit` / `advance`.
- Full pricing: subtotal, line discount, VAT amount, and net amount.
- Advance payment tracking per order.
- Status flow: `draft` → `pending` → `approved` → `partial` → `delivered` → `invoiced` → `cancelled`.

### Sales Invoices

- Four invoice types: `sales`, `vat`, `service`, `dealer`.
- Auto-linked to the originating sales order.
- Tracks paid amount, due amount, and payment status (`unpaid` / `partial` / `paid`).
- Line-level serial number field for warranty registration at point of sale.

---

## 16. Delivery & Logistics

### Delivery Challans

- Created against an invoice for physical dispatch.
- Transport details: vehicle number, driver name, driver phone, and transport type.
- Delivery address (may differ from customer's registered address).
- Status flow: `pending` → `dispatched` → `delivered` → `returned`.
- Timestamps for dispatch and delivery confirmation.

---

## 17. Payment Management

Handles both money received from customers/dealers and money paid to suppliers.

- Payment type: `receipt` (incoming) or `payment` (outgoing).
- Party type: `customer`, `dealer`, or `supplier`.
- Linked to a specific invoice for accurate due-balance updates.
- **Payment methods:** `cash` · `bank transfer` · `mobile banking` · `cheque`.
- Cheque details: cheque number and cheque date (for bounce/clearance tracking).
- Status flow: `draft` → `pending` → `approved` → `cleared` / `bounced`.

---

## 18. Warranty & After-Sales Service

### Warranty Registration

- Registered at point of sale (or by the customer later).
- Unique warranty number and optional QR code for field scanning.
- Linked to product, serial number, batch number, and the original invoice.
- `warranty_expires_at` calculated from the product's `warranty_months` setting.

### Service Tickets

Full complaint and repair lifecycle management.

- **Complaint types:** noise, no speed, no start, physical damage (free-form field for flexibility).
- Determines automatically whether the unit is under warranty (`is_warranty`).
- Assigned to a technician and routed to a specific service branch.
- **Cost tracking:**
    - Parts cost (linked to actual spare parts consumed).
    - Labor cost.
    - Total repair cost.
- **Resolution types:** `repaired` · `replaced` · `refunded` · `no_fault`.
- Status flow: `open` → `assigned` → `in_progress` → `waiting_parts` → `resolved` → `closed` / `cancelled`.
- **Customer feedback:** star rating (1–5) and text feedback collected on ticket closure.

### Service Ticket Parts

- Spare parts consumed per ticket are listed with quantity and unit price.
- `is_warranty_covered` flag separates chargeable from warranty-covered parts.
- Parts consumption deducts from spare-parts warehouse inventory.

---

## 19. Human Resources (HR)

### Departments & Designations

- Create unlimited departments (e.g. Production, Sales, Accounts, HR).
- Designations linked to departments (e.g. Production Manager, Sales Executive).

### Employee Records

- Unique employee ID, name, phone, email.
- Linked to a department, designation, and branch.
- Optionally linked to a system user account for portal login.
- **Compensation:** basic salary plus allowances (stored as flexible JSON — HRA, transport, lunch, etc.).
- Bank account details for salary disbursement.
- NID (National ID) and address for compliance.
- Status lifecycle: `active` → `on_leave` → `resigned` / `terminated`.
- Joining date for tenure and gratuity calculations.

---

## 20. Accounting & Finance

### Chart of Accounts (CoA)

- Hierarchical account tree with `parent_id` support.
- Five account types: `asset` · `liability` · `equity` · `income` · `expense`.
- Control accounts (`is_control`) that roll up child balances.
- Opening balance for migration from existing accounting books.

### Vouchers (Journal Entries)

Double-entry bookkeeping engine at the core of the accounting module.

| Voucher Type | Purpose                            |
| ------------ | ---------------------------------- |
| `payment`    | Money going out                    |
| `receipt`    | Money coming in                    |
| `journal`    | General ledger adjustments         |
| `contra`     | Cash ↔ Bank transfers              |
| `purchase`   | Auto-generated on GRN acceptance   |
| `sales`      | Auto-generated on invoice creation |

- Each voucher has debit and credit lines with account codes.
- System validates `total_debit = total_credit` (balanced entry).
- Status flow: `draft` → `pending` → `approved` / `rejected`.
- Reference link to originating transaction (GRN ID, invoice ID, etc.).

### Fixed Asset Management

- Asset code, name, and category (machinery, vehicle, office equipment, tools).
- Assigned to a branch.
- Purchase date and cost, current book value.
- **Depreciation:** configurable rate and method (`straight_line` by default).
- Next maintenance date scheduling.
- Status: `active` → `under_maintenance` → `disposed` / `sold`.

---

## 21. Approval Workflows

Configurable multi-level approval engine that sits across all major modules.

- **Modules with approval:** purchase requisitions, purchase orders, payments, sales orders, warranty replacements.
- Each workflow defines levels with:
    - Level number (1 = first approver, 2 = second, …).
    - Role required at that level.
    - Amount range (`min_amount` / `max_amount`) so small transactions skip senior approval.
- Approval requests track the current level, overall status, the final approver, and rejection reasons.
- Status flow: `pending` → `approved` / `rejected` / `cancelled`.

---

## 22. Notifications System

### In-App Notifications

Real-time alerts pushed to users' dashboards:

| Notification Type   | Trigger                                       |
| ------------------- | --------------------------------------------- |
| `low_stock`         | Product quantity falls below reorder level    |
| `due_reminder`      | Invoice payment is overdue                    |
| `complaint_pending` | Service ticket unassigned for too long        |
| `approval_pending`  | A document is waiting for the user's approval |

- Notifications are user-specific and marked as read/unread.
- Each notification carries a contextual deep-link (`link` field) for one-click navigation.

### Email & SMS Templates

- Reusable templates stored per company with a unique slug.
- Template types: `email` or `sms`.
- Variable placeholders (e.g. `{{customer_name}}`, `{{invoice_number}}`) listed per template.
- Active/inactive toggle to disable templates without deleting them.

---

## 23. Audit Logs & Login History

### Audit Logs

Immutable record of every significant action in the system.

- Captures: user ID, company ID, action (`created`, `updated`, `deleted`, `viewed`, `approved`, `rejected`).
- Table name and record ID for direct traceability.
- **Before and after values** (JSON) — see exactly what changed on any record.
- IP address, user agent, and the URL that triggered the action.
- Indexed by user, company, and table+record for fast querying.

### Login History

- Every login attempt (successful or failed) is recorded.
- Captures IP address and user agent.
- Failed logins store the failure reason for security analysis.

---

## 24. Installation

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL (XAMPP recommended on Windows)

### Steps

```bash
# 1. Clone the repository
git clone <repository-url>
cd fan-company-management-software

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# 5. Set database credentials in .env, then run migrations and seeders
php artisan migrate --seed

# 6. Build frontend assets
npm run dev

# 7. Serve the application
php artisan serve
```

After seeding, log in as **SuperAdmin** to create your first company and plan.

---

## License

This project is proprietary software for fan manufacturing business management.

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
