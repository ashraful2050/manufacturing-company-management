import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import { Head, Link } from "@inertiajs/react";

const CATEGORY_LABELS = {
    raw_material: {
        label: "Raw Material",
        color: "bg-blue-100 text-blue-700",
        cardBg: "bg-blue-50",
        textColor: "text-blue-800",
    },
    labor: {
        label: "Labor",
        color: "bg-orange-100 text-orange-700",
        cardBg: "bg-orange-50",
        textColor: "text-orange-800",
    },
    overhead: {
        label: "Overhead",
        color: "bg-purple-100 text-purple-700",
        cardBg: "bg-purple-50",
        textColor: "text-purple-800",
    },
    packing: {
        label: "Packing",
        color: "bg-teal-100 text-teal-700",
        cardBg: "bg-teal-50",
        textColor: "text-teal-800",
    },
    other: {
        label: "Other",
        color: "bg-gray-100 text-gray-600",
        cardBg: "bg-gray-50",
        textColor: "text-gray-700",
    },
};

const fmt = (v, decimals = 2) =>
    "৳" +
    Number(v || 0).toLocaleString("en-BD", {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
    });

export default function Show({ entry }) {
    const items = entry?.items ?? [];

    const totals = items.reduce(
        (acc, item) => {
            const amt = parseFloat(item.amount) || 0;
            acc[item.category] = (acc[item.category] || 0) + amt;
            acc.total += amt;
            return acc;
        },
        {
            raw_material: 0,
            labor: 0,
            overhead: 0,
            packing: 0,
            other: 0,
            total: 0,
        },
    );

    // Group items by category for display
    const grouped = {};
    items.forEach((item) => {
        if (!grouped[item.category]) grouped[item.category] = [];
        grouped[item.category].push(item);
    });

    const statusBadge = {
        draft: "bg-yellow-100 text-yellow-700",
        finalized: "bg-green-100 text-green-700",
    };

    return (
        <ManufacturingLayout header="Fan Cost Entry">
            <Head title={`Cost Entry — ${entry?.entry_number}`} />

            <div className="space-y-5">
                {/* ── Top bar ──────────────────────────────────────────── */}
                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <Link
                            href="/production/fan-costing"
                            className="text-sm text-gray-500 hover:text-gray-700"
                        >
                            ← Back
                        </Link>
                        <span className="text-gray-300">/</span>
                        <h1 className="text-xl font-bold text-gray-800">
                            {entry?.entry_number}
                            {entry?.fan_model && (
                                <span className="ml-2 text-base text-gray-500 font-normal">
                                    — {entry.fan_model}
                                </span>
                            )}
                        </h1>
                        <span
                            className={`px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize ${statusBadge[entry?.status] ?? ""}`}
                        >
                            {entry?.status}
                        </span>
                    </div>
                    <div className="flex gap-2">
                        <Link
                            href={`/production/fan-costing/${entry?.id}/edit`}
                            className="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors"
                        >
                            Edit
                        </Link>
                        <button
                            onClick={() => window.print()}
                            className="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors"
                        >
                            🖨 Print
                        </button>
                    </div>
                </div>

                {/* ── Entry meta ───────────────────────────────────────── */}
                <div className="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p className="text-xs text-gray-500 mb-0.5">
                                Entry Date
                            </p>
                            <p className="font-semibold text-gray-800">
                                {entry?.entry_date}
                            </p>
                        </div>
                        <div>
                            <p className="text-xs text-gray-500 mb-0.5">
                                Fan Model
                            </p>
                            <p className="font-semibold text-gray-800">
                                {entry?.fan_model || "—"}
                            </p>
                        </div>
                        <div>
                            <p className="text-xs text-gray-500 mb-0.5">
                                Quantity (Batch)
                            </p>
                            <p className="font-semibold text-gray-800">
                                {entry?.quantity} fans
                            </p>
                        </div>
                        <div>
                            <p className="text-xs text-gray-500 mb-0.5">
                                Selling Price / Unit
                            </p>
                            <p className="font-semibold text-gray-800">
                                {fmt(entry?.selling_price)}
                            </p>
                        </div>
                    </div>
                    {entry?.title && (
                        <p className="mt-3 text-sm text-gray-500 italic">
                            "{entry.title}"
                        </p>
                    )}
                </div>

                {/* ── Summary Cards ────────────────────────────────────── */}
                <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div className="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center">
                        <p className="text-xs text-gray-500 mb-1">
                            Total Cost (Batch)
                        </p>
                        <p className="text-2xl font-bold text-gray-800">
                            {fmt(entry?.total_cost)}
                        </p>
                    </div>
                    <div className="bg-indigo-50 rounded-xl border border-indigo-100 shadow-sm p-4 text-center">
                        <p className="text-xs text-indigo-600 mb-1">
                            Unit Cost / Fan
                        </p>
                        <p className="text-2xl font-bold text-indigo-700">
                            {fmt(entry?.unit_cost, 4)}
                        </p>
                    </div>
                    <div
                        className={`rounded-xl border shadow-sm p-4 text-center ${entry?.gross_profit >= 0 ? "bg-green-50 border-green-100" : "bg-red-50 border-red-100"}`}
                    >
                        <p
                            className={`text-xs mb-1 ${entry?.gross_profit >= 0 ? "text-green-600" : "text-red-500"}`}
                        >
                            Gross Profit
                        </p>
                        <p
                            className={`text-2xl font-bold ${entry?.gross_profit >= 0 ? "text-green-700" : "text-red-600"}`}
                        >
                            {fmt(entry?.gross_profit)}
                        </p>
                    </div>
                    <div
                        className={`rounded-xl border shadow-sm p-4 text-center ${entry?.gross_margin_pct >= 0 ? "bg-teal-50 border-teal-100" : "bg-red-50 border-red-100"}`}
                    >
                        <p
                            className={`text-xs mb-1 ${entry?.gross_margin_pct >= 0 ? "text-teal-600" : "text-red-500"}`}
                        >
                            Gross Margin %
                        </p>
                        <p
                            className={`text-2xl font-bold ${entry?.gross_margin_pct >= 0 ? "text-teal-700" : "text-red-600"}`}
                        >
                            {Number(entry?.gross_margin_pct || 0).toFixed(2)}%
                        </p>
                    </div>
                </div>

                {/* ── Category Breakdown ───────────────────────────────── */}
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    {Object.entries(CATEGORY_LABELS).map(([key, meta]) => (
                        <div
                            key={key}
                            className={`${meta.cardBg} rounded-xl border border-gray-100 p-4`}
                        >
                            <p
                                className={`text-xs font-semibold mb-1 ${meta.textColor}`}
                            >
                                {meta.label}
                            </p>
                            <p
                                className={`text-xl font-bold ${meta.textColor}`}
                            >
                                {fmt(
                                    entry?.[`total_${key}_cost`] ?? totals[key],
                                )}
                            </p>
                            <p className="text-xs text-gray-400 mt-1">
                                {totals.total > 0
                                    ? (
                                          (totals[key] / totals.total) *
                                          100
                                      ).toFixed(1)
                                    : "0.0"}
                                %
                            </p>
                        </div>
                    ))}
                </div>

                {/* ── Full item table ──────────────────────────────────── */}
                <div className="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 className="text-base font-bold text-gray-800">
                            All Cost Items ({items.length})
                        </h2>
                        <span className="text-xs text-gray-400">
                            Amount = Qty × Unit Price × (1 + Appreciation%)
                        </span>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead className="bg-gray-50 border-b border-gray-200 text-xs">
                                <tr>
                                    <th className="text-center px-2 py-2.5 font-semibold text-gray-500 w-8">
                                        Sl.
                                    </th>
                                    <th className="text-center px-2 py-2.5 font-semibold text-gray-600 w-28">
                                        Category
                                    </th>
                                    <th className="text-left px-3 py-2.5 font-semibold text-gray-600 min-w-[120px]">
                                        Item (বাংলা)
                                    </th>
                                    <th className="text-left px-3 py-2.5 font-semibold text-gray-600 min-w-[130px]">
                                        Item (English)
                                    </th>
                                    <th className="text-center px-2 py-2.5 font-semibold text-gray-600 w-24">
                                        Source
                                    </th>
                                    <th className="text-right px-2 py-2.5 font-semibold text-gray-600 w-20">
                                        Qty
                                    </th>
                                    <th className="text-right px-2 py-2.5 font-semibold text-gray-600 w-28">
                                        Unit Price
                                    </th>
                                    <th className="text-right px-2 py-2.5 font-semibold text-gray-600 w-20">
                                        Appre. %
                                    </th>
                                    <th className="text-right px-2 py-2.5 font-semibold text-gray-600 w-36">
                                        Arithmetic (৳)
                                    </th>
                                    <th className="text-right px-2 py-2.5 font-semibold text-gray-500 w-16">
                                        % of Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-50">
                                {items.map((item, idx) => {
                                    const qty = parseFloat(item.qty) || 0;
                                    const price =
                                        parseFloat(item.unit_price) || 0;
                                    const app =
                                        parseFloat(item.appreciation) || 0;
                                    const amt = parseFloat(item.amount) || 0;
                                    return (
                                        <tr
                                            key={idx}
                                            className={
                                                idx % 2 === 0
                                                    ? "bg-white"
                                                    : "bg-gray-50/40"
                                            }
                                        >
                                            <td className="text-center px-2 py-2 text-gray-500 text-xs font-mono">
                                                {idx + 1}
                                            </td>
                                            <td className="px-2 py-2 text-center">
                                                <span
                                                    className={`px-1.5 py-0.5 rounded text-xs font-medium ${CATEGORY_LABELS[item.category]?.color}`}
                                                >
                                                    {
                                                        CATEGORY_LABELS[
                                                            item.category
                                                        ]?.label
                                                    }
                                                </span>
                                            </td>
                                            <td className="px-3 py-2 font-medium text-gray-800 text-xs">
                                                {item.name_bn}
                                            </td>
                                            <td className="px-3 py-2 text-gray-600 text-xs">
                                                {item.name_en}
                                            </td>
                                            <td className="px-2 py-2 text-center">
                                                <span
                                                    className={`px-1.5 py-0.5 rounded text-xs font-medium ${item.source === "in_house" ? "bg-violet-100 text-violet-700" : "bg-cyan-100 text-cyan-700"}`}
                                                >
                                                    {item.source === "in_house"
                                                        ? "In House"
                                                        : "Purchase"}
                                                </span>
                                            </td>
                                            <td className="px-2 py-2 text-right text-gray-700 text-xs font-mono">
                                                {qty > 0 ? qty : "—"}
                                            </td>
                                            <td className="px-2 py-2 text-right text-gray-700 text-xs">
                                                {price > 0 ? fmt(price) : "—"}
                                            </td>
                                            <td className="px-2 py-2 text-right text-gray-700 text-xs">
                                                {app > 0 ? `${app}%` : "—"}
                                            </td>
                                            <td className="px-2 py-2 text-right text-xs">
                                                <span className="font-semibold text-indigo-700">
                                                    {fmt(amt)}
                                                </span>
                                                {qty > 0 && price > 0 && (
                                                    <div className="text-gray-400 font-normal mt-0.5">
                                                        {qty} × {fmt(price)}
                                                        {app > 0
                                                            ? ` × (1+${app}%)`
                                                            : ""}
                                                    </div>
                                                )}
                                            </td>
                                            <td className="px-2 py-2 text-right text-gray-400 text-xs">
                                                {totals.total > 0
                                                    ? (
                                                          (amt / totals.total) *
                                                          100
                                                      ).toFixed(1)
                                                    : "0.0"}
                                                %
                                            </td>
                                        </tr>
                                    );
                                })}
                            </tbody>
                            <tfoot className="bg-gray-100 border-t-2 border-gray-300">
                                <tr>
                                    <td
                                        colSpan={9}
                                        className="px-3 py-3 font-bold text-gray-800 text-right"
                                    >
                                        Grand Total
                                    </td>
                                    <td className="px-2 py-3 text-right font-bold text-gray-900 text-base">
                                        {fmt(totals.total)}
                                    </td>
                                    <td className="px-2 py-3 text-right text-xs text-gray-500">
                                        100%
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </ManufacturingLayout>
    );
}
