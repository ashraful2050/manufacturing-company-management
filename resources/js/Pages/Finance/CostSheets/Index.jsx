import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ costSheets }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        approved: "bg-green-100 text-green-700",
        archived: "bg-purple-100 text-purple-700",
    };
    return (
        <ManufacturingLayout header="Cost Sheets">
            <Head title="Cost Sheets" />
            <ModuleIndex
                title="Cost Sheets"
                createRoute="/finance/cost-sheets/create"
                createLabel="Create Cost Sheet"
                columns={[
                    { key: "sheet_number", label: "Sheet #" },
                    { key: "sheet_date", label: "Date" },
                    { key: "product_name", label: "Product" },
                    {
                        key: "cost_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    {
                        key: "total_material_cost",
                        label: "Material Cost",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "total_labour_cost",
                        label: "Labour Cost",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "total_overhead_cost",
                        label: "Overhead",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "total_cost",
                        label: "Total Cost",
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
                data={costSheets ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/finance/cost-sheets/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/finance/cost-sheets/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
