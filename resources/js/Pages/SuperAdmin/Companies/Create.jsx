import { Head, useForm } from "@inertiajs/react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

export default function CompaniesCreate({ plans }) {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        email: "",
        phone: "",
        address: "",
        plan_id: "",
        trial_days: 14,
        admin_name: "",
        admin_email: "",
        admin_password: "",
    });

    const submit = (e) => {
        e.preventDefault();
        post("/superadmin/companies");
    };

    const Field = ({ label, error, children }) => (
        <div>
            <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                {label}
            </label>
            {children}
            {error && <p className="text-red-500 text-xs mt-1">{error}</p>}
        </div>
    );

    const input =
        "w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors";

    return (
        <SuperAdminLayout title="Add Company">
            <Head title="Add Company - SuperAdmin" />

            <div className="max-w-4xl">
                <p className="text-gray-500 text-sm mb-6">
                    Fill in the details below to register a new company and
                    create its admin account.
                </p>

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
                                    placeholder="e.g. Star Fan Ltd."
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
                                    placeholder="company@example.com"
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
                                    placeholder="+880-1XXX-XXXXXX"
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
                                    placeholder="City, Country"
                                />
                            </Field>
                        </div>
                    </div>

                    {/* Subscription */}
                    <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <h2 className="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span className="w-7 h-7 rounded-lg bg-orange-100 flex items-center justify-center">
                                📋
                            </span>
                            Subscription Plan
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <Field label="Select Plan *" error={errors.plan_id}>
                                <select
                                    className={input}
                                    value={data.plan_id}
                                    onChange={(e) =>
                                        setData("plan_id", e.target.value)
                                    }
                                >
                                    <option value="">
                                        -- Choose a Plan --
                                    </option>
                                    {plans?.map((plan) => (
                                        <option key={plan.id} value={plan.id}>
                                            {plan.name} — ৳
                                            {plan.price_monthly?.toLocaleString()}
                                            /mo
                                        </option>
                                    ))}
                                </select>
                            </Field>
                            <Field label="Trial Days" error={errors.trial_days}>
                                <input
                                    type="number"
                                    className={input}
                                    value={data.trial_days}
                                    onChange={(e) =>
                                        setData("trial_days", e.target.value)
                                    }
                                    min={0}
                                    max={90}
                                />
                            </Field>
                        </div>

                        {/* Plan feature preview */}
                        {data.plan_id &&
                            (() => {
                                const p = plans?.find(
                                    (pl) => pl.id == data.plan_id,
                                );
                                return p ? (
                                    <div className="mt-4 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                                        <div className="flex gap-4 text-sm flex-wrap">
                                            <span className="text-blue-700 font-semibold">
                                                {p.name}
                                            </span>
                                            <span className="text-gray-600">
                                                Max Users:{" "}
                                                <b>
                                                    {p.max_users ?? "Unlimited"}
                                                </b>
                                            </span>
                                            <span className="text-gray-600">
                                                Max Branches:{" "}
                                                <b>
                                                    {p.max_branches ??
                                                        "Unlimited"}
                                                </b>
                                            </span>
                                            <span className="text-blue-600 font-semibold">
                                                ৳
                                                {p.price_monthly?.toLocaleString()}
                                                /mo
                                            </span>
                                        </div>
                                    </div>
                                ) : null;
                            })()}
                    </div>

                    {/* Admin Account */}
                    <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <h2 className="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span className="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center">
                                👤
                            </span>
                            Admin Account
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <Field
                                label="Admin Full Name *"
                                error={errors.admin_name}
                            >
                                <input
                                    type="text"
                                    className={input}
                                    value={data.admin_name}
                                    onChange={(e) =>
                                        setData("admin_name", e.target.value)
                                    }
                                    placeholder="John Doe"
                                />
                            </Field>
                            <Field
                                label="Admin Email *"
                                error={errors.admin_email}
                            >
                                <input
                                    type="email"
                                    className={input}
                                    value={data.admin_email}
                                    onChange={(e) =>
                                        setData("admin_email", e.target.value)
                                    }
                                    placeholder="admin@company.com"
                                />
                            </Field>
                            <Field
                                label="Password *"
                                error={errors.admin_password}
                            >
                                <input
                                    type="password"
                                    className={input}
                                    value={data.admin_password}
                                    onChange={(e) =>
                                        setData(
                                            "admin_password",
                                            e.target.value,
                                        )
                                    }
                                    placeholder="Min 8 characters"
                                />
                            </Field>
                        </div>
                    </div>

                    <div className="flex gap-3 pt-2">
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-2.5 rounded-xl font-semibold text-sm shadow-lg hover:shadow-orange-200 transition-all disabled:opacity-60"
                        >
                            {processing ? "Creating..." : "Create Company"}
                        </button>
                        <a
                            href="/superadmin/companies"
                            className="px-6 py-2.5 rounded-xl text-sm font-semibold border-2 border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50 transition-all"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </SuperAdminLayout>
    );
}
