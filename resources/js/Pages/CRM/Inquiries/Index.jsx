import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ inquiries }) {
    const statusColors = {
        new: "bg-blue-100 text-blue-700",
        in_progress: "bg-yellow-100 text-yellow-700",
        converted: "bg-green-100 text-green-700",
        closed: "bg-gray-100 text-gray-500",
    };
    return (
        <ManufacturingLayout header="Customer Inquiries">
            <Head title="Customer Inquiries" />
            <ModuleIndex
                title="Customer Inquiries"
                createRoute="/crm/inquiries/create"
                createLabel="Add Inquiry"
                columns={[
                    { key: "inquiry_number", label: "Inquiry #" },
                    { key: "inquiry_date", label: "Date" },
                    { key: "customer_name", label: "Customer / Contact" },
                    {
                        key: "channel",
                        label: "Channel",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "subject", label: "Subject" },
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
                data={inquiries ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/crm/inquiries/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/crm/inquiries/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this inquiry?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
