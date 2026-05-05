import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ schedules }) {
    const statusColors = {
        active: "bg-green-100 text-green-700",
        inactive: "bg-gray-100 text-gray-500",
        paused: "bg-yellow-100 text-yellow-700",
    };
    return (
        <ManufacturingLayout header="Maintenance Schedules">
            <Head title="Maintenance Schedules" />
            <ModuleIndex
                title="Maintenance Schedules"
                createRoute="/maintenance/schedules/create"
                createLabel="Create Schedule"
                columns={[
                    { key: "schedule_name", label: "Schedule Name" },
                    { key: "machine_name", label: "Machine" },
                    {
                        key: "maintenance_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    {
                        key: "frequency",
                        label: "Frequency",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "last_done_date", label: "Last Done" },
                    { key: "next_due_date", label: "Next Due" },
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
                data={schedules ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/maintenance/schedules/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/maintenance/schedules/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this schedule?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
