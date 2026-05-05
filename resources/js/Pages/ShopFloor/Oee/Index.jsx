import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ oeeRecords }) {
    const oeeBar = (v) => {
        const pct = parseFloat(v) || 0;
        const color =
            pct >= 85
                ? "bg-green-500"
                : pct >= 65
                  ? "bg-yellow-500"
                  : "bg-red-500";
        return (
            <div className="flex items-center gap-2">
                <div className="w-24 bg-gray-200 rounded-full h-2">
                    <div
                        className={`h-2 rounded-full ${color}`}
                        style={{ width: `${Math.min(pct, 100)}%` }}
                    />
                </div>
                <span className="text-xs font-medium">{pct}%</span>
            </div>
        );
    };
    return (
        <ManufacturingLayout header="OEE Records">
            <Head title="OEE Records" />
            <ModuleIndex
                title="OEE (Overall Equipment Effectiveness)"
                createRoute="/shop-floor/oee/create"
                createLabel="Add OEE Record"
                columns={[
                    { key: "record_date", label: "Date" },
                    { key: "shift_name", label: "Shift" },
                    { key: "machine_name", label: "Machine" },
                    {
                        key: "availability",
                        label: "Availability",
                        render: oeeBar,
                    },
                    {
                        key: "performance",
                        label: "Performance",
                        render: oeeBar,
                    },
                    { key: "quality", label: "Quality", render: oeeBar },
                    { key: "oee", label: "OEE", render: oeeBar },
                ]}
                data={oeeRecords ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/shop-floor/oee/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/shop-floor/oee/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this OEE record?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
