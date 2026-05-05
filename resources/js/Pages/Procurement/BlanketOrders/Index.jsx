import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ blanketOrders }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        active: "bg-green-100 text-green-700",
        closed: "bg-blue-100 text-blue-700",
        cancelled: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Blanket Purchase Orders">
            <Head title="Blanket Purchase Orders" />
            <ModuleIndex
                title="Blanket Purchase Orders"
                createRoute="/procurement/blanket-orders/create"
                createLabel="Create Blanket PO"
                columns={[
                    { key: "bpo_number", label: "BPO #" },
                    { key: "bpo_date", label: "Date" },
                    { key: "supplier_name", label: "Supplier" },
                    {
                        key: "total_value",
                        label: "Total Value",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "amount_released",
                        label: "Released",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "₹0",
                    },
                    { key: "valid_from", label: "Valid From" },
                    { key: "valid_to", label: "Valid To" },
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
                data={blanketOrders ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/procurement/blanket-orders/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/procurement/blanket-orders/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
