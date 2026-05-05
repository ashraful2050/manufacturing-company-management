import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ territories }) {
    return (
        <ManufacturingLayout header="Territories">
            <Head title="Territories" />
            <ModuleIndex
                title="Territories"
                createRoute="/crm/territories/create"
                createLabel="Add Territory"
                columns={[
                    { key: "name", label: "Territory Name" },
                    { key: "code", label: "Code" },
                    {
                        key: "level",
                        label: "Level",
                        render: (v) => <span className="capitalize">{v}</span>,
                    },
                    { key: "parent_name", label: "Parent Territory" },
                    { key: "manager_name", label: "Manager" },
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
                data={territories ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) => `/crm/territories/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/crm/territories/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this territory?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
