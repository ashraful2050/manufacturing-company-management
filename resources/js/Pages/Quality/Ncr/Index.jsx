import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ ncrList }) {
    const statusColors = {
        open: "bg-red-100 text-red-700",
        under_review: "bg-yellow-100 text-yellow-700",
        capa_issued: "bg-blue-100 text-blue-700",
        closed: "bg-green-100 text-green-700",
    };
    const severityColors = {
        low: "text-green-600",
        medium: "text-yellow-600",
        high: "text-red-600",
        critical: "text-red-800 font-bold",
    };
    return (
        <ManufacturingLayout header="Non-Conformance Reports">
            <Head title="NCR" />
            <ModuleIndex
                title="Non-Conformance Reports (NCR)"
                createRoute="/quality/ncr/create"
                createLabel="Raise NCR"
                columns={[
                    { key: "ncr_number", label: "NCR #" },
                    { key: "ncr_date", label: "Date" },
                    {
                        key: "nc_type",
                        label: "Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    {
                        key: "description",
                        label: "Description",
                        render: (v) =>
                            v && v.length > 50 ? v.slice(0, 50) + "…" : v,
                    },
                    {
                        key: "severity",
                        label: "Severity",
                        render: (v) => (
                            <span
                                className={`capitalize ${severityColors[v] ?? ""}`}
                            >
                                {v}
                            </span>
                        ),
                    },
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
                data={ncrList ?? { data: [] }}
                actions={[
                    { label: "View", href: (r) => `/quality/ncr/${r.id}` },
                    { label: "Edit", href: (r) => `/quality/ncr/${r.id}/edit` },
                ]}
            />
        </ManufacturingLayout>
    );
}
