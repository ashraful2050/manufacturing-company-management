import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import { Head, Link, useForm } from "@inertiajs/react";

const CATEGORY_LABELS = {
    raw_material: { label: "Raw Material", color: "bg-blue-100 text-blue-700" },
    labor: { label: "Labor", color: "bg-orange-100 text-orange-700" },
    overhead: { label: "Overhead", color: "bg-purple-100 text-purple-700" },
    packing: { label: "Packing", color: "bg-teal-100 text-teal-700" },
    other: { label: "Other", color: "bg-gray-100 text-gray-600" },
};

const fmt = (v) =>
    "৳" +
    Number(v || 0).toLocaleString("en-BD", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

const calcAmount = (item) => {
    const q = parseFloat(item.qty) || 0;
    const p = parseFloat(item.unit_price) || 0;
    const a = parseFloat(item.appreciation) || 0;
    return q * p * (1 + a / 100);
};

export default function Edit({ entry }) {
    const { data, setData, put, processing, errors } = useForm({
        entry_date: entry?.entry_date ?? "",
        fan_model: entry?.fan_model ?? "",
        title: entry?.title ?? "",
        quantity: entry?.quantity ?? 1,
        selling_price: entry?.selling_price ?? 0,
        status: entry?.status ?? "draft",
        items: (entry?.items ?? []).map((item) => ({
            sort_order: item.sort_order,
            name_bn: item.name_bn,
            name_en: item.name_en,
            category: item.category,
            qty: item.qty ?? "",
            unit_price: item.unit_price ?? "",
            appreciation: item.appreciation ?? "0",
            source: item.source ?? "purchase",
        })),
    });

    const totals = data.items.reduce(
        (acc, item) => {
            const amt = calcAmount(item);
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

    const fanQty = parseFloat(data.quantity) || 1;
    const sellPrice = parseFloat(data.selling_price) || 0;
    const unitCost = totals.total / fanQty;
    const grossProfit = (sellPrice - unitCost) * fanQty;
    const marginPct =
        sellPrice * fanQty > 0 ? (grossProfit / (sellPrice * fanQty)) * 100 : 0;

    const setItem = (idx, field, value) => {
        const updated = [...data.items];
        updated[idx] = { ...updated[idx], [field]: value };
        setData("items", updated);
    };

    const addItem = () => {
        setData("items", [
            ...data.items,
            {
                sort_order: data.items.length + 1,
                name_bn: "",
                name_en: "",
                category: "raw_material",
                qty: "",
                unit_price: "",
                appreciation: "0",
                source: "purchase",
            },
        ]);
    };

    const removeItem = (idx) => {
        setData(
            "items",
            data.items.filter((_, i) => i !== idx),
        );
    };

    const submit = (e) => {
        e.preventDefault();
        put(`/production/fan-costing/${entry?.id}`);
    };

    const inputCls =
        "w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-400 transition-colors";
    const hdrInputCls =
        "w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-400 transition-colors";

    return (
        <ManufacturingLayout header="Edit Fan Cost Entry">
            <Head title={`Edit — ${entry?.entry_number}`} />

            <form onSubmit={submit} className="space-y-5">
                {/* ── Header Info ─────────────────────────────────────── */}
                <div className="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h2 className="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span className="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center text-base">
                            🏭
                        </span>
                        Entry Details —{" "}
                        <span className="font-mono text-blue-700">
                            {entry?.entry_number}
                        </span>
                    </h2>
                    <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div>
                            <label className="block text-xs font-semibold text-gray-500 mb-1">
                                Date *
                            </label>
                            <input
                                type="date"
                                className={hdrInputCls}
                                value={data.entry_date}
                                onChange={(e) =>
                                    setData("entry_date", e.target.value)
                                }
                                required
                            />
                            {errors.entry_date && (
                                <p className="text-red-500 text-xs mt-1">
                                    {errors.entry_date}
                                </p>
                            )}
                        </div>
                        <div>
                            <label className="block text-xs font-semibold text-gray-500 mb-1">
                                Fan Model
                            </label>
                            <input
                                type="text"
                                className={hdrInputCls}
                                value={data.fan_model}
                                onChange={(e) =>
                                    setData("fan_model", e.target.value)
                                }
                                placeholder="e.g. Alpha 56″"
                            />
                        </div>
                        <div>
                            <label className="block text-xs font-semibold text-gray-500 mb-1">
                                Title
                            </label>
                            <input
                                type="text"
                                className={hdrInputCls}
                                value={data.title}
                                onChange={(e) =>
                                    setData("title", e.target.value)
                                }
                                placeholder="Optional note"
                            />
                        </div>
                        <div>
                            <label className="block text-xs font-semibold text-gray-500 mb-1">
                                Qty (fans) *
                            </label>
                            <input
                                type="number"
                                min="0.01"
                                step="any"
                                className={hdrInputCls}
                                value={data.quantity}
                                onChange={(e) =>
                                    setData("quantity", e.target.value)
                                }
                                required
                            />
                            {errors.quantity && (
                                <p className="text-red-500 text-xs mt-1">
                                    {errors.quantity}
                                </p>
                            )}
                        </div>
                        <div>
                            <label className="block text-xs font-semibold text-gray-500 mb-1">
                                Selling Price / Unit *
                            </label>
                            <input
                                type="number"
                                min="0"
                                step="any"
                                className={hdrInputCls}
                                value={data.selling_price}
                                onChange={(e) =>
                                    setData("selling_price", e.target.value)
                                }
                                required
                            />
                            {errors.selling_price && (
                                <p className="text-red-500 text-xs mt-1">
                                    {errors.selling_price}
                                </p>
                            )}
                        </div>
                    </div>
                </div>

                {/* ── Cost Items table ─────────────────────────────────── */}
                <div className="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div className="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h2 className="text-base font-bold text-gray-800 flex items-center gap-2">
                            <span className="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center text-base">
                                📋
                            </span>
                            Cost Items ({data.items.length})
                        </h2>
                        <div className="flex items-center gap-3">
                            <span className="text-xs text-gray-400 hidden sm:block">
                                Amount = Qty × Unit Price × (1 + Appre%)
                            </span>
                            <button
                                type="button"
                                onClick={addItem}
                                className="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition-colors"
                            >
                                + Add Item
                            </button>
                        </div>
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
                                        Unit Price (৳)
                                    </th>
                                    <th className="text-right px-2 py-2.5 font-semibold text-gray-600 w-20">
                                        Appre. %
                                    </th>
                                    <th className="text-right px-2 py-2.5 font-semibold text-gray-600 w-28">
                                        Amount (৳)
                                    </th>
                                    <th className="w-8 px-1"></th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-50">
                                {data.items.map((item, idx) => {
                                    const rowAmt = calcAmount(item);
                                    const txtCls =
                                        "w-full px-2 py-1.5 border border-gray-200 rounded-lg text-xs focus:outline-none focus:border-blue-400 transition-colors";
                                    const numCls =
                                        "w-full px-2 py-1.5 border border-gray-200 rounded-lg text-xs focus:outline-none focus:border-blue-400 transition-colors text-right";
                                    return (
                                        <tr
                                            key={idx}
                                            className={
                                                idx % 2 === 0
                                                    ? "bg-white"
                                                    : "bg-gray-50/40"
                                            }
                                        >
                                            <td className="text-center px-2 py-1.5 text-gray-500 text-xs font-mono w-8">
                                                {idx + 1}
                                            </td>
                                            <td className="px-2 py-1.5">
                                                <select
                                                    className={
                                                        txtCls + " bg-white"
                                                    }
                                                    value={item.category}
                                                    onChange={(e) =>
                                                        setItem(
                                                            idx,
                                                            "category",
                                                            e.target.value,
                                                        )
                                                    }
                                                >
                                                    {Object.entries(
                                                        CATEGORY_LABELS,
                                                    ).map(([k, v]) => (
                                                        <option
                                                            key={k}
                                                            value={k}
                                                        >
                                                            {v.label}
                                                        </option>
                                                    ))}
                                                </select>
                                            </td>
                                            <td className="px-2 py-1.5">
                                                <input
                                                    type="text"
                                                    className={txtCls}
                                                    value={item.name_bn}
                                                    onChange={(e) =>
                                                        setItem(
                                                            idx,
                                                            "name_bn",
                                                            e.target.value,
                                                        )
                                                    }
                                                    placeholder="বাংলা নাম"
                                                />
                                            </td>
                                            <td className="px-2 py-1.5">
                                                <input
                                                    type="text"
                                                    className={txtCls}
                                                    value={item.name_en}
                                                    onChange={(e) =>
                                                        setItem(
                                                            idx,
                                                            "name_en",
                                                            e.target.value,
                                                        )
                                                    }
                                                    placeholder="English name"
                                                />
                                            </td>
                                            <td className="px-2 py-1.5">
                                                <select
                                                    className={
                                                        txtCls + " bg-white"
                                                    }
                                                    value={item.source}
                                                    onChange={(e) =>
                                                        setItem(
                                                            idx,
                                                            "source",
                                                            e.target.value,
                                                        )
                                                    }
                                                >
                                                    <option value="purchase">
                                                        Purchase
                                                    </option>
                                                    <option value="in_house">
                                                        In House
                                                    </option>
                                                </select>
                                            </td>
                                            <td className="px-2 py-1.5">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="any"
                                                    className={numCls}
                                                    value={item.qty}
                                                    onChange={(e) =>
                                                        setItem(
                                                            idx,
                                                            "qty",
                                                            e.target.value,
                                                        )
                                                    }
                                                    placeholder="0"
                                                />
                                            </td>
                                            <td className="px-2 py-1.5">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="any"
                                                    className={numCls}
                                                    value={item.unit_price}
                                                    onChange={(e) =>
                                                        setItem(
                                                            idx,
                                                            "unit_price",
                                                            e.target.value,
                                                        )
                                                    }
                                                    placeholder="0.00"
                                                />
                                            </td>
                                            <td className="px-2 py-1.5">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    max="999"
                                                    step="any"
                                                    className={numCls}
                                                    value={item.appreciation}
                                                    onChange={(e) =>
                                                        setItem(
                                                            idx,
                                                            "appreciation",
                                                            e.target.value,
                                                        )
                                                    }
                                                    placeholder="0"
                                                />
                                            </td>
                                            <td className="px-2 py-1.5 text-right font-semibold text-indigo-700 text-xs whitespace-nowrap">
                                                {fmt(rowAmt)}
                                                {parseFloat(item.appreciation) >
                                                    0 && (
                                                    <div className="text-gray-400 font-normal text-xs">
                                                        {item.qty || 0} ×{" "}
                                                        {fmt(
                                                            item.unit_price ||
                                                                0,
                                                        )}{" "}
                                                        + {item.appreciation}%
                                                    </div>
                                                )}
                                            </td>
                                            <td className="px-1 py-1.5 text-center">
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        removeItem(idx)
                                                    }
                                                    className="w-6 h-6 flex items-center justify-center rounded text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors text-base leading-none mx-auto"
                                                    title="Remove row"
                                                >
                                                    ×
                                                </button>
                                            </td>
                                        </tr>
                                    );
                                })}
                            </tbody>
                            <tfoot className="bg-gray-100 border-t-2 border-gray-300">
                                <tr>
                                    <td
                                        colSpan={9}
                                        className="px-3 py-2.5 font-bold text-gray-700 text-right text-sm"
                                    >
                                        Grand Total
                                    </td>
                                    <td className="px-2 py-2.5 text-right font-bold text-gray-900">
                                        {fmt(totals.total)}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {/* ── Category Subtotals ───────────────────────────────── */}
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    {Object.entries(CATEGORY_LABELS).map(([key, meta]) => (
                        <div
                            key={key}
                            className="bg-white rounded-xl border border-gray-200 shadow-sm p-4"
                        >
                            <p className="text-xs font-semibold text-gray-500 mb-1">
                                {meta.label}
                            </p>
                            <p className="text-lg font-bold text-gray-800">
                                {fmt(totals[key])}
                            </p>
                            <span
                                className={`text-xs px-2 py-0.5 rounded ${meta.color}`}
                            >
                                {meta.label}
                            </span>
                        </div>
                    ))}
                </div>

                {/* ── Summary Cards ────────────────────────────────────── */}
                <div className="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h2 className="text-base font-bold text-gray-800 mb-4">
                        Cost Summary (Live Preview)
                    </h2>
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div className="bg-gray-50 rounded-xl p-4 text-center">
                            <p className="text-xs text-gray-500 mb-1">
                                Total Cost (Batch)
                            </p>
                            <p className="text-2xl font-bold text-gray-800">
                                {fmt(totals.total)}
                            </p>
                        </div>
                        <div className="bg-indigo-50 rounded-xl p-4 text-center">
                            <p className="text-xs text-indigo-600 mb-1">
                                Unit Cost / Fan
                            </p>
                            <p className="text-2xl font-bold text-indigo-700">
                                {fmt(unitCost)}
                            </p>
                        </div>
                        <div
                            className={`rounded-xl p-4 text-center ${grossProfit >= 0 ? "bg-green-50" : "bg-red-50"}`}
                        >
                            <p
                                className={`text-xs mb-1 ${grossProfit >= 0 ? "text-green-600" : "text-red-500"}`}
                            >
                                Gross Profit
                            </p>
                            <p
                                className={`text-2xl font-bold ${grossProfit >= 0 ? "text-green-700" : "text-red-600"}`}
                            >
                                {fmt(grossProfit)}
                            </p>
                        </div>
                        <div
                            className={`rounded-xl p-4 text-center ${marginPct >= 0 ? "bg-teal-50" : "bg-red-50"}`}
                        >
                            <p
                                className={`text-xs mb-1 ${marginPct >= 0 ? "text-teal-600" : "text-red-500"}`}
                            >
                                Gross Margin %
                            </p>
                            <p
                                className={`text-2xl font-bold ${marginPct >= 0 ? "text-teal-700" : "text-red-600"}`}
                            >
                                {marginPct.toFixed(2)}%
                            </p>
                        </div>
                    </div>
                </div>

                {/* ── Actions ─────────────────────────────────────────── */}
                <div className="flex items-center justify-between bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                    <Link
                        href={`/production/fan-costing/${entry?.id}`}
                        className="text-sm text-gray-500 hover:text-gray-700"
                    >
                        ← Back to view
                    </Link>
                    <div className="flex gap-3">
                        <button
                            type="submit"
                            onClick={() => setData("status", "draft")}
                            disabled={processing}
                            className="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-60"
                        >
                            Save as Draft
                        </button>
                        <button
                            type="submit"
                            onClick={() => setData("status", "finalized")}
                            disabled={processing}
                            className="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-60"
                        >
                            {processing ? "Saving…" : "Update & Finalize"}
                        </button>
                    </div>
                </div>
            </form>
        </ManufacturingLayout>
    );
}
