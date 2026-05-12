import { Head, Link, router } from "@inertiajs/react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

export default function CompaniesShow({ company }) {
    const sub = company.current_subscription;

    const toggleStatus = () => {
        if (
            confirm(
                `${company.is_active ? "Deactivate" : "Activate"} this company?`,
            )
        ) {
            router.patch(`/superadmin/companies/${company.id}/toggle-status`);
        }
    };

    const InfoRow = ({ label, value }) => (
        <div className="flex justify-between py-2.5 border-b border-gray-50 last:border-0">
            <span className="text-sm text-gray-500">{label}</span>
            <span className="text-sm font-semibold text-gray-800">
                {value || "—"}
            </span>
        </div>
    );

    return (
        <SuperAdminLayout title={company.name}>
            <Head title={`${company.name} - SuperAdmin`} />

            {/* Actions */}
            <div className="flex flex-wrap gap-3 mb-6">
                <Link
                    href={`/superadmin/companies/${company.id}/edit`}
                    className="flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition-colors"
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                    </svg>
                    Edit Company
                </Link>
                <button
                    onClick={toggleStatus}
                    className={`flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-colors ${company.is_active ? "bg-red-500 hovah:bg-red-600 text-white" : "bg-green-500 hover:bg-green-600 text-white"}`}
                >
                    {company.is_active ? "Deactivate" : "Activate"}
                </button>
                <Link
                    href="/superadmin/companies"
                    className="flex items-center gap-2 border-2 border-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors"
                >
                    ← Back to List
                </Link>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-5">
                {/* Left column: 2/3 width */}
                <div className="lg:col-span-2 space-y-5">
                    {/* Company Details */}
                    <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 className="text-base font-bold text-gray-800 mb-4">
                            Company Details
                        </h2>
                        <InfoRow label="Company Name" value={company.name} />
                        <InfoRow label="Email" value={company.email} />
                        <InfoRow label="Phone" value={company.phone} />
                        <InfoRow label="Address" value={company.address} />
                        <InfoRow
                            label="Registration No."
                            value={company.registration_number}
                        />
                        <InfoRow
                            label="Trade License"
                            value={company.trade_license}
                        />
                        <InfoRow label="TIN" value={company.tin_number} />
                        <InfoRow label="BIN" value={company.bin_number} />
                        <InfoRow label="Status">
                            <span
                                className={`px-2.5 py-1 rounded-full text-xs font-semibold ${company.is_active ? "bg-green-100 text-green-700" : "bg-red-100 text-red-600"}`}
                            >
                                {company.is_active ? "Active" : "Inactive"}
                            </span>
                        </InfoRow>
                        <InfoRow
                            label="Registered On"
                            value={new Date(
                                company.created_at,
                            ).toLocaleDateString("en-GB", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                            })}
                        />
                    </div>

                    {/* Subscription History */}
                    <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 className="text-base font-bold text-gray-800 mb-4">
                            Subscription History
                        </h2>
                        {company.subscriptions?.length > 0 ? (
                            <table className="w-full text-sm">
                                <thead>
                                    <tr className="border-b border-gray-100">
                                        <th className="text-left py-2 text-xs font-bold text-gray-400 uppercase">
                                            Plan
                                        </th>
                                        <th className="text-left py-2 text-xs font-bold text-gray-400 uppercase">
                                            Start
                                        </th>
                                        <th className="text-left py-2 text-xs font-bold text-gray-400 uppercase">
                                            End
                                        </th>
                                        <th className="text-left py-2 text-xs font-bold text-gray-400 uppercase">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-50">
                                    {company.subscriptions.map((s) => (
                                        <tr key={s.id}>
                                            <td className="py-2.5 font-medium text-gray-700">
                                                {s.plan?.name}
                                            </td>
                                            <td className="py-2.5 text-gray-500">
                                                {new Date(
                                                    s.starts_at,
                                                ).toLocaleDateString("en-GB")}
                                            </td>
                                            <td className="py-2.5 text-gray-500">
                                                {s.ends_at
                                                    ? new Date(
                                                          s.ends_at,
                                                      ).toLocaleDateString(
                                                          "en-GB",
                                                      )
                                                    : "Ongoing"}
                                            </td>
                                            <td className="py-2.5">
                                                <span
                                                    className={`px-2 py-0.5 rounded-full text-xs font-semibold ${s.status === "active" ? "bg-green-100 text-green-700" : s.status === "trial" ? "bg-yellow-100 text-yellow-700" : "bg-gray-100 text-gray-500"}`}
                                                >
                                                    {s.status}
                                                </span>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        ) : (
                            <p className="text-gray-400 text-sm">
                                No subscription records.
                            </p>
                        )}
                    </div>

                    {/* Admin Users */}
                    <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 className="text-base font-bold text-gray-800 mb-4">
                            Admin Users ({company.users?.length || 0})
                        </h2>
                        {company.users?.length > 0 ? (
                            <div className="space-y-3">
                                {company.users.map((u) => (
                                    <div
                                        key={u.id}
                                        className="flex items-center gap-3 p-3 rounded-xl bg-gray-50"
                                    >
                                        <div className="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white text-xs font-bold">
                                            {u.name.charAt(0)}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <div className="text-sm font-semibold text-gray-800">
                                                {u.name}
                                            </div>
                                            <div className="text-xs text-gray-400">
                                                {u.email}
                                            </div>
                                        </div>
                                        <span
                                            className={`px-2 py-0.5 rounded-full text-xs font-semibold ${u.is_active ? "bg-green-100 text-green-700" : "bg-red-100 text-red-600"}`}
                                        >
                                            {u.is_active
                                                ? "Active"
                                                : "Inactive"}
                                        </span>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="text-gray-400 text-sm">
                                No users found.
                            </p>
                        )}
                    </div>
                </div>

                {/* Right column: stats */}
                <div className="space-y-5">
                    <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 className="text-base font-bold text-gray-800 mb-4">
                            Current Plan
                        </h2>
                        {sub ? (
                            <>
                                <div className="text-2xl font-bold text-orange-500 mb-1">
                                    {sub.plan?.name}
                                </div>
                                <div className="text-sm text-gray-500 mb-4">
                                    ৳{sub.plan?.price_monthly?.toLocaleString()}
                                    /month
                                </div>
                                <div className="space-y-2 text-sm">
                                    <div className="flex justify-between">
                                        <span className="text-gray-500">
                                            Status
                                        </span>
                                        <span
                                            className={`px-2 py-0.5 rounded-full text-xs font-semibold capitalize ${sub.status === "active" ? "bg-green-100 text-green-700" : "bg-yellow-100 text-yellow-700"}`}
                                        >
                                            {sub.status}
                                        </span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-gray-500">
                                            Expires
                                        </span>
                                        <span className="font-medium text-gray-700">
                                            {sub.ends_at
                                                ? new Date(
                                                      sub.ends_at,
                                                  ).toLocaleDateString("en-GB")
                                                : "Ongoing"}
                                        </span>
                                    </div>
                                    {sub.trial_ends_at && (
                                        <div className="flex justify-between">
                                            <span className="text-gray-500">
                                                Trial Ends
                                            </span>
                                            <span className="font-medium text-yellow-600">
                                                {new Date(
                                                    sub.trial_ends_at,
                                                ).toLocaleDateString("en-GB")}
                                            </span>
                                        </div>
                                    )}
                                </div>
                            </>
                        ) : (
                            <p className="text-gray-400 text-sm">
                                No active subscription.
                            </p>
                        )}
                    </div>

                    {/* Quick Stats */}
                    {[
                        {
                            label: "Total Users",
                            value: company.users_count || 0,
                            icon: "👥",
                            color: "blue",
                        },
                        {
                            label: "Branches",
                            value: company.branches_count || 0,
                            icon: "🏪",
                            color: "green",
                        },
                    ].map((s) => (
                        <div
                            key={s.label}
                            className="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4"
                        >
                            <span className="text-2xl">{s.icon}</span>
                            <div>
                                <div className="text-2xl font-bold text-gray-800">
                                    {s.value}
                                </div>
                                <div className="text-sm text-gray-500">
                                    {s.label}
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </SuperAdminLayout>
    );
}
