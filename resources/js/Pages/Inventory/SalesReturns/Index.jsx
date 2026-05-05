import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ salesReturns }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        approved: "bg-green-100 text-green-700",
        received: "bg-blue-100 text-blue-700",
        credited: "bg-purple-100 text-purple-700",
        cancelled: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Sales Returns">
            <Head title="Sales Returns" />
            <ModuleIndex
                title="Sales Returns"
                createRoute="/inventory/sales-returns/create"
                createLabel="Create Sales Return"
                columns={[
                    { key: "return_number", label: "Return #" },
                    { key: "return_date", label: "Date" },
                    { key: "customer_name", label: "Customer" },
                    { key: "invoice_number", label: "Invoice #" },
                    {
                        key: "total_amount",
                        label: "Amount",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
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
                data={salesReturns ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/inventory/sales-returns/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/inventory/sales-returns/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
