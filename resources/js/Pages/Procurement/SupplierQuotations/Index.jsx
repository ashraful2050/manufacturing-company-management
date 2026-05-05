import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ supplierQuotations }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        submitted: "bg-blue-100 text-blue-700",
        approved: "bg-green-100 text-green-700",
        rejected: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Supplier Quotations">
            <Head title="Supplier Quotations" />
            <ModuleIndex
                title="Supplier Quotations"
                createRoute="/procurement/supplier-quotations/create"
                createLabel="Add Quotation"
                columns={[
                    { key: "quotation_number", label: "Quotation #" },
                    { key: "quotation_date", label: "Date" },
                    { key: "supplier_name", label: "Supplier" },
                    { key: "rfq_number", label: "RFQ #" },
                    {
                        key: "total_amount",
                        label: "Total Amount",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    { key: "valid_until", label: "Valid Until" },
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
                data={supplierQuotations ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/procurement/supplier-quotations/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) =>
                            `/procurement/supplier-quotations/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
