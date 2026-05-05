import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ budgets }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        approved: "bg-green-100 text-green-700",
        active: "bg-blue-100 text-blue-700",
        closed: "bg-purple-100 text-purple-700",
    };
    return (
        <ManufacturingLayout header="Budgets">
            <Head title="Budgets" />
            <ModuleIndex
                title="Budgets"
                createRoute="/finance/budgets/create"
                createLabel="Create Budget"
                columns={[
                    { key: "budget_number", label: "Budget #" },
                    { key: "budget_name", label: "Budget Name" },
                    { key: "budget_year", label: "Year" },
                    {
                        key: "budget_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    {
                        key: "total_amount",
                        label: "Total Budget",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "utilized_amount",
                        label: "Utilized",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "₹0",
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
                data={budgets ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/finance/budgets/${r.id}` },
                    {
                        label: "Edit",
                        href: (r) => `/finance/budgets/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
