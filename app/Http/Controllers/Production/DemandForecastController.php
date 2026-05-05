<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\DemandForecast;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DemandForecastController extends Controller
{
    public function index()
    {
        $forecasts = DemandForecast::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Production/DemandForecasts/Index', ['forecasts' => $forecasts]);
    }

    public function create()
    {
        return Inertia::render('Production/DemandForecasts/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'forecast_number' => 'nullable|string|max:50',
            'forecast_period' => 'required|string|max:50',
            'year' => 'required|integer',
            'forecast_qty' => 'required|numeric|min:0',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        DemandForecast::create($data);
        return redirect()->route('production.demand-forecasts.index')->with('success', 'DemandForecast created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Production/DemandForecasts/Show', ['demandForecast' => DemandForecast::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Production/DemandForecasts/Edit', ['demandForecast' => DemandForecast::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = DemandForecast::findOrFail($id);
        $data = $request->validate([
            'forecast_number' => 'nullable|string|max:50',
            'forecast_period' => 'required|string|max:50',
            'year' => 'required|integer',
            'forecast_qty' => 'required|numeric|min:0',
        ]);
        $record->update($data);
        return redirect()->route('production.demand-forecasts.index')->with('success', 'DemandForecast updated.');
    }

    public function destroy(string $id)
    {
        DemandForecast::findOrFail($id)->delete();
        return redirect()->route('production.demand-forecasts.index')->with('success', 'DemandForecast deleted.');
    }
}