import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ debitCreditNotes }) {
    const typeColors = {
        debit: "bg-red-100 text-red-700",
        credit: "bg-green-100 text-green-700",
    };
    return (
        <ManufacturingLayout header="Debit / Credit Notes">
            <Head title="Debit/Credit Notes" />
            <ModuleIndex
                title="Debit / Credit Notes"
                createRoute="/procurement/debit-credit-notes/create"
                createLabel="Create Note"
                columns={[
                    { key: "note_number", label: "Note #" },
                    { key: "note_date", label: "Date" },
                    {
                        key: "note_type",
                        label: "Type",
                        render: (v) => (
                            <span
                                className={`px-2 py-0.5 rounded text-xs font-medium capitalize ${typeColors[v] ?? ""}`}
                            >
                                {v}
                            </span>
                        ),
                    },
                    { key: "supplier_name", label: "Supplier" },
                    {
                        key: "amount",
                        label: "Amount",
                        render: (v) =>
                            v ? `₹${Number(v).toLocaleString()}` : "-",
                    },
                    { key: "reason", label: "Reason" },
                    {
                        key: "is_settled",
                        label: "Settled",
                        render: (v) =>
                            v ? (
                                <span className="text-green-600">Yes</span>
                            ) : (
                                <span className="text-red-500">No</span>
                            ),
                    },
                ]}
                data={debitCreditNotes ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) =>
                            `/procurement/debit-credit-notes/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/procurement/debit-credit-notes/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this note?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
