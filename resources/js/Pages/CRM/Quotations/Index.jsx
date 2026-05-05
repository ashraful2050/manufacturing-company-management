import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ quotations }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        sent: "bg-blue-100 text-blue-700",
        accepted: "bg-green-100 text-green-700",
        rejected: "bg-red-100 text-red-700",
        expired: "bg-orange-100 text-orange-700",
        converted: "bg-purple-100 text-purple-700",
    };
    return (
        <ManufacturingLayout header="Quotation Management">
            <Head title="Quotations" />
            <ModuleIndex
                title="Quotations"
                createRoute="/crm/quotations/create"
                createLabel="New Quotation"
                columns={[
                    { key: "quotation_number", label: "Quotation #" },
                    { key: "quotation_date", label: "Date" },
                    { key: "valid_until", label: "Valid Until" },
                    {
                        key: "net_amount",
                        label: "Amount",
                        render: (v) => `৳${Number(v).toLocaleString()}`,
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
                data={quotations ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/crm/quotations/${r.id}` },
                    {
                        label: "Edit",
                        href: (r) => `/crm/quotations/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
