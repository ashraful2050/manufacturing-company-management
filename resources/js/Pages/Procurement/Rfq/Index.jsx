import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ rfqs }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        sent: "bg-blue-100 text-blue-700",
        received: "bg-green-100 text-green-700",
        compared: "bg-purple-100 text-purple-700",
        closed: "bg-red-100 text-red-700",
    };
    return (
        <ManufacturingLayout header="Request for Quotation (RFQ)">
            <Head title="RFQ" />
            <ModuleIndex
                title="Request For Quotation"
                createRoute="/procurement/rfq/create"
                createLabel="Create RFQ"
                columns={[
                    { key: "rfq_number", label: "RFQ #" },
                    { key: "rfq_date", label: "Date" },
                    { key: "response_due_date", label: "Due Date" },
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
                data={rfqs ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/procurement/rfq/${r.id}` },
                    {
                        label: "Edit",
                        href: (r) => `/procurement/rfq/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
