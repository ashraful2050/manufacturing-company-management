import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ transporters }) {
    return (
        <ManufacturingLayout header="Transporters">
            <Head title="Transporters" />
            <ModuleIndex
                title="Transporters"
                createRoute="/masters/transporters/create"
                createLabel="Add Transporter"
                columns={[
                    { key: "name", label: "Name" },
                    { key: "code", label: "Code" },
                    { key: "contact_person", label: "Contact Person" },
                    { key: "phone", label: "Phone" },
                    { key: "email", label: "Email" },
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
                data={transporters ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/masters/transporters/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/masters/transporters/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this transporter?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
