import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ leads }) {
    const statusColors = {
        new: "bg-blue-100 text-blue-700",
        contacted: "bg-yellow-100 text-yellow-700",
        qualified: "bg-green-100 text-green-700",
        unqualified: "bg-gray-100 text-gray-600",
        converted: "bg-purple-100 text-purple-700",
        lost: "bg-red-100 text-red-700",
    };
    return (
        <ManufacturingLayout header="Lead Management">
            <Head title="Leads" />
            <ModuleIndex
                title="Leads"
                createRoute="/crm/leads/create"
                createLabel="Add Lead"
                columns={[
                    { key: "name", label: "Name" },
                    { key: "company_name", label: "Company" },
                    { key: "phone", label: "Phone" },
                    {
                        key: "source",
                        label: "Source",
                        render: (v) => v?.replace("_", " "),
                    },
                    {
                        key: "estimated_value",
                        label: "Est. Value",
                        render: (v) =>
                            v ? `৳${Number(v).toLocaleString()}` : "—",
                    },
                    { key: "follow_up_date", label: "Follow Up" },
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
                data={leads ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/crm/leads/${r.id}` },
                    { label: "Edit", href: (r) => `/crm/leads/${r.id}/edit` },
                ]}
            />
        </ManufacturingLayout>
    );
}
