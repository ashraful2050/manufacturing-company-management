import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ mrpRuns }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        running: "bg-yellow-100 text-yellow-700",
        completed: "bg-green-100 text-green-700",
        failed: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Material Requirements Planning (MRP)">
            <Head title="MRP Runs" />
            <ModuleIndex
                title="MRP Runs"
                createRoute="/production/mrp/create"
                createLabel="Run MRP"
                columns={[
                    { key: "run_number", label: "Run #" },
                    { key: "run_date", label: "Run Date" },
                    {
                        key: "run_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "from_date", label: "From Date" },
                    { key: "to_date", label: "To Date" },
                    { key: "total_planned_orders", label: "Planned Orders" },
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
                data={mrpRuns ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/production/mrp/${r.id}` },
                    {
                        label: "Edit",
                        href: (r) => `/production/mrp/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
