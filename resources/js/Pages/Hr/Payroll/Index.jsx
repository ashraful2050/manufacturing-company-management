import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ payrolls }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        approved: "bg-blue-100 text-blue-700",
        paid: "bg-green-100 text-green-700",
        cancelled: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Payroll">
            <Head title="Payroll" />
            <ModuleIndex
                title="Payroll Records"
                createRoute="/hr/payroll/create"
                createLabel="Generate Payroll"
                columns={[
                    { key: "payroll_number", label: "Payroll #" },
                    { key: "employee_name", label: "Employee" },
                    { key: "month", label: "Month" },
                    { key: "year", label: "Year" },
                    {
                        key: "gross_salary",
                        label: "Gross",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "total_deductions",
                        label: "Deductions",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    {
                        key: "net_salary",
                        label: "Net Pay",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
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
                data={payrolls ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/hr/payroll/${r.id}` },
                    { label: "Edit", href: (r) => `/hr/payroll/${r.id}/edit` },
                ]}
            />
        </ManufacturingLayout>
    );
}
