import { Link, usePage } from "@inertiajs/react";
import { useState } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Dropdown";

const menuGroups = [
    {
        label: "Dashboard",
        icon: "📊",
        href: "/dashboard",
        routeName: "dashboard",
    },
    {
        label: "Masters",
        icon: "⚙️",
        children: [
            { label: "Units", href: "/masters/units" },
            { label: "Currencies", href: "/masters/currencies" },
            { label: "Tax / VAT Rates", href: "/masters/tax-rates" },
            { label: "Brands", href: "/masters/brands" },
            { label: "Machines", href: "/masters/machines" },
            { label: "Transporters", href: "/masters/transporters" },
            { label: "Shifts", href: "/masters/shifts" },
            { label: "Production Lines", href: "/masters/production-lines" },
            { label: "Production Routes", href: "/masters/production-routes" },
        ],
    },
    {
        label: "CRM & Sales",
        icon: "🤝",
        children: [
            { label: "Leads", href: "/crm/leads" },
            { label: "Opportunities", href: "/crm/opportunities" },
            { label: "Inquiries", href: "/crm/inquiries" },
            { label: "Quotations", href: "/crm/quotations" },
            { label: "Sales Contracts", href: "/crm/sales-contracts" },
            { label: "Price Lists", href: "/crm/price-lists" },
            { label: "Territories", href: "/crm/territories" },
            { label: "Sales Targets", href: "/crm/sales-targets" },
            { label: "Commissions", href: "/crm/commissions" },
        ],
    },
    {
        label: "Procurement",
        icon: "🛒",
        children: [
            { label: "Purchase Requisitions", href: "/procurement/rfq" },
            { label: "RFQ", href: "/procurement/rfq" },
            {
                label: "Supplier Quotations",
                href: "/procurement/supplier-quotations",
            },
            { label: "Purchase Orders", href: "/procurement/blanket-orders" },
            { label: "Blanket PO", href: "/procurement/blanket-orders" },
            { label: "Rate Contracts", href: "/procurement/rate-contracts" },
            {
                label: "Goods Receipt (GRN)",
                href: "/procurement/service-receipts",
            },
            {
                label: "Purchase Returns",
                href: "/procurement/purchase-returns",
            },
            {
                label: "Debit/Credit Notes",
                href: "/procurement/debit-credit-notes",
            },
            {
                label: "Vendor Evaluation",
                href: "/procurement/vendor-evaluations",
            },
        ],
    },
    {
        label: "Inventory",
        icon: "📦",
        children: [
            { label: "Bin Locations", href: "/inventory/bin-locations" },
            { label: "Serial Numbers", href: "/inventory/serial-numbers" },
            {
                label: "Store Requisitions",
                href: "/inventory/store-requisitions",
            },
            { label: "Material Issues", href: "/inventory/material-issues" },
            { label: "Material Returns", href: "/inventory/material-returns" },
            { label: "Stock Count", href: "/inventory/stock-count" },
            { label: "Sales Returns", href: "/inventory/sales-returns" },
        ],
    },
    {
        label: "Production",
        icon: "🏭",
        children: [
            { label: "🧮 Fan Costing", href: "/production/fan-costing" },
            { label: "Demand Forecast", href: "/production/demand-forecasts" },
            { label: "Master Prod. Schedule", href: "/production/mps" },
            { label: "Material Req. Planning", href: "/production/mrp" },
            { label: "Capacity Planning", href: "/production/capacity-plans" },
            { label: "Work Orders", href: "/production/job-cards" },
            { label: "Job Cards", href: "/production/job-cards" },
            { label: "Daily Production", href: "/production/daily-entries" },
            { label: "Production Output", href: "/production/outputs" },
            { label: "Production Closing", href: "/production/closings" },
            { label: "Shift Roster", href: "/production/shift-roster" },
        ],
    },
    {
        label: "Shop Floor",
        icon: "🔧",
        children: [
            { label: "Dashboard", href: "/shop-floor" },
            { label: "Floor Entries", href: "/shop-floor/entries" },
            { label: "Machine Downtime", href: "/shop-floor/downtime" },
            { label: "OEE Tracking", href: "/shop-floor/oee" },
        ],
    },
    {
        label: "Quality Control",
        icon: "✅",
        children: [
            { label: "QC Parameters", href: "/quality/parameters" },
            { label: "Inspections", href: "/quality/parameters" },
            { label: "Non-Conformance (NCR)", href: "/quality/ncr" },
            { label: "CAPA", href: "/quality/capa" },
        ],
    },
    {
        label: "Maintenance",
        icon: "🔩",
        children: [
            { label: "PM Schedules", href: "/maintenance/schedules" },
            { label: "Work Orders", href: "/maintenance/work-orders" },
            { label: "Calibration", href: "/maintenance/calibration" },
        ],
    },
    {
        label: "HR & Payroll",
        icon: "👥",
        children: [
            { label: "Attendance", href: "/hr/attendance" },
            { label: "Leave Management", href: "/hr/leave" },
            { label: "Payroll", href: "/hr/payroll" },
            { label: "Loans & Advances", href: "/hr/loans" },
            { label: "Recruitment", href: "/hr/recruitment" },
            { label: "Performance Review", href: "/hr/evaluations" },
            { label: "Training", href: "/hr/training" },
        ],
    },
    {
        label: "Accounts & Finance",
        icon: "💰",
        children: [
            { label: "Cost Centers", href: "/finance/cost-centers" },
            { label: "Budgets", href: "/finance/budgets" },
            { label: "Bank Accounts", href: "/finance/bank-accounts" },
            {
                label: "Bank Reconciliation",
                href: "/finance/bank-reconciliation",
            },
            { label: "Cost Sheets", href: "/finance/cost-sheets" },
        ],
    },
    {
        label: "Logistics",
        icon: "🚛",
        children: [
            { label: "Dispatch Plans", href: "/logistics/dispatch-plans" },
            { label: "Gate Passes", href: "/logistics/gate-passes" },
        ],
    },
    {
        label: "Documents",
        icon: "📁",
        children: [{ label: "All Documents", href: "/documents/files" }],
    },
    {
        label: "Compliance",
        icon: "🛡️",
        children: [
            { label: "Compliance Records", href: "/compliance/records" },
            { label: "Licenses & Certs", href: "/compliance/licenses" },
        ],
    },
    {
        label: "Reports",
        icon: "📈",
        children: [
            { label: "Production Report", href: "/reports/production" },
            { label: "Sales Report", href: "/reports/sales" },
            { label: "Purchase Report", href: "/reports/purchase" },
            { label: "Inventory Report", href: "/reports/inventory" },
            { label: "Finance Report", href: "/reports/finance" },
            { label: "HR Report", href: "/reports/hr" },
            {
                label: "Machine Performance",
                href: "/reports/machine-performance",
            },
            { label: "Rejection & Scrap", href: "/reports/rejection-scrap" },
            { label: "Daily MIS", href: "/reports/mis-daily" },
            { label: "Monthly MIS", href: "/reports/mis-monthly" },
        ],
    },
];

function SidebarItem({ item }) {
    const [open, setOpen] = useState(false);

    if (item.children) {
        return (
            <div>
                <button
                    onClick={() => setOpen(!open)}
                    className="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md"
                >
                    <span>
                        {item.icon} {item.label}
                    </span>
                    <svg
                        className={`w-4 h-4 transition-transform ${open ? "rotate-180" : ""}`}
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fillRule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clipRule="evenodd"
                        />
                    </svg>
                </button>
                {open && (
                    <div className="ml-4 border-l border-gray-200">
                        {item.children.map((child, idx) => (
                            <a
                                key={idx}
                                href={child.href}
                                className="block px-4 py-1.5 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md"
                            >
                                {child.label}
                            </a>
                        ))}
                    </div>
                )}
            </div>
        );
    }

    return (
        <a
            href={item.href}
            className="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md"
        >
            {item.icon} <span className="ml-1">{item.label}</span>
        </a>
    );
}

export default function ManufacturingLayout({ header, children }) {
    const user = usePage().props.auth.user;
    const [sidebarOpen, setSidebarOpen] = useState(false);

    return (
        <div className="min-h-screen bg-gray-50 flex">
            {/* Sidebar */}
            <aside
                className={`fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-200 ease-in-out ${sidebarOpen ? "translate-x-0" : "-translate-x-full"} lg:translate-x-0 lg:static lg:inset-0`}
            >
                <div className="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                    <Link href="/" className="flex items-center">
                        <span className="text-lg font-bold text-gray-800">
                            MfgERP
                        </span>
                    </Link>
                    <button
                        onClick={() => setSidebarOpen(false)}
                        className="lg:hidden text-gray-500 hover:text-gray-700"
                    >
                        <svg
                            className="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <nav className="px-2 py-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
                    {menuGroups.map((item, idx) => (
                        <SidebarItem key={idx} item={item} />
                    ))}
                </nav>
            </aside>

            {/* Main content */}
            <div className="flex-1 flex flex-col min-w-0">
                {/* Top nav */}
                <header className="sticky top-0 z-40 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6">
                    <button
                        onClick={() => setSidebarOpen(true)}
                        className="lg:hidden text-gray-500 hover:text-gray-700"
                    >
                        <svg
                            className="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>
                    {header && (
                        <div className="text-lg font-semibold text-gray-800">
                            {header}
                        </div>
                    )}
                    <Dropdown>
                        <Dropdown.Trigger>
                            <button className="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                <span className="mr-1">{user?.name}</span>
                                <svg
                                    className="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clipRule="evenodd"
                                    />
                                </svg>
                            </button>
                        </Dropdown.Trigger>
                        <Dropdown.Content>
                            <Dropdown.Link href={route("profile.edit")}>
                                Profile
                            </Dropdown.Link>
                            <Dropdown.Link
                                href={route("logout")}
                                method="post"
                                as="button"
                            >
                                Log Out
                            </Dropdown.Link>
                        </Dropdown.Content>
                    </Dropdown>
                </header>

                <main className="flex-1 p-6">{children}</main>
            </div>
        </div>
    );
}
