import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ workOrders }) {
    const statusColors = {
        open: "bg-blue-100 text-blue-700",
        in_progress: "bg-yellow-100 text-yellow-700",
        completed: "bg-green-100 text-green-700",
        cancelled: "bg-red-100 text-red-600",
        on_hold: "bg-gray-100 text-gray-600",
    };
    const priorityColors = {
        low: "text-gray-500",
        medium: "text-blue-600",
        high: "text-orange-600",
        critical: "text-red-700 font-bold",
    };
    return (
        <ManufacturingLayout header="Maintenance Work Orders">
            <Head title="Maintenance Work Orders" />
            <ModuleIndex
                title="Maintenance Work Orders"
                createRoute="/maintenance/work-orders/create"
                createLabel="Create Work Order"
                columns={[
                    { key: "wo_number", label: "WO #" },
                    { key: "wo_date", label: "Date" },
                    { key: "machine_name", label: "Machine" },
                    {
                        key: "work_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    {
                        key: "priority",
                        label: "Priority",
                        render: (v) => (
                            <span
                                className={`capitalize ${priorityColors[v] ?? ""}`}
                            >
                                {v}
                            </span>
                        ),
                    },
                    { key: "assigned_to_name", label: "Assigned To" },
                    {
                        key: "status",
                        label: "Status",
                        render: (v) => (
                            <span
                                className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${statusColors[v] ?? ""}`}
                            >
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                ]}
                data={workOrders ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/maintenance/work-orders/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/maintenance/work-orders/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
