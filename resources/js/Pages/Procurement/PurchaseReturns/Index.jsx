import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ purchaseReturns }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        approved: "bg-green-100 text-green-700",
        dispatched: "bg-blue-100 text-blue-700",
        completed: "bg-green-200 text-green-800",
    };
    return (
        <ManufacturingLayout header="Purchase Returns">
            <Head title="Purchase Returns" />
            <ModuleIndex
                title="Purchase Returns"
                createRoute="/procurement/purchase-returns/create"
                createLabel="Create Purchase Return"
                columns={[
                    { key: "return_number", label: "Return #" },
                    { key: "return_date", label: "Date" },
                    { key: "supplier_name", label: "Supplier" },
                    {
                        key: "return_reason",
                        label: "Reason",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    {
                        key: "total_amount",
                        label: "Amount",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "status",
                        label: "Status",
                        render: (v) => (
                            <span
                                className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${statusColors[v] ?? ""}`}
                            >
                                {v}
                            </span>
                        ),
                    },
                ]}
                data={purchaseReturns ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) =>
                            `/procurement/purchase-returns/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/procurement/purchase-returns/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this return?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
