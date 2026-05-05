import { Link } from "@inertiajs/react";

/**
 * Generic reusable module index page.
 * Props:
 *   title        - Page heading
 *   createRoute  - Route name for create button (optional)
 *   createLabel  - Label for create button (default: "Add New")
 *   columns      - Array of { key, label } for the table
 *   data         - Paginated data object { data: [], links: [], meta: {} }
 *   filters      - Array of filter JSX elements (optional)
 *   actions      - Array of { label, route(record) } action definitions (optional)
 */
export default function ModuleIndex({
    title,
    createRoute,
    createLabel = "Add New",
    columns = [],
    data = { data: [] },
    actions = [],
}) {
    const records = Array.isArray(data) ? data : (data.data ?? []);

    return (
        <div>
            {/* Header */}
            <div className="flex items-center justify-between mb-6">
                <h1 className="text-2xl font-bold text-gray-800">{title}</h1>
                {createRoute && (
                    <Link
                        href={createRoute}
                        className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition"
                    >
                        <svg
                            className="w-4 h-4 mr-1.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        {createLabel}
                    </Link>
                )}
            </div>

            {/* Table */}
            <div className="bg-white rounded-lg shadow overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                {columns.map((col) => (
                                    <th
                                        key={col.key}
                                        className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        {col.label}
                                    </th>
                                ))}
                                {actions.length > 0 && (
                                    <th className="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                )}
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {records.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan={
                                            columns.length +
                                            (actions.length ? 2 : 1)
                                        }
                                        className="px-4 py-8 text-center text-gray-400"
                                    >
                                        No records found.
                                    </td>
                                </tr>
                            ) : (
                                records.map((record, idx) => (
                                    <tr
                                        key={record.id || idx}
                                        className="hover:bg-gray-50"
                                    >
                                        <td className="px-4 py-3 text-sm text-gray-500">
                                            {idx + 1}
                                        </td>
                                        {columns.map((col) => (
                                            <td
                                                key={col.key}
                                                className="px-4 py-3 text-sm text-gray-800"
                                            >
                                                {col.render
                                                    ? col.render(
                                                          record[col.key],
                                                          record,
                                                      )
                                                    : (record[col.key] ?? "—")}
                                            </td>
                                        ))}
                                        {actions.length > 0 && (
                                            <td className="px-4 py-3 text-right space-x-2">
                                                {actions.map((action, aIdx) => (
                                                    <Link
                                                        key={aIdx}
                                                        href={action.href(
                                                            record,
                                                        )}
                                                        method={
                                                            action.method ??
                                                            "get"
                                                        }
                                                        as={
                                                            action.method &&
                                                            action.method !==
                                                                "get"
                                                                ? "button"
                                                                : "a"
                                                        }
                                                        className={`text-xs font-medium px-2 py-1 rounded ${action.className ?? "text-blue-600 hover:underline"}`}
                                                        onClick={
                                                            action.confirm
                                                                ? (e) => {
                                                                      if (
                                                                          !confirm(
                                                                              action.confirm,
                                                                          )
                                                                      )
                                                                          e.preventDefault();
                                                                  }
                                                                : undefined
                                                        }
                                                    >
                                                        {action.label}
                                                    </Link>
                                                ))}
                                            </td>
                                        )}
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
                {/* Pagination */}
                {data.links && (
                    <div className="px-4 py-3 border-t border-gray-200 flex justify-end space-x-1">
                        {data.links.map((link, idx) => (
                            <Link
                                key={idx}
                                href={link.url ?? "#"}
                                className={`px-3 py-1 text-sm rounded ${link.active ? "bg-blue-600 text-white" : "text-gray-600 hover:bg-gray-100"} ${!link.url ? "opacity-40 pointer-events-none" : ""}`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                )}
            </div>
        </div>
    );
}
