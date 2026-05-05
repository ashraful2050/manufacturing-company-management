import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ documents }) {
    const fileIcon = (ext) => {
        const icons = {
            pdf: "📄",
            doc: "📝",
            docx: "📝",
            xls: "📊",
            xlsx: "📊",
            jpg: "🖼️",
            jpeg: "🖼️",
            png: "🖼️",
            zip: "🗜️",
        };
        return icons[ext?.toLowerCase()] ?? "📁";
    };
    return (
        <ManufacturingLayout header="Document Management">
            <Head title="Documents" />
            <ModuleIndex
                title="Documents"
                createRoute="/documents/files/create"
                createLabel="Upload Document"
                columns={[
                    { key: "title", label: "Title" },
                    {
                        key: "file_type",
                        label: "Type",
                        render: (v) => (
                            <span>
                                {fileIcon(v)} {v?.toUpperCase()}
                            </span>
                        ),
                    },
                    { key: "folder_name", label: "Folder" },
                    {
                        key: "document_category",
                        label: "Category",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "uploaded_by_name", label: "Uploaded By" },
                    {
                        key: "file_size_kb",
                        label: "Size",
                        render: (v) =>
                            v
                                ? v >= 1024
                                    ? `${(v / 1024).toFixed(1)} MB`
                                    : `${v} KB`
                                : "-",
                    },
                    { key: "created_at", label: "Uploaded At" },
                ]}
                data={documents ?? { data: [] }}
                actions={[
                    {
                        label: "Download",
                        href: (r) => `/documents/files/${r.id}/download`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/documents/files/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this document?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
