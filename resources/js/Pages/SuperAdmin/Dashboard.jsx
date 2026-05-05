import { Head, Link } from "@inertiajs/react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

function StatCard({ icon, label, value, sub, color }) {
    return (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
            <div
                className={`w-14 h-14 rounded-2xl bg-gradient-to-br ${color} flex items-center justify-center text-2xl`}
            >
                {icon}
            </div>
            <div>
                <div className="text-3xl font-black text-gray-900">{value}</div>
                <div className="text-gray-600 text-sm font-medium">{label}</div>
                {sub && (
                    <div className="text-gray-400 text-xs mt-0.5">{sub}</div>
                )}
            </div>
        </div>
    );
}

export default function SuperAdminDashboard({
    stats,
    recentCompanies,
    planStats,
}) {
    return (
        <SuperAdminLayout title="Dashboard">
            <Head title="SuperAdmin Dashboard" />

            {/* Stats */}
            <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">
                <StatCard
                    icon="🏢"
                    label="Total Companies"
                    value={stats.total_companies}
                    sub={`${stats.active_companies} active`}
                    color="from-blue-400 to-blue-500"
                />
                <StatCard
                    icon="👥"
                    label="Total Users"
                    value={stats.total_users}
                    color="from-purple-400 to-purple-500"
                />
                <StatCard
                    icon="💳"
                    label="Active Plans"
                    value={stats.total_plans}
                    color="from-green-400 to-green-500"
                />
                <StatCard
                    icon="📈"
                    label="New Companies"
                    value={stats.new_companies_this_month}
                    sub="This month"
                    color="from-orange-400 to-orange-500"
                />
                <StatCard
                    icon="💰"
                    label="Monthly Revenue"
                    value={`৳${Number(stats.revenue_monthly).toLocaleString()}`}
                    color="from-red-400 to-red-500"
                />
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {/* Recent Companies */}
                <div className="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div className="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h2 className="text-lg font-black text-gray-900">
                            Recent Companies
                        </h2>
                        <Link
                            href="/superadmin/companies"
                            className="text-orange-500 text-sm font-semibold hover:text-orange-600"
                        >
                            View All →
                        </Link>
                    </div>
                    <div className="divide-y divide-gray-50">
                        {recentCompanies?.length > 0 ? (
                            recentCompanies.map((company) => (
                                <div
                                    key={company.id}
                                    className="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors"
                                >
                                    <div className="flex items-center gap-3">
                                        <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                                            {company.name
                                                .charAt(0)
                                                .toUpperCase()}
                                        </div>
                                        <div>
                                            <div className="text-gray-900 font-semibold text-sm">
                                                {company.name}
                                            </div>
                                            <div className="text-gray-400 text-xs">
                                                {company.email} •{" "}
                                                {company.plan?.name}
                                            </div>
                                        </div>
                                    </div>
                                    <span
                                        className={`px-2.5 py-1 rounded-full text-xs font-semibold ${company.is_active ? "bg-green-100 text-green-700" : "bg-red-100 text-red-600"}`}
                                    >
                                        {company.is_active
                                            ? "Active"
                                            : "Inactive"}
                                    </span>
                                </div>
                            ))
                        ) : (
                            <div className="px-6 py-12 text-center text-gray-400">
                                No companies yet
                            </div>
                        )}
                    </div>
                </div>

                {/* Plan Distribution */}
                <div className="bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div className="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h2 className="text-lg font-black text-gray-900">
                            Plan Distribution
                        </h2>
                        <Link
                            href="/superadmin/plans"
                            className="text-orange-500 text-sm font-semibold hover:text-orange-600"
                        >
                            Manage →
                        </Link>
                    </div>
                    <div className="p-6 space-y-4">
                        {planStats?.length > 0 ? (
                            planStats.map((plan) => (
                                <div key={plan.name}>
                                    <div className="flex items-center justify-between mb-1.5">
                                        <span className="text-gray-700 text-sm font-medium">
                                            {plan.name}
                                        </span>
                                        <span className="text-gray-500 text-sm">
                                            {plan.count} companies
                                        </span>
                                    </div>
                                    <div className="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div
                                            className="h-full bg-gradient-to-r from-orange-500 to-red-500 rounded-full transition-all"
                                            style={{
                                                width: `${Math.max(5, (plan.count / Math.max(1, stats.total_companies)) * 100)}%`,
                                            }}
                                        />
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div className="text-center text-gray-400 py-8">
                                No plan data
                            </div>
                        )}
                    </div>

                    {/* Quick actions */}
                    <div className="p-6 pt-0 space-y-2">
                        <Link
                            href="/superadmin/companies/create"
                            className="flex items-center gap-2 w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-2.5 px-4 rounded-xl text-sm font-semibold hover:shadow-lg transition-all text-center justify-center"
                        >
                            + New Company
                        </Link>
                        <Link
                            href="/superadmin/plans/create"
                            className="flex items-center gap-2 w-full border-2 border-gray-200 text-gray-700 py-2.5 px-4 rounded-xl text-sm font-semibold hover:border-orange-300 transition-all text-center justify-center"
                        >
                            + New Plan
                        </Link>
                    </div>
                </div>
            </div>
        </SuperAdminLayout>
    );
}
