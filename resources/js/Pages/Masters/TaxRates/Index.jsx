import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ taxRates }) {
    return (
        <ManufacturingLayout header="Tax / VAT Rates">
            <Head title="Tax Rates" />
            <ModuleIndex
                title="Tax & VAT Setup"
                createRoute="/masters/tax-rates/create"
                createLabel="Add Tax Rate"
                columns={[
                    { key: "name", label: "Tax Name" },
                    { key: "tax_type", label: "Type" },
                    { key: "rate", label: "Rate (%)", render: (v) => `${v}%` },
                    { key: "applicable_on", label: "Applicable On" },
                    {
                        key: "is_active",
                        label: "Status",
                        render: (v) =>
                            v ? (
                                <span className="text-green-600">Active</span>
                            ) : (
                                <span className="text-red-500">Inactive</span>
                            ),
                    },
                ]}
                data={taxRates ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/tax-rates/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/tax-rates/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this tax rate?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
