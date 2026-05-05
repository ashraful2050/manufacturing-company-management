import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ salesTargets }) {
    return (
        <ManufacturingLayout header="Sales Targets">
            <Head title="Sales Targets" />
            <ModuleIndex
                title="Sales Targets"
                createRoute="/crm/sales-targets/create"
                createLabel="Set Sales Target"
                columns={[
                    { key: "target_period", label: "Period" },
                    { key: "year", label: "Year" },
                    {
                        key: "target_for",
                        label: "Target For",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "target_name", label: "Name" },
                    {
                        key: "target_amount",
                        label: "Target Amt",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "achieved_amount",
                        label: "Achieved",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "₹0",
                    },
                ]}
                data={salesTargets ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/crm/sales-targets/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/crm/sales-targets/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this target?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
