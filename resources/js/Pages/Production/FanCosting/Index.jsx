import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import { Head, Link, router } from "@inertiajs/react";

const fmt = (v) =>
    v != null
        ? "৳" +
          Number(v).toLocaleString("en-BD", {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
          })
        : "-";

const statusBadge = {
    draft: "bg-yellow-100 text-yellow-700",
    finalized: "bg-green-100 text-green-700",
};

export default function Index({ entries }) {
    const rows = entries?.data ?? [];

    const handleDelete = (id) => {
        if (!confirm("Delete this cost entry?")) return;
        router.delete(`/production/fan-costing/${id}`);
    };

    return (
        <ManufacturingLayout header="Fan Product Costing">
            <Head title="Fan Product Costing" />

            <div className="space-y-4">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-xl font-bold text-gray-800">
                            Fan Product Costing
                        </h1>
                        <p className="text-sm text-gray-500 mt-0.5">
                            Calculate per-unit production cost for fans (37 cost
                            items)
                        </p>
                    </div>
                    <Link
                        href="/production/fan-costing/create"
                        className="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors"
                    >
                        <span>+</span> New Cost Entry
                    </Link>
                </div>

                {/* Table */}
                <div className="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead className="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th className="text-left px-4 py-3 font-semibold text-gray-600">
                                        #
                                    </th>
                                    <th className="text-left px-4 py-3 font-semibold text-gray-600">
                                        Entry No.
                                    </th>
                                    <th className="text-left px-4 py-3 font-semibold text-gray-600">
                                        Date
                                    </th>
                                    <th className="text-left px-4 py-3 font-semibold text-gray-600">
                                        Fan Model
                                    </th>
                                    <th className="text-right px-4 py-3 font-semibold text-gray-600">
                                        Qty
                                    </th>
                                    <th className="text-right px-4 py-3 font-semibold text-gray-600">
                                        Total Cost
                                    </th>
                                    <th className="text-right px-4 py-3 font-semibold text-gray-600">
                                        Unit Cost
                                    </th>
                                    <th className="text-right px-4 py-3 font-semibold text-gray-600">
                                        Selling Price
                                    </th>
                                    <th className="text-right px-4 py-3 font-semibold text-gray-600">
                                        Margin %
                                    </th>
                                    <th className="text-center px-4 py-3 font-semibold text-gray-600">
                                        Status
                                    </th>
                                    <th className="text-center px-4 py-3 font-semibold text-gray-600">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {rows.length === 0 ? (
                                    <tr>
                                        <td
                                            colSpan={11}
                                            className="text-center py-12 text-gray-400"
                                        >
                                            No cost entries yet.{" "}
                                            <Link
                                                href="/production/fan-costing/create"
                                                className="text-blue-600 hover:underline"
                                            >
                                                Create your first entry →
                                            </Link>
                                        </td>
                                    </tr>
                                ) : (
                                    rows.map((row, idx) => (
                                        <tr
                                            key={row.id}
                                            className="hover:bg-gray-50 transition-colors"
                                        >
                                            <td className="px-4 py-3 text-gray-400 text-xs">
                                                {idx + 1}
                                            </td>
                                            <td className="px-4 py-3 font-mono font-medium text-blue-700">
                                                {row.entry_number}
                                            </td>
                                            <td className="px-4 py-3 text-gray-600">
                                                {row.entry_date}
                                            </td>
                                            <td className="px-4 py-3 font-medium text-gray-800">
                                                {row.fan_model || (
                                                    <span className="text-gray-400">
                                                        —
                                                    </span>
                                                )}
                                            </td>
                                            <td className="px-4 py-3 text-right text-gray-700">
                                                {row.quantity}
                                            </td>
                                            <td className="px-4 py-3 text-right font-medium text-gray-800">
                                                {fmt(row.total_cost)}
                                            </td>
                                            <td className="px-4 py-3 text-right font-semibold text-indigo-700">
                                                {fmt(row.unit_cost)}
                                            </td>
                                            <td className="px-4 py-3 text-right text-gray-700">
                                                {fmt(row.selling_price)}
                                            </td>
                                            <td
                                                className={`px-4 py-3 text-right font-semibold ${row.gross_margin_pct >= 0 ? "text-green-700" : "text-red-600"}`}
                                            >
                                                {row.gross_margin_pct != null
                                                    ? `${Number(row.gross_margin_pct).toFixed(1)}%`
                                                    : "-"}
                                            </td>
                                            <td className="px-4 py-3 text-center">
                                                <span
                                                    className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${statusBadge[row.status] ?? ""}`}
                                                >
                                                    {row.status}
                                                </span>
                                            </td>
                                            <td className="px-4 py-3">
                                                <div className="flex items-center justify-center gap-2">
                                                    <Link
                                                        href={`/production/fan-costing/${row.id}`}
                                                        className="text-blue-600 hover:underline text-xs"
                                                    >
                                                        View
                                                    </Link>
                                                    <span className="text-gray-300">
                                                        |
                                                    </span>
                                                    <Link
                                                        href={`/production/fan-costing/${row.id}/edit`}
                                                        className="text-indigo-600 hover:underline text-xs"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <span className="text-gray-300">
                                                        |
                                                    </span>
                                                    <button
                                                        onClick={() =>
                                                            handleDelete(row.id)
                                                        }
                                                        className="text-red-500 hover:underline text-xs"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* Pagination */}
                    {entries?.links && entries.links.length > 3 && (
                        <div className="flex items-center gap-1 px-4 py-3 border-t border-gray-100 bg-gray-50">
                            {entries.links.map((link, i) => (
                                <Link
                                    key={i}
                                    href={link.url ?? "#"}
                                    className={`px-3 py-1 rounded text-xs font-medium border transition-colors
                                        ${link.active ? "bg-blue-600 text-white border-blue-600" : "bg-white text-gray-600 border-gray-200 hover:border-blue-400"}
                                        ${!link.url ? "opacity-40 pointer-events-none" : ""}`}
                                    dangerouslySetInnerHTML={{
                                        __html: link.label,
                                    }}
                                />
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </ManufacturingLayout>
    );
}
