import { Link, usePage } from "@inertiajs/react";
import { useState } from "react";

const navItems = [
    { href: "/superadmin", label: "Dashboard", icon: "📊" },
    { href: "/superadmin/companies", label: "Companies", icon: "🏢" },
    { href: "/superadmin/plans", label: "Plans & Pricing", icon: "💳" },
    { href: "/superadmin/admin-users", label: "Admin Users", icon: "👥" },
];

export default function SuperAdminLayout({ children, title }) {
    const { auth } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const currentPath = window.location.pathname;

    return (
        <div className="min-h-screen bg-slate-50 flex">
            {/* Sidebar */}
            <aside
                className={`fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-900 to-slate-800 transform transition-transform duration-300 ${sidebarOpen ? "translate-x-0" : "-translate-x-full"} lg:translate-x-0 lg:static lg:inset-0`}
            >
                <div className="flex flex-col h-full">
                    {/* Logo */}
                    <div className="flex items-center gap-3 px-6 py-5 border-b border-slate-700">
                        <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center">
                            <span className="text-white font-black text-lg">
                                F
                            </span>
                        </div>
                        <div>
                            <div className="text-white font-black text-sm">
                                FanERP
                            </div>
                            <div className="text-orange-400 text-xs">
                                Super Admin
                            </div>
                        </div>
                    </div>

                    {/* Navigation */}
                    <nav className="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                        {navItems.map((item) => {
                            const isActive =
                                item.href === "/superadmin"
                                    ? currentPath === "/superadmin"
                                    : currentPath.startsWith(item.href);
                            return (
                                <Link
                                    key={item.href}
                                    href={item.href}
                                    className={`flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all ${
                                        isActive
                                            ? "bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg"
                                            : "text-slate-400 hover:text-white hover:bg-slate-700"
                                    }`}
                                >
                                    <span className="text-base">
                                        {item.icon}
                                    </span>
                                    {item.label}
                                </Link>
                            );
                        })}
                    </nav>

                    {/* User info */}
                    <div className="px-4 py-4 border-t border-slate-700">
                        <div className="flex items-center gap-3 px-3 py-3 rounded-xl bg-slate-700/50">
                            <div className="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-red-400 flex items-center justify-center text-white text-xs font-bold">
                                {auth?.user?.name?.charAt(0) || "S"}
                            </div>
                            <div className="flex-1 min-w-0">
                                <div className="text-white text-xs font-semibold truncate">
                                    {auth?.user?.name}
                                </div>
                                <div className="text-orange-400 text-xs">
                                    Super Admin
                                </div>
                            </div>
                        </div>
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            className="mt-2 w-full flex items-center gap-2 px-3 py-2 text-slate-400 hover:text-white text-xs transition-colors rounded-lg hover:bg-slate-700"
                        >
                            <svg
                                className="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                            Sign Out
                        </Link>
                    </div>
                </div>
            </aside>

            {/* Mobile overlay */}
            {sidebarOpen && (
                <div
                    className="fixed inset-0 z-40 bg-black/50 lg:hidden"
                    onClick={() => setSidebarOpen(false)}
                />
            )}

            {/* Main content */}
            <div className="flex-1 flex flex-col min-w-0 lg:ml-0">
                {/* Top bar */}
                <header className="bg-white border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between sticky top-0 z-30">
                    <div className="flex items-center gap-3">
                        <button
                            onClick={() => setSidebarOpen(!sidebarOpen)}
                            className="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors"
                        >
                            <svg
                                className="w-5 h-5 text-gray-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </button>
                        {title && (
                            <h1 className="text-xl font-black text-gray-900">
                                {title}
                            </h1>
                        )}
                    </div>
                    <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-red-400 flex items-center justify-center text-white text-xs font-bold">
                            {auth?.user?.name?.charAt(0) || "S"}
                        </div>
                    </div>
                </header>

                {/* Page content */}
                <main className="flex-1 p-4 sm:p-6 lg:p-8">{children}</main>
            </div>
        </div>
    );
}
