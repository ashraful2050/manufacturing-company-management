import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ sessions }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        in_progress: "bg-blue-100 text-blue-700",
        completed: "bg-green-100 text-green-700",
        posted: "bg-purple-100 text-purple-700",
    };
    return (
        <ManufacturingLayout header="Stock Count">
            <Head title="Stock Count" />
            <ModuleIndex
                title="Stock Count Sessions"
                createRoute="/inventory/stock-count/create"
                createLabel="Start Stock Count"
                columns={[
                    { key: "session_number", label: "Session #" },
                    { key: "count_date", label: "Count Date" },
                    {
                        key: "count_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "warehouse_name", label: "Warehouse" },
                    { key: "counted_by_name", label: "Counted By" },
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
                data={sessions ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/inventory/stock-count/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/inventory/stock-count/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
