import { Head, useForm, Link } from "@inertiajs/react";
import { useState } from "react";
import SuperAdminLayout from "@/Layouts/SuperAdminLayout";

export default function PlansCreate({ featuresByModule }) {
    const [openModules, setOpenModules] = useState({});

    const { data, setData, post, processing, errors } = useForm({
        name: "",
        slug: "",
        description: "",
        price_monthly: "",
        price_yearly: "",
        max_users: "",
        max_branches: "",
        storage_limit_gb: "",
        is_popular: false,
        is_active: true,
        features: {},
    });

    const toggleModule = (mod) =>
        setOpenModules((p) => ({ ...p, [mod]: !p[mod] }));

    const handleFeatureToggle = (featureId, enabled) => {
        setData("features", {
            ...data.features,
            [featureId]: enabled
                ? {
                      is_enabled: 1,
                      limit_value:
                          data.features[featureId]?.limit_value ?? null,
                  }
                : undefined,
        });
    };

    const handleLimitChange = (featureId, val) => {
        if (data.features[featureId]) {
            setData("features", {
                ...data.features,
                [featureId]: { ...data.features[featureId], limit_value: val },
            });
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post("/superadmin/plans");
    };

    const input =
        "w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors";

    const moduleIcons = {
        "Company Setup": "🏢",
        "User Management": "👥",
        "Product Management": "📦",
        Procurement: "🛒",
        "Import Management": "🚢",
        Inventory: "🏭",
        Production: "⚙️",
        "Quality Control": "✅",
        Sales: "💰",
        "Dealer Management": "🤝",
        CRM: "📞",
        "Warranty & Service": "🔧",
        "Accounts & Finance": "📊",
        "VAT & Tax": "🧾",
        "HR & Payroll": "👔",
        "Asset Management": "🏗️",
        "Dashboard & Reports": "📈",
        Notifications: "🔔",
        Integrations: "🔌",
        "Approval Workflow": "✍️",
    };

    return (
        <SuperAdminLayout title="Create Plan">
            <Head title="Create Plan - SuperAdmin" />

            <div className="max-w-4xl">
                <form onSubmit={submit} className="space-y-5">
                    {/* Basic Info */}
                    <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <h2 className="text-base font-bold text-gray-800 mb-4">
                            Plan Information
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Plan Name *
                                </label>
                                <input
                                    type="text"
                                    className={input}
                                    value={data.name}
                                    onChange={(e) => {
                                        setData("name", e.target.value);
                                        setData(
                                            "slug",
                                            e.target.value
                                                .toLowerCase()
                                                .replace(/\s+/g, "-"),
                                        );
                                    }}
                                    placeholder="e.g. Starter"
                                />
                                {errors.name && (
                                    <p className="text-red-500 text-xs mt-1">
                                        {errors.name}
                                    </p>
                                )}
                            </div>
                            <div>
                                <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Slug
                                </label>
                                <input
                                    type="text"
                                    className={input + " bg-gray-50"}
                                    value={data.slug}
                                    readOnly
                                />
                            </div>
                            <div className="sm:col-span-2">
                                <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Description
                                </label>
                                <textarea
                                    rows={2}
                                    className={input}
                                    value={data.description}
                                    onChange={(e) =>
                                        setData("description", e.target.value)
                                    }
                                    placeholder="Brief description of this plan"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Pricing & Limits */}
                    <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <h2 className="text-base font-bold text-gray-800 mb-4">
                            Pricing & Limits
                        </h2>
                        <div className="grid grid-cols-2 sm:grid-cols-3 gap-5">
                            {[
                                {
                                    key: "price_monthly",
                                    label: "Monthly Price (৳) *",
                                    placeholder: "1500",
                                },
                                {
                                    key: "price_yearly",
                                    label: "Yearly Price (৳)",
                                    placeholder: "15000",
                                },
                                {
                                    key: "max_users",
                                    label: "Max Users (blank = unlimited)",
                                    placeholder: "10",
                                },
                                {
                                    key: "max_branches",
                                    label: "Max Branches",
                                    placeholder: "3",
                                },
                                {
                                    key: "storage_limit_gb",
                                    label: "Storage (GB)",
                                    placeholder: "10",
                                },
                            ].map((f) => (
                                <div key={f.key}>
                                    <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                                        {f.label}
                                    </label>
                                    <input
                                        type="number"
                                        className={input}
                                        value={data[f.key]}
                                        onChange={(e) =>
                                            setData(f.key, e.target.value)
                                        }
                                        placeholder={f.placeholder}
                                        min={0}
                                    />
                                    {errors[f.key] && (
                                        <p className="text-red-500 text-xs mt-1">
                                            {errors[f.key]}
                                        </p>
                                    )}
                                </div>
                            ))}
                            <div className="flex flex-col gap-3 justify-end">
                                <label className="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={data.is_popular}
                                        onChange={(e) =>
                                            setData(
                                                "is_popular",
                                                e.target.checked,
                                            )
                                        }
                                        className="w-4 h-4 rounded accent-orange-500"
                                    />
                                    <span className="text-sm font-semibold text-gray-700">
                                        Mark as Popular
                                    </span>
                                </label>
                                <label className="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={data.is_active}
                                        onChange={(e) =>
                                            setData(
                                                "is_active",
                                                e.target.checked,
                                            )
                                        }
                                        className="w-4 h-4 rounded accent-orange-500"
                                    />
                                    <span className="text-sm font-semibold text-gray-700">
                                        Active
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {/* Features */}
                    <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div className="flex items-center justify-between mb-4">
                            <h2 className="text-base font-bold text-gray-800">
                                Feature Access
                            </h2>
                            <span className="text-sm text-gray-400">
                                {
                                    Object.keys(data.features).filter(
                                        (k) => data.features[k],
                                    ).length
                                }{" "}
                                features enabled
                            </span>
                        </div>

                        <div className="space-y-2">
                            {featuresByModule &&
                                Object.entries(featuresByModule).map(
                                    ([module, features]) => (
                                        <div
                                            key={module}
                                            className="border border-gray-100 rounded-xl overflow-hidden"
                                        >
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    toggleModule(module)
                                                }
                                                className="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors text-left"
                                            >
                                                <span className="flex items-center gap-2 font-semibold text-gray-700 text-sm">
                                                    <span>
                                                        {moduleIcons[module] ||
                                                            "📁"}
                                                    </span>
                                                    {module}
                                                    <span className="bg-orange-100 text-orange-600 text-xs px-2 py-0.5 rounded-full">
                                                        {
                                                            features.filter(
                                                                (f) =>
                                                                    data
                                                                        .features[
                                                                        f.id
                                                                    ],
                                                            ).length
                                                        }
                                                        /{features.length}
                                                    </span>
                                                </span>
                                                <svg
                                                    className={`w-4 h-4 text-gray-400 transition-transform ${openModules[module] ? "rotate-180" : ""}`}
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        strokeLinecap="round"
                                                        strokeLinejoin="round"
                                                        strokeWidth={2}
                                                        d="M19 9l-7 7-7-7"
                                                    />
                                                </svg>
                                            </button>

                                            {openModules[module] && (
                                                <div className="px-4 py-3 space-y-2 bg-white">
                                                    {/* Select all toggle */}
                                                    <div className="flex justify-end mb-2">
                                                        <button
                                                            type="button"
                                                            className="text-xs text-blue-500 hover:underline"
                                                            onClick={() => {
                                                                const allEnabled =
                                                                    features.every(
                                                                        (f) =>
                                                                            data
                                                                                .features[
                                                                                f
                                                                                    .id
                                                                            ],
                                                                    );
                                                                const next = {
                                                                    ...data.features,
                                                                };
                                                                features.forEach(
                                                                    (f) => {
                                                                        next[
                                                                            f.id
                                                                        ] =
                                                                            allEnabled
                                                                                ? undefined
                                                                                : {
                                                                                      is_enabled: 1,
                                                                                      limit_value:
                                                                                          null,
                                                                                  };
                                                                    },
                                                                );
                                                                setData(
                                                                    "features",
                                                                    next,
                                                                );
                                                            }}
                                                        >
                                                            {features.every(
                                                                (f) =>
                                                                    data
                                                                        .features[
                                                                        f.id
                                                                    ],
                                                            )
                                                                ? "Deselect All"
                                                                : "Select All"}
                                                        </button>
                                                    </div>
                                                    {features.map((feature) => (
                                                        <div
                                                            key={feature.id}
                                                            className="flex items-center justify-between py-1.5 border-b border-gray-50 last:border-0"
                                                        >
                                                            <label className="flex items-center gap-2.5 cursor-pointer flex-1">
                                                                <input
                                                                    type="checkbox"
                                                                    checked={
                                                                        !!data
                                                                            .features[
                                                                            feature
                                                                                .id
                                                                        ]
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) =>
                                                                        handleFeatureToggle(
                                                                            feature.id,
                                                                            e
                                                                                .target
                                                                                .checked,
                                                                        )
                                                                    }
                                                                    className="w-4 h-4 rounded accent-orange-500"
                                                                />
                                                                <span className="text-sm text-gray-700">
                                                                    {
                                                                        feature.name
                                                                    }
                                                                </span>
                                                            </label>
                                                            {data.features[
                                                                feature.id
                                                            ] && (
                                                                <input
                                                                    type="number"
                                                                    placeholder="Limit (optional)"
                                                                    value={
                                                                        data
                                                                            .features[
                                                                            feature
                                                                                .id
                                                                        ]
                                                                            ?.limit_value ??
                                                                        ""
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) =>
                                                                        handleLimitChange(
                                                                            feature.id,
                                                                            e
                                                                                .target
                                                                                .value ||
                                                                                null,
                                                                        )
                                                                    }
                                                                    className="w-28 px-2 py-1 border border-gray-200 rounded-lg text-xs focus:outline-none focus:border-orange-400 text-right"
                                                                />
                                                            )}
                                                        </div>
                                                    ))}
                                                </div>
                                            )}
                                        </div>
                                    ),
                                )}
                        </div>
                    </div>

                    <div className="flex gap-3 pt-2">
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-2.5 rounded-xl font-semibold text-sm shadow-lg hover:shadow-orange-200 transition-all disabled:opacity-60"
                        >
                            {processing ? "Creating..." : "Create Plan"}
                        </button>
                        <Link
                            href="/superadmin/plans"
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
