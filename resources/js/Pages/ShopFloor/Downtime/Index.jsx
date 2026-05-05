import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ downtimes }) {
    const statusColors = {
        ongoing: "bg-red-100 text-red-700",
        resolved: "bg-green-100 text-green-700",
        pending: "bg-yellow-100 text-yellow-700",
    };
    return (
        <ManufacturingLayout header="Machine Downtimes">
            <Head title="Machine Downtimes" />
            <ModuleIndex
                title="Machine Downtimes"
                createRoute="/shop-floor/downtime/create"
                createLabel="Log Downtime"
                columns={[
                    { key: "downtime_number", label: "Downtime #" },
                    { key: "machine_name", label: "Machine" },
                    { key: "start_time", label: "Start Time" },
                    { key: "end_time", label: "End Time" },
                    { key: "duration_minutes", label: "Duration (min)" },
                    {
                        key: "downtime_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
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
                data={downtimes ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/shop-floor/downtime/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/shop-floor/downtime/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this downtime record?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
