import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ attendances }) {
    const statusColors = {
        present: "bg-green-100 text-green-700",
        absent: "bg-red-100 text-red-600",
        half_day: "bg-yellow-100 text-yellow-700",
        on_leave: "bg-blue-100 text-blue-700",
        holiday: "bg-purple-100 text-purple-700",
        work_from_home: "bg-teal-100 text-teal-700",
    };
    return (
        <ManufacturingLayout header="Attendance">
            <Head title="Attendance" />
            <ModuleIndex
                title="Attendance Records"
                createRoute="/hr/attendance/create"
                createLabel="Mark Attendance"
                columns={[
                    { key: "attendance_date", label: "Date" },
                    { key: "employee_name", label: "Employee" },
                    { key: "employee_code", label: "Emp Code" },
                    { key: "shift_name", label: "Shift" },
                    { key: "check_in", label: "Check In" },
                    { key: "check_out", label: "Check Out" },
                    { key: "working_hours", label: "Hours" },
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
                data={attendances ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/hr/attendance/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/hr/attendance/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this attendance record?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
