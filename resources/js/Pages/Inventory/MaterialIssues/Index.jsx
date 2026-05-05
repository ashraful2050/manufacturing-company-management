import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ materialIssues }) {
    const statusColors = {
        draft: "bg-gray-100 text-gray-600",
        approved: "bg-green-100 text-green-700",
        issued: "bg-blue-100 text-blue-700",
        cancelled: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Material Issues">
            <Head title="Material Issues" />
            <ModuleIndex
                title="Material Issues"
                createRoute="/inventory/material-issues/create"
                createLabel="Create Material Issue"
                columns={[
                    { key: "issue_number", label: "Issue #" },
                    { key: "issue_date", label: "Date" },
                    {
                        key: "issue_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "department_name", label: "Department" },
                    { key: "job_card_number", label: "Job Card #" },
                    { key: "issued_by_name", label: "Issued By" },
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
                data={materialIssues ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/inventory/material-issues/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/inventory/material-issues/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
