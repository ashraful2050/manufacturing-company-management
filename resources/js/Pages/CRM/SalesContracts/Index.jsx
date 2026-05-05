import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ contracts }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        active: "bg-green-100 text-green-700",
        expired: "bg-red-100 text-red-600",
        terminated: "bg-red-200 text-red-800",
        completed: "bg-blue-100 text-blue-700",
    };
    return (
        <ManufacturingLayout header="Sales Contracts">
            <Head title="Sales Contracts" />
            <ModuleIndex
                title="Sales Contracts"
                createRoute="/crm/sales-contracts/create"
                createLabel="Create Contract"
                columns={[
                    { key: "contract_number", label: "Contract #" },
                    { key: "customer_name", label: "Customer" },
                    { key: "start_date", label: "Start Date" },
                    { key: "end_date", label: "End Date" },
                    {
                        key: "contract_value",
                        label: "Value",
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
                data={contracts ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/crm/sales-contracts/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/crm/sales-contracts/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/crm/sales-contracts/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this contract?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
