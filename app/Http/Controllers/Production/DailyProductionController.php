<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\DailyProduction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DailyProductionController extends Controller
{
    public function index()
    {
        $dailyEntries = DailyProduction::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Production/DailyEntries/Index', ['dailyEntries' => $dailyEntries]);
    }

    public function create()
    {
        return Inertia::render('Production/DailyEntries/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'entry_number' => 'nullable|string|max:50',
            'production_date' => 'required|date',
            'actual_qty' => 'required|numeric|min:0',
            'rejected_qty' => 'nullable|numeric|min:0',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        DailyProduction::create($data);
        return redirect()->route('production.daily-entries.index')->with('success', 'DailyProduction created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Production/DailyEntries/Show', ['dailyProduction' => DailyProduction::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Production/DailyEntries/Edit', ['dailyProduction' => DailyProduction::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = DailyProduction::findOrFail($id);
        $data = $request->validate([
            'entry_number' => 'nullable|string|max:50',
            'production_date' => 'required|date',
            'actual_qty' => 'required|numeric|min:0',
            'rejected_qty' => 'nullable|numeric|min:0',
        ]);
        $record->update($data);
        return redirect()->route('production.daily-entries.index')->with('success', 'DailyProduction updated.');
    }

    public function destroy(string $id)
    {
        DailyProduction::findOrFail($id)->delete();
        return redirect()->route('production.daily-entries.index')->with('success', 'DailyProduction deleted.');
    }
}