import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ capaList }) {
    const statusColors = {
        open: "bg-red-100 text-red-700",
        in_progress: "bg-blue-100 text-blue-700",
        completed: "bg-green-100 text-green-700",
        verified: "bg-purple-100 text-purple-700",
        closed: "bg-gray-100 text-gray-600",
    };
    return (
        <ManufacturingLayout header="CAPA (Corrective & Preventive Actions)">
            <Head title="CAPA" />
            <ModuleIndex
                title="Corrective & Preventive Actions (CAPA)"
                createRoute="/quality/capa/create"
                createLabel="Add CAPA"
                columns={[
                    { key: "capa_number", label: "CAPA #" },
                    { key: "capa_date", label: "Date" },
                    {
                        key: "capa_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    {
                        key: "root_cause",
                        label: "Root Cause",
                        render: (v) =>
                            v && v.length > 50 ? v.slice(0, 50) + "…" : v,
                    },
                    { key: "assigned_to_name", label: "Assigned To" },
                    { key: "due_date", label: "Due Date" },
                    {
                        key: "status",
                        label: "Status",
                        render: (v) => (
                            <span
                                className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${statusColors[v] ?? ""}`}
                            >
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                ]}
                data={capaList ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/quality/capa/${r.id}` },
                    {
                        label: "Edit",
                        href: (r) => `/quality/capa/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
