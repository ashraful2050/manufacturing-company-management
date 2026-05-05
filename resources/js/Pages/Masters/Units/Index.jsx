import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ units }) {
    return (
        <ManufacturingLayout header="Units of Measurement">
            <Head title="Units" />
            <ModuleIndex
                title="Units of Measurement"
                createRoute="/masters/units/create"
                createLabel="Add Unit"
                columns={[
                    { key: "name", label: "Unit Name" },
                    { key: "symbol", label: "Symbol" },
                    { key: "unit_type", label: "Type" },
                    {
                        key: "is_active",
                        label: "Status",
                        render: (v) =>
                            v ? (
                                <span className="text-green-600 font-medium">
                                    Active
                                </span>
                            ) : (
                                <span className="text-red-500">Inactive</span>
                            ),
                    },
                ]}
                data={units ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/units/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/units/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this unit?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
