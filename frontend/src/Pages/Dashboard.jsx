import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import { Head, Link } from "@inertiajs/react";
import { usePage } from "@inertiajs/react";

const quickLinks = [
    {
        icon: "🧮",
        label: "Fan Costing",
        href: "/production/fan-costing",
        color: "bg-blue-50 border-blue-200 hover:bg-blue-100",
    },
    {
        icon: "🏭",
        label: "Production",
        href: "/production/job-cards",
        color: "bg-indigo-50 border-indigo-200 hover:bg-indigo-100",
    },
    {
        icon: "🛒",
        label: "Procurement",
        href: "/procurement/rfq",
        color: "bg-orange-50 border-orange-200 hover:bg-orange-100",
    },
    {
        icon: "📦",
        label: "Inventory",
        href: "/inventory/stock-count",
        color: "bg-teal-50 border-teal-200 hover:bg-teal-100",
    },
    {
        icon: "🤝",
        label: "CRM & Sales",
        href: "/crm/leads",
        color: "bg-green-50 border-green-200 hover:bg-green-100",
    },
    {
        icon: "💰",
        label: "Accounts & Finance",
        href: "/finance/cost-sheets",
        color: "bg-yellow-50 border-yellow-200 hover:bg-yellow-100",
    },
    {
        icon: "👥",
        label: "HR & Payroll",
        href: "/hr/attendance",
        color: "bg-pink-50 border-pink-200 hover:bg-pink-100",
    },
    {
        icon: "📈",
        label: "Reports",
        href: "/reports",
        color: "bg-purple-50 border-purple-200 hover:bg-purple-100",
    },
];

export default function Dashboard() {
    const { auth } = usePage().props;

    return (
        <ManufacturingLayout header="Dashboard">
            <Head title="Dashboard" />

            <div className="space-y-6">
                {/* Welcome */}
                <div className="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-md">
                    <h1 className="text-2xl font-bold mb-1">
                        Welcome back, {auth?.user?.name ?? "User"} 👋
                    </h1>
                    <p className="text-blue-100 text-sm">
                        Fan Company Management Software — ERP Dashboard
                    </p>
                </div>

                {/* Quick Links */}
                <div>
                    <h2 className="text-base font-bold text-gray-700 mb-3">
                        Quick Access
                    </h2>
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        {quickLinks.map((item) => (
                            <Link
                                key={item.href}
                                href={item.href}
                                className={`flex items-center gap-3 p-4 rounded-xl border transition-colors ${item.color}`}
                            >
                                <span className="text-2xl">{item.icon}</span>
                                <span className="text-sm font-semibold text-gray-700">
                                    {item.label}
                                </span>
                            </Link>
                        ))}
                    </div>
                </div>

                {/* Fan Costing highlight */}
                <div className="bg-white rounded-xl border border-blue-200 shadow-sm p-5 flex items-center justify-between">
                    <div>
                        <p className="text-xs text-blue-600 font-semibold uppercase tracking-wide mb-1">
                            New Module
                        </p>
                        <h3 className="text-lg font-bold text-gray-800">
                            🧮 Fan Product Costing
                        </h3>
                        <p className="text-sm text-gray-500 mt-1">
                            Enter prices for all 37 cost items and instantly
                            calculate unit cost, gross profit & margin.
                        </p>
                    </div>
                    <Link
                        href="/production/fan-costing/create"
                        className="shrink-0 ml-4 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors"
                    >
                        New Entry →
                    </Link>
                </div>
            </div>
        </ManufacturingLayout>
    );
}
