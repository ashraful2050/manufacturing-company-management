import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ evaluations }) {
    const ratingColors = {
        excellent: "bg-green-100 text-green-700",
        good: "bg-blue-100 text-blue-700",
        average: "bg-yellow-100 text-yellow-700",
        poor: "bg-red-100 text-red-600",
    };
    return (
        <ManufacturingLayout header="Vendor Evaluations">
            <Head title="Vendor Evaluations" />
            <ModuleIndex
                title="Vendor Evaluations"
                createRoute="/procurement/vendor-evaluations/create"
                createLabel="Add Evaluation"
                columns={[
                    { key: "evaluation_number", label: "Evaluation #" },
                    { key: "evaluation_date", label: "Date" },
                    { key: "supplier_name", label: "Supplier" },
                    { key: "evaluation_period", label: "Period" },
                    {
                        key: "total_score",
                        label: "Score",
                        render: (v) => (v ? `${v}/100` : "-"),
                    },
                    {
                        key: "rating",
                        label: "Rating",
                        render: (v) => (
                            <span
                                className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${ratingColors[v] ?? ""}`}
                            >
                                {v}
                            </span>
                        ),
                    },
                ]}
                data={evaluations ?? { data: [] }}
                actions={[
                    {
                        label: "View",
                        href: (r) => `/procurement/vendor-evaluations/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) =>
                            `/procurement/vendor-evaluations/${r.id}/edit`,
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
