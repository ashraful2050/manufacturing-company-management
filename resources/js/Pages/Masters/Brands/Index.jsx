import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ brands }) {
    return (
        <ManufacturingLayout header="Brands">
            <Head title="Brands" />
            <ModuleIndex
                title="Brands"
                createRoute="/masters/brands/create"
                createLabel="Add Brand"
                columns={[
                    { key: "name", label: "Brand Name" },
                    { key: "code", label: "Code" },
                    { key: "country_of_origin", label: "Country of Origin" },
                    { key: "website", label: "Website" },
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
                data={brands ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/brands/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/brands/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this brand?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
