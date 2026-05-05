import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ binLocations }) {
    return (
        <ManufacturingLayout header="Bin Locations">
            <Head title="Bin Locations" />
            <ModuleIndex
                title="Bin Locations"
                createRoute="/inventory/bin-locations/create"
                createLabel="Add Bin Location"
                columns={[
                    { key: "bin_code", label: "Bin Code" },
                    { key: "warehouse_name", label: "Warehouse" },
                    { key: "zone", label: "Zone" },
                    { key: "row", label: "Row" },
                    { key: "rack", label: "Rack" },
                    { key: "level", label: "Level" },
                    { key: "max_capacity", label: "Max Capacity" },
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
                data={binLocations ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/inventory/bin-locations/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/inventory/bin-locations/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this bin location?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
