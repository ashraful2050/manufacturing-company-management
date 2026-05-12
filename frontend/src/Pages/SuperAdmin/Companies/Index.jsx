import { Head, Link, useForm, router } from "@inertiajs/react";
import { useState } from "react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

export default function CompaniesIndex({ companies, plans, filters }) {
    const [search, setSearch] = useState(filters?.search || "");
    const [status, setStatus] = useState(filters?.status || "");

    const handleFilter = (e) => {
        e.preventDefault();
        router.get(
            "/superadmin/companies",
            { search, status },
            { preserveState: true },
        );
    };

    const toggleStatus = (company) => {
        if (
            confirm(
                `${company.is_active ? "Deactivate" : "Activate"} "${company.name}"?`,
            )
        ) {
            router.patch(`/superadmin/companies/${company.id}/toggle-status`);
        }
    };

    return (
        <SuperAdminLayout title="Companies">
            <Head title="Companies - SuperAdmin" />

            {/* Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <p className="text-gray-500 text-sm">
                        Manage all registered companies and their subscriptions
                    </p>
                </div>
                <Link
                    href="/superadmin/companies/create"
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
                    Add Company
                </Link>
            </div>

            {/* Filters */}
            <form
                onSubmit={handleFilter}
                className="bg-white rounded-2xl border border-gray-100 p-4 mb-5 flex flex-col sm:flex-row gap-3"
            >
                <input
                    type="text"
                    placeholder="Search by name or email..."
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    className="flex-1 px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors"
                />
                <select
                    value={status}
                    onChange={(e) => setStatus(e.target.value)}
                    className="px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors"
                >
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <button
                    type="submit"
                    className="px-5 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors"
                >
                    Filter
                </button>
            </form>

            {/* Table */}
            <div className="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full">
                        <thead>
                            <tr className="border-b border-gray-100 bg-gray-50">
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    Company
                                </th>
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    Plan
                                </th>
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    Users
                                </th>
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    Status
                                </th>
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    Created
                                </th>
                                <th className="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-50">
                            {companies?.data?.length > 0 ? (
                                companies.data.map((company) => (
                                    <tr
                                        key={company.id}
                                        className="hover:bg-gray-50 transition-colors"
                                    >
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                    {company.name.charAt(0)}
                                                </div>
                                                <div>
                                                    <div className="text-gray-900 font-semibold text-sm">
                                                        {company.name}
                                                    </div>
                                                    <div className="text-gray-400 text-xs">
                                                        {company.email}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                                                {company.plan?.name ||
                                                    "No Plan"}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-gray-600 text-sm">
                                            {company.users_count || 0}
                                        </td>
                                        <td className="px-6 py-4">
                                            <span
                                                className={`px-2.5 py-1 rounded-full text-xs font-semibold ${company.is_active ? "bg-green-100 text-green-700" : "bg-red-100 text-red-600"}`}
                                            >
                                                {company.is_active
                                                    ? "Active"
                                                    : "Inactive"}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-gray-500 text-xs">
                                            {new Date(
                                                company.created_at,
                                            ).toLocaleDateString("en-GB")}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex items-center justify-end gap-2">
                                                <Link
                                                    href={`/superadmin/companies/${company.id}`}
                                                    className="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50 transition-colors"
                                                    title="View"
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
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                        />
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            strokeWidth={2}
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                        />
                                                    </svg>
                                                </Link>
                                                <Link
                                                    href={`/superadmin/companies/${company.id}/edit`}
                                                    className="p-1.5 rounded-lg text-orange-500 hover:bg-orange-50 transition-colors"
                                                    title="Edit"
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
                                                </Link>
                                                <button
                                                    onClick={() =>
                                                        toggleStatus(company)
                                                    }
                                                    className={`p-1.5 rounded-lg transition-colors ${company.is_active ? "text-red-500 hover:bg-red-50" : "text-green-500 hover:bg-green-50"}`}
                                                    title={
                                                        company.is_active
                                                            ? "Deactivate"
                                                            : "Activate"
                                                    }
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
                                                            d={
                                                                company.is_active
                                                                    ? "M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                                                                    : "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                            }
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td
                                        colSpan={6}
                                        className="px-6 py-16 text-center text-gray-400"
                                    >
                                        <div className="text-4xl mb-2">🏢</div>
                                        <div className="font-semibold">
                                            No companies found
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                {/* Pagination */}
                {companies?.links && companies.links.length > 3 && (
                    <div className="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <span className="text-sm text-gray-500">
                            Showing {companies.from}–{companies.to} of{" "}
                            {companies.total}
                        </span>
                        <div className="flex gap-1">
                            {companies.links.map((link, i) => (
                                <Link
                                    key={i}
                                    href={link.url || "#"}
                                    className={`px-3 py-1.5 rounded-lg text-sm transition-colors ${
                                        link.active
                                            ? "bg-orange-500 text-white"
                                            : "text-gray-600 hover:bg-gray-100"
                                    } ${!link.url ? "opacity-40 cursor-not-allowed" : ""}`}
                                    dangerouslySetInnerHTML={{
                                        __html: link.label,
                                    }}
                                />
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </SuperAdminLayout>
    );
}
