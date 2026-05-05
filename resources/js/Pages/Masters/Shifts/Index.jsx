import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ shifts }) {
    return (
        <ManufacturingLayout header="Shifts">
            <Head title="Shifts" />
            <ModuleIndex
                title="Shifts"
                createRoute="/masters/shifts/create"
                createLabel="Add Shift"
                columns={[
                    { key: "name", label: "Shift Name" },
                    { key: "code", label: "Code" },
                    { key: "start_time", label: "Start Time" },
                    { key: "end_time", label: "End Time" },
                    { key: "duration_hours", label: "Duration (hrs)" },
                    {
                        key: "is_active",
                        label: "Active",
                        render: (v) =>
                            v ? (
                                <span className="text-green-600 font-medium">
                                    Yes
                                </span>
                            ) : (
                                <span className="text-red-500">No</span>
                            ),
                    },
                ]}
                data={shifts ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/shifts/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/shifts/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this shift?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
