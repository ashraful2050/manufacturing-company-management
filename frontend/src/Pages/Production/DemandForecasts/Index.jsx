import ManufacturingLayout from "@/Layouts/ManufacturingLayout";
import ModuleIndex from "@/Components/ModuleIndex";
import { Head } from "@inertiajs/react";

export default function Index({ forecasts }) {
    return (
        <ManufacturingLayout header="Demand Forecasts">
            <Head title="Demand Forecasts" />
            <ModuleIndex
                title="Demand Forecasts"
                createRoute="/production/demand-forecasts/create"
                createLabel="Add Forecast"
                columns={[
                    { key: "forecast_number", label: "Forecast #" },
                    {
                        key: "forecast_period",
                        label: "Period",
                        render: (v) => (
                            <span className="capitalize">
                                {v?.replace("_", " ")}
                            </span>
                        ),
                    },
                    { key: "year", label: "Year" },
                    { key: "month", label: "Month" },
                    { key: "product_name", label: "Product" },
                    { key: "forecast_qty", label: "Forecast Qty" },
                    { key: "actual_qty", label: "Actual Qty" },
                ]}
                data={forecasts ?? { data: [] }}
                actions={[
                    {
                        label: "Edit",
                        href: (r) =>
                            `/production/demand-forecasts/${r.id}/edit`,
                    },
                    {
                        label: "Delete",
                        href: (r) => `/production/demand-forecasts/${r.id}`,
                        method: "delete",
                        className: "text-red-600 hover:underline",
                        confirm: "Delete this forecast?",
                    },
                ]}
            />
        </ManufacturingLayout>
    );
}
