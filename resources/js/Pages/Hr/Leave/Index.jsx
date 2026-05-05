import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ leaveRequests }) {
    const statusColors = {
        pending: "bg-yellow-100 text-yellow-700",
        approved: "bg-green-100 text-green-700",
        rejected: "bg-red-100 text-red-600",
        cancelled: "bg-gray-100 text-gray-500",
    };
    return (
        <ManufacturingLayout header="Leave Requests">
            <Head title="Leave Requests" />
            <ModuleIndex
                title="Leave Requests"
                createRoute="/hr/leave/create"
                createLabel="Apply Leave"
                columns={[
                    { key: "leave_number", label: "Leave #" },
                    { key: "employee_name", label: "Employee" },
                    { key: "leave_type_name", label: "Leave Type" },
                    { key: "from_date", label: "From Date" },
                    { key: "to_date", label: "To Date" },
                    {
                        key: "total_days",
                        label: "Days",
                        render: (v) => `${v} day(s)`,
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
                data={leaveRequests ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/hr/leave/${r.id}` },
                    { label: "Edit", href: (r) => `/hr/leave/${r.id}/edit` },
                ]}
            />
        </ManufacturingLayout>
    );
}
