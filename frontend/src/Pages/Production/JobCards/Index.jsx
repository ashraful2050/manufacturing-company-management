import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ jobCards }) {
    const statusColors = {
        pending: "bg-gray-100 text-gray-600",
        in_progress: "bg-blue-100 text-blue-700",
        completed: "bg-green-100 text-green-700",
        paused: "bg-yellow-100 text-yellow-700",
        cancelled: "bg-red-100 text-red-700",
    };
    return (
        <ManufacturingLayout header="Job Cards">
            <Head title="Job Cards" />
            <ModuleIndex
                title="Job Cards"
                createRoute="/production/job-cards/create"
                createLabel="Create Job Card"
                columns={[
                    { key: "card_number", label: "Card #" },
                    { key: "card_date", label: "Date" },
                    { key: "operation_name", label: "Operation" },
                    { key: "planned_qty", label: "Planned Qty" },
                    { key: "produced_qty", label: "Produced Qty" },
                    { key: "rejected_qty", label: "Rejected Qty" },
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
                data={jobCards ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/production/job-cards/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/production/job-cards/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
