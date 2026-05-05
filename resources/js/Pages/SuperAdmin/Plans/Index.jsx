import { Head, Link, router } from "@inertiajs/react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

export default function PlansIndex({ plans }) {
    const deletePlan = (plan) => {
        if (confirm(`Delete plan "${plan.name}"? This cannot be undone.`)) {
            router.delete(`/superadmin/plans/${plan.id}`);
        }
    };

    const planColors = ["blue", "orange", "purple", "green"];
    const gradients = [
        "from-blue-500 to-cyan-500",
        "from-orange-500 to-red-500",
        "from-purple-500 to-pink-500",
        "from-green-500 to-teal-500",
    ];

    return (
        <SuperAdminLayout title="Plans & Pricing">
            <Head title="Plans - SuperAdmin" />

            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <p className="text-gray-500 text-sm">
                    Manage subscription plans and feature access
                </p>
                <Link
                    href="/superadmin/plans/create"
                    className="flex items-center gap-2 bg-gradient-to-r from-orange-500 to-red-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-lg hover:shadow-orange-200 transition-all"
                >
                    <svg
                        className="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth={2}
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Create Plan
                </Link>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                {plans?.map((plan, i) => (
                    <div
                        key={plan.id}
                        className="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col"
                    >
                        {/* Header */}
                        <div
                            className={`bg-gradient-to-r ${gradients[i % gradients.length]} p-5 text-white`}
                        >
                            <div className="flex items-start justify-between">
                                <div>
                                    <h3 className="text-lg font-bold">
                                        {plan.name}
                                    </h3>
                                    {plan.is_popular && (
                                        <span className="bg-white/20 text-white text-xs px-2 py-0.5 rounded-full font-semibold">
                                            Most Popular
                                        </span>
                                    )}
                                </div>
                                <div className="text-right">
                                    <div className="text-2xl font-bold">
                                        ৳{plan.price_monthly?.toLocaleString()}
                                    </div>
                                    <div className="text-white/70 text-xs">
                                        /month
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Stats */}
                        <div className="px-5 py-4 border-b border-gray-50 grid grid-cols-3 gap-3 text-center">
                            <div>
                                <div className="text-lg font-bold text-gray-800">
                                    {plan.max_users ?? "∞"}
                                </div>
                                <div className="text-xs text-gray-400">
                                    Users
                                </div>
                            </div>
                            <div>
                                <div className="text-lg font-bold text-gray-800">
                                    {plan.max_branches ?? "∞"}
                                </div>
                                <div className="text-xs text-gray-400">
                                    Branches
                                </div>
                            </div>
                            <div>
                                <div className="text-lg font-bold text-gray-800">
                                    {plan.features_count ??
                                        plan.features?.length ??
                                        0}
                                </div>
                                <div className="text-xs text-gray-400">
                                    Features
                                </div>
                            </div>
                        </div>

                        {/* Companies using this plan */}
                        <div className="px-5 py-3 flex items-center justify-between bg-gray-50">
                            <span className="text-xs text-gray-500">
                                Companies using this plan
                            </span>
                            <span className="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                {plan.companies_count ?? 0}
                            </span>
                        </div>

                        {/* Actions */}
                        <div className="px-5 py-4 flex gap-2 mt-auto">
                            <Link
                                href={`/superadmin/plans/${plan.id}/edit`}
                                className="flex-1 text-center py-2 rounded-xl bg-orange-50 text-orange-600 text-sm font-semibold hover:bg-orange-100 transition-colors"
                            >
                                Edit
                            </Link>
                            <button
                                onClick={() => deletePlan(plan)}
                                className="flex-1 py-2 rounded-xl bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-100 transition-colors"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                ))}
            </div>

            {(!plans || plans.length === 0) && (
                <div className="bg-white rounded-2xl border border-gray-100 p-16 text-center text-gray-400">
                    <div className="text-5xl mb-3">📋</div>
                    <div className="font-semibold">No plans yet</div>
                    <p className="text-sm mt-1">
                        Create your first subscription plan to get started.
                    </p>
                </div>
            )}
        </SuperAdminLayout>
    );
}
