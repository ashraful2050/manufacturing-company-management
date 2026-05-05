import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ entries }) {
    return (
        <ManufacturingLayout header="Shop Floor Entries">
            <Head title="Shop Floor Entries" />
            <ModuleIndex
                title="Shop Floor Entries"
                createRoute="/shop-floor/entries/create"
                createLabel="Add Entry"
                columns={[
                    { key: "entry_number", label: "Entry #" },
                    { key: "entry_date", label: "Date" },
                    { key: "shift_name", label: "Shift" },
                    { key: "production_line_name", label: "Line" },
                    { key: "machine_name", label: "Machine" },
                    { key: "operator_name", label: "Operator" },
                    { key: "actual_qty", label: "Actual Qty" },
                    { key: "rejected_qty", label: "Rejected Qty" },
                ]}
                data={entries ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/shop-floor/entries/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/shop-floor/entries/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this entry?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
