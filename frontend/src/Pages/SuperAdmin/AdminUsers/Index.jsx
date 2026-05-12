import { Head, Link, useForm, router } from "@inertiajs/react";
import { useState } from "react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

export default function AdminUsersIndex({ users, companies, filters }) {
    const [search, setSearch] = useState(filters?.search || "");
    const [companyId, setCompanyId] = useState(filters?.company_id || "");
    const [showCreateModal, setShowCreateModal] = useState(false);
    const [resetTarget, setResetTarget] = useState(null);

    const handleFilter = (e) => {
        e.preventDefault();
        router.get(
            "/superadmin/admin-users",
            { search, company_id: companyId },
            { preserveState: true },
        );
    };

    const toggleStatus = (user) => {
        if (
            confirm(
                `${user.is_active ? "Deactivate" : "Activate"} user "${user.name}"?`,
            )
        ) {
            router.patch(`/superadmin/admin-users/${user.id}/toggle-status`);
        }
    };

    return (
        <SuperAdminLayout title="Admin Users">
            <Head title="Admin Users - SuperAdmin" />

            {/* Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <p className="text-gray-500 text-sm">
                    All company admin accounts
                </p>
                <button
                    onClick={() => setShowCreateModal(true)}
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
                    Add Admin User
                </button>
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
                    value={companyId}
                    onChange={(e) => setCompanyId(e.target.value)}
                    className="px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors"
                >
                    <option value="">All Companies</option>
                    {companies?.map((c) => (
                        <option key={c.id} value={c.id}>
                            {c.name}
                        </option>
                    ))}
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
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">
                                    User
                                </th>
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">
                                    Company
                                </th>
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">
                                    Status
                                </th>
                                <th className="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">
                                    Last Login
                                </th>
                                <th className="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-50">
                            {users?.data?.length > 0 ? (
                                users.data.map((user) => (
                                    <tr
                                        key={user.id}
                                        className="hover:bg-gray-50 transition-colors"
                                    >
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-9 h-9 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                    {user.name.charAt(0)}
                                                </div>
                                                <div>
                                                    <div className="text-gray-900 font-semibold text-sm">
                                                        {user.name}
                                                    </div>
                                                    <div className="text-gray-400 text-xs">
                                                        {user.email}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className="text-sm text-gray-600">
                                                {user.company?.name || "—"}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span
                                                className={`px-2.5 py-1 rounded-full text-xs font-semibold ${user.is_active ? "bg-green-100 text-green-700" : "bg-red-100 text-red-600"}`}
                                            >
                                                {user.is_active
                                                    ? "Active"
                                                    : "Inactive"}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-gray-500 text-xs">
                                            {user.last_login_at
                                                ? new Date(
                                                      user.last_login_at,
                                                  ).toLocaleString("en-GB", {
                                                      day: "2-digit",
                                                      month: "short",
                                                      year: "numeric",
                                                      hour: "2-digit",
                                                      minute: "2-digit",
                                                  })
                                                : "Never"}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex items-center justify-end gap-2">
                                                <button
                                                    onClick={() =>
                                                        toggleStatus(user)
                                                    }
                                                    className={`p-1.5 rounded-lg transition-colors ${user.is_active ? "text-red-500 hover:bg-red-50" : "text-green-500 hover:bg-green-50"}`}
                                                    title={
                                                        user.is_active
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
                                                                user.is_active
                                                                    ? "M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                                                                    : "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                            }
                                                        />
                                                    </svg>
                                                </button>
                                                <button
                                                    onClick={() =>
                                                        setResetTarget(user)
                                                    }
                                                    className="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50 transition-colors"
                                                    title="Reset Password"
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
                                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
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
                                        colSpan={5}
                                        className="px-6 py-16 text-center text-gray-400"
                                    >
                                        <div className="text-4xl mb-2">👤</div>
                                        <div className="font-semibold">
                                            No admin users found
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                {/* Pagination */}
                {users?.links && users.links.length > 3 && (
                    <div className="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <span className="text-sm text-gray-500">
                            Showing {users.from}–{users.to} of {users.total}
                        </span>
                        <div className="flex gap-1">
                            {users.links.map((link, i) => (
                                <Link
                                    key={i}
                                    href={link.url || "#"}
                                    className={`px-3 py-1.5 rounded-lg text-sm transition-colors ${link.active ? "bg-orange-500 text-white" : "text-gray-600 hover:bg-gray-100"} ${!link.url ? "opacity-40 cursor-not-allowed" : ""}`}
                                    dangerouslySetInnerHTML={{
                                        __html: link.label,
                                    }}
                                />
                            ))}
                        </div>
                    </div>
                )}
            </div>

            {/* Create Modal */}
            {showCreateModal && (
                <CreateUserModal
                    companies={companies}
                    onClose={() => setShowCreateModal(false)}
                />
            )}

            {/* Reset Password Modal */}
            {resetTarget && (
                <ResetPasswordModal
                    user={resetTarget}
                    onClose={() => setResetTarget(null)}
                />
            )}
        </SuperAdminLayout>
    );
}

function CreateUserModal({ companies, onClose }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        company_id: "",
    });

    const submit = (e) => {
        e.preventDefault();
        post("/superadmin/admin-users", {
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    };

    const input =
        "w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors";

    return (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div className="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <div className="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 className="text-base font-bold text-gray-800">
                        Create Admin User
                    </h3>
                    <button
                        onClick={onClose}
                        className="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors"
                    >
                        <svg
                            className="w-5 h-5"
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
                <form onSubmit={submit} className="p-5 space-y-4">
                    {[
                        {
                            key: "name",
                            label: "Full Name",
                            type: "text",
                            placeholder: "John Doe",
                        },
                        {
                            key: "email",
                            label: "Email Address",
                            type: "email",
                            placeholder: "admin@company.com",
                        },
                        {
                            key: "password",
                            label: "Password",
                            type: "password",
                            placeholder: "Min 8 characters",
                        },
                    ].map((f) => (
                        <div key={f.key}>
                            <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                                {f.label}
                            </label>
                            <input
                                type={f.type}
                                className={input}
                                placeholder={f.placeholder}
                                value={data[f.key]}
                                onChange={(e) => setData(f.key, e.target.value)}
                            />
                            {errors[f.key] && (
                                <p className="text-red-500 text-xs mt-1">
                                    {errors[f.key]}
                                </p>
                            )}
                        </div>
                    ))}
                    <div>
                        <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                            Assign to Company
                        </label>
                        <select
                            className={input}
                            value={data.company_id}
                            onChange={(e) =>
                                setData("company_id", e.target.value)
                            }
                        >
                            <option value="">-- Select Company --</option>
                            {companies?.map((c) => (
                                <option key={c.id} value={c.id}>
                                    {c.name}
                                </option>
                            ))}
                        </select>
                        {errors.company_id && (
                            <p className="text-red-500 text-xs mt-1">
                                {errors.company_id}
                            </p>
                        )}
                    </div>
                    <div className="flex gap-3 pt-2">
                        <button
                            type="submit"
                            disabled={processing}
                            className="flex-1 bg-gradient-to-r from-orange-500 to-red-500 text-white py-2.5 rounded-xl font-semibold text-sm disabled:opacity-60"
                        >
                            {processing ? "Creating..." : "Create User"}
                        </button>
                        <button
                            type="button"
                            onClick={onClose}
                            className="flex-1 border-2 border-gray-200 text-gray-600 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}

function ResetPasswordModal({ user, onClose }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        password: "",
        password_confirmation: "",
    });

    const submit = (e) => {
        e.preventDefault();
        post(`/superadmin/admin-users/${user.id}/reset-password`, {
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    };

    const input =
        "w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors";

    return (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div className="bg-white rounded-2xl shadow-2xl w-full max-w-sm">
                <div className="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 className="text-base font-bold text-gray-800">
                        Reset Password
                    </h3>
                    <button
                        onClick={onClose}
                        className="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors"
                    >
                        <svg
                            className="w-5 h-5"
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
                <form onSubmit={submit} className="p-5 space-y-4">
                    <p className="text-sm text-gray-500">
                        Reset password for{" "}
                        <span className="font-semibold text-gray-800">
                            {user.name}
                        </span>
                    </p>
                    {[
                        { key: "password", label: "New Password" },
                        {
                            key: "password_confirmation",
                            label: "Confirm Password",
                        },
                    ].map((f) => (
                        <div key={f.key}>
                            <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                                {f.label}
                            </label>
                            <input
                                type="password"
                                className={input}
                                value={data[f.key]}
                                onChange={(e) => setData(f.key, e.target.value)}
                            />
                            {errors[f.key] && (
                                <p className="text-red-500 text-xs mt-1">
                                    {errors[f.key]}
                                </p>
                            )}
                        </div>
                    ))}
                    <div className="flex gap-3 pt-2">
                        <button
                            type="submit"
                            disabled={processing}
                            className="flex-1 bg-blue-500 text-white py-2.5 rounded-xl font-semibold text-sm hover:bg-blue-600 transition-colors disabled:opacity-60"
                        >
                            {processing ? "Resetting..." : "Reset Password"}
                        </button>
                        <button
                            type="button"
                            onClick={onClose}
                            className="flex-1 border-2 border-gray-200 text-gray-600 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
