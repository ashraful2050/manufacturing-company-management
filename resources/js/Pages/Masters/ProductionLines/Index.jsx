import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ productionLines }) {
    return (
        <ManufacturingLayout header="Production Lines">
            <Head title="Production Lines" />
            <ModuleIndex
                title="Production Lines"
                createRoute="/masters/production-lines/create"
                createLabel="Add Production Line"
                columns={[
                    { key: "name", label: "Name" },
                    { key: "code", label: "Code" },
                    { key: "line_type", label: "Type" },
                    { key: "capacity_per_shift", label: "Capacity / Shift" },
                    { key: "no_of_machines", label: "Machines" },
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
                data={productionLines ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/production-lines/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/production-lines/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this production line?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
