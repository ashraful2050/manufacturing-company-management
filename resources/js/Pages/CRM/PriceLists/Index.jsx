import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ priceLists }) {
    return (
        <ManufacturingLayout header="Price Lists">
            <Head title="Price Lists" />
            <ModuleIndex
                title="Price Lists"
                createRoute="/crm/price-lists/create"
                createLabel="Create Price List"
                columns={[
                    { key: "name", label: "Name" },
                    {
                        key: "customer_type",
                        label: "Customer Type",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "currency_code", label: "Currency" },
                    { key: "effective_from", label: "Effective From" },
                    { key: "effective_to", label: "Effective To" },
                    {
                        key: "is_active",
                        label: "Active",
                        render: (v) =>
                            v ? (
                                <span className="text-green-600 font-medium">
                                    Yes
                                </span>
                            ) : (
                                <span className="text-red-500">No</span>
                            ),
                    },
                ]}
                data={priceLists ?? { data: [] }}
                actions={[
                    {
                        label: "View Items",
                        href: (r) => `/crm/price-lists/${r.id}`,
                    },
                    {
                        label: "Edit",
                        href: (r) => `/crm/price-lists/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/crm/price-lists/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this price list?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
