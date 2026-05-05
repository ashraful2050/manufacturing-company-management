import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ machines }) {
    return (
        <ManufacturingLayout header="Machines & Equipment">
            <Head title="Machines" />
            <ModuleIndex
                title="Machine Registration"
                createRoute="/masters/machines/create"
                createLabel="Register Machine"
                columns={[
                    { key: "machine_code", label: "Code" },
                    { key: "name", label: "Machine Name" },
                    { key: "machine_type", label: "Type" },
                    { key: "make", label: "Make" },
                    { key: "model", label: "Model" },
                    { key: "capacity_per_hour", label: "Capacity/Hr" },
                    { key: "next_maintenance_date", label: "Next PM" },
                    {
                        key: "status",
                        label: "Status",
                        render: (v) => {
                            const colors = {
                                active: "text-green-600",
                                idle: "text-yellow-600",
                                under_maintenance: "text-blue-600",
                                breakdown: "text-red-600",
                                retired: "text-gray-400",
                            };
                            return (
                                <span
                                    className={`font-medium capitalize ${colors[v] ?? ""}`}
                                >
                                    {v?.replace("_", " ")}
                                </span>
                            );
                        },
                    },
                ]}
                data={machines ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/machines/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/machines/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this machine?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
