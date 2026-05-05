import { Head, useForm, Link } from "@inertiajs/react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

export default function CompaniesEdit({ company, plans }) {
    const { data, setData, put, processing, errors } = useForm({
        name: company.name || "",
        email: company.email || "",
        phone: company.phone || "",
        address: company.address || "",
        plan_id: company.current_subscription?.plan_id || "",
        is_active: company.is_active ? "1" : "0",
        registration_number: company.registration_number || "",
        tin_number: company.tin_number || "",
        bin_number: company.bin_number || "",
    });

    const submit = (e) => {
        e.preventDefault();
        put(`/superadmin/companies/${company.id}`);
    };

    const input =
        "w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors";

    const Field = ({ label, error, children }) => (
        <div>
            <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                {label}
            </label>
            {children}
            {error && <p className="text-red-500 text-xs mt-1">{error}</p>}
        </div>
    );

    return (
        <SuperAdminLayout title={`Edit: ${company.name}`}>
            <Head title={`Edit ${company.name} - SuperAdmin`} />

            <div className="max-w-3xl">
                <form onSubmit={submit} className="space-y-5">
                    {/* Company Info */}
                    <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <h2 className="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span className="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                                🏢
                            </span>
                            Company Information
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <Field label="Company Name *" error={errors.name}>
                                <input
                                    type="text"
                                    className={input}
                                    value={data.name}
                                    onChange={(e) =>
                                        setData("name", e.target.value)
                                    }
                                />
                            </Field>
                            <Field label="Company Email *" error={errors.email}>
                                <input
                                    type="email"
                                    className={input}
                                    value={data.email}
                                    onChange={(e) =>
                                        setData("email", e.target.value)
                                    }
                                />
                            </Field>
                            <Field label="Phone" error={errors.phone}>
                                <input
                                    type="text"
                                    className={input}
                                    value={data.phone}
                                    onChange={(e) =>
                                        setData("phone", e.target.value)
                                    }
                                />
                            </Field>
                            <Field label="Address" error={errors.address}>
                                <input
                                    type="text"
                                    className={input}
                                    value={data.address}
                                    onChange={(e) =>
                                        setData("address", e.target.value)
                                    }
                                />
                            </Field>
                            <Field
                                label="Registration No."
                                error={errors.registration_number}
                            >
                                <input
                                    type="text"
                                    className={input}
                                    value={data.registration_number}
                                    onChange={(e) =>
                                        setData(
                                            "registration_number",
                                            e.target.value,
                                        )
                                    }
                                />
                            </Field>
                            <Field label="TIN Number" error={errors.tin_number}>
                                <input
                                    type="text"
                                    className={input}
                                    value={data.tin_number}
                                    onChange={(e) =>
                                        setData("tin_number", e.target.value)
                                    }
                                />
                            </Field>
                            <Field label="BIN Number" error={errors.bin_number}>
                                <input
                                    type="text"
                                    className={input}
                                    value={data.bin_number}
                                    onChange={(e) =>
                                        setData("bin_number", e.target.value)
                                    }
                                />
                            </Field>
                        </div>
                    </div>

                    {/* Subscription & Status */}
                    <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <h2 className="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span className="w-7 h-7 rounded-lg bg-orange-100 flex items-center justify-center">
                                📋
                            </span>
                            Plan & Status
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <Field
                                label="Subscription Plan"
                                error={errors.plan_id}
                            >
                                <select
                                    className={input}
                                    value={data.plan_id}
                                    onChange={(e) =>
                                        setData("plan_id", e.target.value)
                                    }
                                >
                                    <option value="">-- No Plan --</option>
                                    {plans?.map((plan) => (
                                        <option key={plan.id} value={plan.id}>
                                            {plan.name} — ৳
                                            {plan.price_monthly?.toLocaleString()}
                                            /mo
                                        </option>
                                    ))}
                                </select>
                            </Field>
                            <Field label="Status" error={errors.is_active}>
                                <select
                                    className={input}
                                    value={data.is_active}
                                    onChange={(e) =>
                                        setData("is_active", e.target.value)
                                    }
                                >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </Field>
                        </div>
                    </div>

                    <div className="flex gap-3 pt-2">
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-2.5 rounded-xl font-semibold text-sm shadow-lg hover:shadow-orange-200 transition-all disabled:opacity-60"
                        >
                            {processing ? "Saving..." : "Save Changes"}
                        </button>
                        <Link
                            href={`/superadmin/companies/${company.id}`}
                            className="px-6 py-2.5 rounded-xl text-sm font-semibold border-2 border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </SuperAdminLayout>
    );
}
