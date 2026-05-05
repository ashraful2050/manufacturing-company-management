import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ storeRequisitions }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        pending: "bg-yellow-100 text-yellow-700",
        approved: "bg-green-100 text-green-700",
        issued: "bg-blue-100 text-blue-700",
        rejected: "bg-red-100 text-red-700",
    };
    return (
        <ManufacturingLayout header="Store Requisitions">
            <Head title="Store Requisitions" />
            <ModuleIndex
                title="Store Requisitions"
                createRoute="/inventory/store-requisitions/create"
                createLabel="New Requisition"
                columns={[
                    { key: "sr_number", label: "SR #" },
                    { key: "req_date", label: "Date" },
                    {
                        key: "req_type",
                        label: "Type",
                        render: (v) => v?.replace("_", " "),
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
                data={storeRequisitions ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/inventory/store-requisitions/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) =>
                            `/inventory/store-requisitions/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
