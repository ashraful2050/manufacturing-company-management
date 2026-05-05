import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ currencies }) {
    return (
        <ManufacturingLayout header="Currencies">
            <Head title="Currencies" />
            <ModuleIndex
                title="Currency Setup"
                createRoute="/masters/currencies/create"
                createLabel="Add Currency"
                columns={[
                    { key: "name", label: "Currency Name" },
                    { key: "code", label: "Code" },
                    { key: "symbol", label: "Symbol" },
                    { key: "exchange_rate", label: "Exchange Rate" },
                    {
                        key: "is_base",
                        label: "Base",
                        render: (v) =>
                            v ? (
                                <span className="text-blue-600 font-medium">
                                    Base
                                </span>
                            ) : (
                                "—"
                            ),
                    },
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
                data={currencies ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/currencies/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/currencies/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this currency?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
