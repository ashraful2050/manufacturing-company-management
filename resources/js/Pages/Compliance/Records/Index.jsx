import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ records }) {
    const statusColors = {
        compliant: "bg-green-100 text-green-700",
        non_compliant: "bg-red-100 text-red-600",
        under_review: "bg-yellow-100 text-yellow-700",
        expired: "bg-orange-100 text-orange-700",
    };
    return (
        <ManufacturingLayout header="Compliance Records">
            <Head title="Compliance Records" />
            <ModuleIndex
                title="Compliance Records"
                createRoute="/compliance/records/create"
                createLabel="Add Record"
                columns={[
                    { key: "record_number", label: "Record #" },
                    {
                        key: "compliance_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "regulation_body", label: "Regulation Body" },
                    { key: "compliance_date", label: "Date" },
                    { key: "due_date", label: "Due Date" },
                    { key: "responsible_person_name", label: "Responsible" },
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
                data={records ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/compliance/records/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/compliance/records/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
