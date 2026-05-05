import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ opportunities }) {
    const stageColors = {
        prospect: "bg-gray-100 text-gray-600",
        qualified: "bg-blue-100 text-blue-700",
        proposal: "bg-yellow-100 text-yellow-700",
        negotiation: "bg-orange-100 text-orange-700",
        won: "bg-green-100 text-green-700",
        lost: "bg-red-100 text-red-700",
    };
    return (
        <ManufacturingLayout header="Opportunities">
            <Head title="Opportunities" />
            <ModuleIndex
                title="Opportunities"
                createRoute="/crm/opportunities/create"
                createLabel="Add Opportunity"
                columns={[
                    { key: "name", label: "Opportunity" },
                    { key: "customer_name", label: "Customer" },
                    {
                        key: "estimated_value",
                        label: "Est. Value",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "probability",
                        label: "Probability",
                        render: (v) => (v ? `${v}%` : "-"),
                    },
                    { key: "expected_close_date", label: "Expected Close" },
                    {
                        key: "stage",
                        label: "Stage",
                        render: (v) => (
                            <span
                                className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${stageColors[v] ?? ""}`}
                            >
                                {v}
                            </span>
                        ),
                    },
                ]}
                data={opportunities ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/crm/opportunities/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/crm/opportunities/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this opportunity?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
