import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ parameters }) {
    return (
        <ManufacturingLayout header="QC Parameters">
            <Head title="QC Parameters" />
            <ModuleIndex
                title="Quality Control Parameters"
                createRoute="/quality/parameters/create"
                createLabel="Add Parameter"
                columns={[
                    { key: "name", label: "Parameter" },
                    { key: "code", label: "Code" },
                    {
                        key: "parameter_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "uom", label: "UOM" },
                    { key: "min_value", label: "Min Value" },
                    { key: "max_value", label: "Max Value" },
                    { key: "target_value", label: "Target Value" },
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
                data={parameters ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/quality/parameters/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/quality/parameters/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this parameter?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
