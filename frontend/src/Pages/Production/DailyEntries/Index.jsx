import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ dailyEntries }) {
    return (
        <ManufacturingLayout header="Daily Production Entries">
            <Head title="Daily Production Entries" />
            <ModuleIndex
                title="Daily Production Entries"
                createRoute="/production/daily-entries/create"
                createLabel="Add Daily Entry"
                columns={[
                    { key: "entry_number", label: "Entry #" },
                    { key: "production_date", label: "Date" },
                    { key: "shift_name", label: "Shift" },
                    { key: "production_line_name", label: "Line" },
                    { key: "product_name", label: "Product" },
                    { key: "planned_qty", label: "Planned" },
                    { key: "actual_qty", label: "Actual" },
                    { key: "rejected_qty", label: "Rejected" },
                ]}
                data={dailyEntries ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/production/daily-entries/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/production/daily-entries/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this entry?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
