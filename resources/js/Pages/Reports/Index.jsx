import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import { Head, Link } from "@inertiajs/react";

const reportCards = [
    {
        category: "Production Reports",
        color: "border-blue-500",
        headerBg: "bg-blue-500",
        reports: [
            { label: "Production Summary", href: "/reports/production" },
            {
                label: "Machine Performance",
                href: "/reports/machine-performance",
            },
            { label: "Rejection & Scrap", href: "/reports/rejection-scrap" },
            { label: "Job Card Summary", href: "/reports/production" },
            { label: "OEE Report", href: "/reports/machine-performance" },
        ],
    },
    {
        category: "Sales Reports",
        color: "border-green-500",
        headerBg: "bg-green-500",
        reports: [
            { label: "Sales Summary", href: "/reports/sales" },
            { label: "Customer-wise Sales", href: "/reports/sales" },
            { label: "Product-wise Sales", href: "/reports/sales" },
            { label: "Outstanding Orders", href: "/reports/sales" },
        ],
    },
    {
        category: "Purchase Reports",
        color: "border-yellow-500",
        headerBg: "bg-yellow-500",
        reports: [
            { label: "Purchase Summary", href: "/reports/purchase" },
            { label: "Supplier-wise Purchase", href: "/reports/purchase" },
            { label: "Pending POs", href: "/reports/purchase" },
        ],
    },
    {
        category: "Inventory Reports",
        color: "border-orange-500",
        headerBg: "bg-orange-500",
        reports: [
            { label: "Stock Summary", href: "/reports/inventory" },
            { label: "Stock Ageing", href: "/reports/inventory" },
            { label: "Material Movement", href: "/reports/inventory" },
            { label: "Slow-Moving Items", href: "/reports/inventory" },
        ],
    },
    {
        category: "Finance Reports",
        color: "border-purple-500",
        headerBg: "bg-purple-500",
        reports: [
            { label: "P&L Statement", href: "/reports/finance" },
            { label: "Balance Sheet", href: "/reports/finance" },
            { label: "Cost Sheet", href: "/reports/finance" },
            { label: "Budget vs Actual", href: "/reports/finance" },
        ],
    },
    {
        category: "HR Reports",
        color: "border-teal-500",
        headerBg: "bg-teal-500",
        reports: [
            { label: "Attendance Report", href: "/reports/hr" },
            { label: "Leave Report", href: "/reports/hr" },
            { label: "Payroll Summary", href: "/reports/hr" },
        ],
    },
    {
        category: "MIS Reports",
        color: "border-red-500",
        headerBg: "bg-red-500",
        reports: [
            { label: "Daily MIS", href: "/reports/mis-daily" },
            { label: "Monthly MIS", href: "/reports/mis-monthly" },
        ],
    },
];

export default function Index() {
    return (
        <ManufacturingLayout header="Reports & Dashboards">
            <Head title="Reports" />
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {reportCards.map((cat) => (
                    <div
                        key={cat.category}
                        className={`border-t-4 ${cat.color} bg-white rounded-xl shadow-sm overflow-hidden`}
                    >
                        <div className={`${cat.headerBg} px-4 py-3`}>
                            <h3 className="text-white font-semibold text-sm">
                                {cat.category}
                            </h3>
                        </div>
                        <ul className="divide-y divide-gray-100">
                            {cat.reports.map((rep) => (
                                <li key={rep.label}>
                                    <Link
                                        href={rep.href}
                                        className="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition"
                                    >
                                        <span className="text-gray-400">›</span>
                                        {rep.label}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                ))}
            </div>
        </ManufacturingLayout>
    );
}
