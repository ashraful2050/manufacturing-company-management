import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ schedules }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        approved: "bg-green-100 text-green-700",
        in_progress: "bg-blue-100 text-blue-700",
        completed: "bg-purple-100 text-purple-700",
    };
    return (
        <ManufacturingLayout header="Master Production Schedule (MPS)">
            <Head title="MPS" />
            <ModuleIndex
                title="Master Production Schedules"
                createRoute="/production/mps/create"
                createLabel="Create MPS"
                columns={[
                    { key: "mps_number", label: "MPS #" },
                    {
                        key: "period",
                        label: "Period",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "year", label: "Year" },
                    { key: "month", label: "Month" },
                    { key: "from_date", label: "From Date" },
                    { key: "to_date", label: "To Date" },
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
                data={schedules ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/production/mps/${r.id}` },
                    {
                        label: "Edit",
                        href: (r) => `/production/mps/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
