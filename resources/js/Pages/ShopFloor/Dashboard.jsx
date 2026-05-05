import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import { Head } from "@inertiajs/react";

export default function Dashboard({ stats }) {
    const kpiCards = [
        {
            label: "Active Machines",
            value: stats?.active_machines ?? 0,
            color: "bg-blue-50 border-blue-200",
            text: "text-blue-700",
        },
        {
            label: "Running Job Cards",
            value: stats?.running_job_cards ?? 0,
            color: "bg-green-50 border-green-200",
            text: "text-green-700",
        },
        {
            label: "Machine Downtimes",
            value: stats?.machine_downtimes_today ?? 0,
            color: "bg-red-50 border-red-200",
            text: "text-red-700",
        },
        {
            label: "Avg OEE Today",
            value: stats?.avg_oee_today ? `${stats.avg_oee_today}%` : "N/A",
            color: "bg-purple-50 border-purple-200",
            text: "text-purple-700",
        },
        {
            label: "Today's Output",
            value: stats?.todays_output ?? 0,
            color: "bg-yellow-50 border-yellow-200",
            text: "text-yellow-700",
        },
        {
            label: "Active Interruptions",
            value: stats?.active_interruptions ?? 0,
            color: "bg-orange-50 border-orange-200",
            text: "text-orange-700",
        },
    ];

    return (
        <ManufacturingLayout header="Shop Floor Dashboard">
            <Head title="Shop Floor Dashboard" />
            <div className="space-y-6">
                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    {kpiCards.map((card) => (
                        <div
                            key={card.label}
                            className={`border rounded-xl p-4 ${card.color}`}
                        >
                            <p className="text-xs text-gray-500 mb-1">
                                {card.label}
                            </p>
                            <p className={`text-2xl font-bold ${card.text}`}>
                                {card.value}
                            </p>
                        </div>
                    ))}
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div className="bg-white border border-gray-200 rounded-xl p-5">
                        <h3 className="text-sm font-semibold text-gray-700 mb-4">
                            Quick Links
                        </h3>
                        <div className="grid grid-cols-2 gap-3">
                            {[
                                {
                                    label: "Shop Floor Entries",
                                    href: "/shop-floor/entries",
                                    color: "bg-blue-600",
                                },
                                {
                                    label: "Machine Downtimes",
                                    href: "/shop-floor/downtime",
                                    color: "bg-red-600",
                                },
                                {
                                    label: "OEE Records",
                                    href: "/shop-floor/oee",
                                    color: "bg-purple-600",
                                },
                                {
                                    label: "Job Cards",
                                    href: "/production/job-cards",
                                    color: "bg-green-600",
                                },
                            ].map((link) => (
                                <a
                                    key={link.label}
                                    href={link.href}
                                    className={`${link.color} text-white text-sm font-medium rounded-lg px-4 py-3 text-center hover:opacity-90 transition`}
                                >
                                    {link.label}
                                </a>
                            ))}
                        </div>
                    </div>

                    <div className="bg-white border border-gray-200 rounded-xl p-5">
                        <h3 className="text-sm font-semibold text-gray-700 mb-4">
                            Production Status
                        </h3>
                        <p className="text-sm text-gray-500 italic">
                            Live production status chart will appear here.
                        </p>
                    </div>
                </div>
            </div>
        </ManufacturingLayout>
    );
}
