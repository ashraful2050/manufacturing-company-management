import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ gatePasses }) {
    const typeColors = {
        inward: "bg-green-100 text-green-700",
        outward: "bg-blue-100 text-blue-700",
        returnable: "bg-yellow-100 text-yellow-700",
        non_returnable: "bg-orange-100 text-orange-700",
    };
    const statusColors = {
        pending: "bg-yellow-100 text-yellow-700",
        approved: "bg-green-100 text-green-700",
        completed: "bg-blue-100 text-blue-700",
        cancelled: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Gate Passes">
            <Head title="Gate Passes" />
            <ModuleIndex
                title="Gate Passes"
                createRoute="/logistics/gate-passes/create"
                createLabel="Create Gate Pass"
                columns={[
                    { key: "gate_pass_number", label: "Gate Pass #" },
                    { key: "pass_date", label: "Date" },
                    {
                        key: "pass_type",
                        label: "Type",
                        render: (v) => (
                            <span
                                className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${typeColors[v] ?? ""}`}
                            >
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "party_name", label: "Party" },
                    { key: "vehicle_number", label: "Vehicle #" },
                    { key: "driver_name", label: "Driver" },
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
                data={gatePasses ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/logistics/gate-passes/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/logistics/gate-passes/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
