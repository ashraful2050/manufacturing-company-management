<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\MasterProductionSchedule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MpsController extends Controller
{
    public function index()
    {
        $schedules = MasterProductionSchedule::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Production/Mps/Index', ['schedules' => $schedules]);
    }

    public function create()
    {
        return Inertia::render('Production/Mps/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mps_number' => 'nullable|string|max:50',
            'period' => 'required|string|max:50',
            'year' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        MasterProductionSchedule::create($data);
        return redirect()->route('production.mps.index')->with('success', 'MasterProductionSchedule created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Production/Mps/Show', ['masterProductionSchedule' => MasterProductionSchedule::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Production/Mps/Edit', ['masterProductionSchedule' => MasterProductionSchedule::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = MasterProductionSchedule::findOrFail($id);
        $data = $request->validate([
            'mps_number' => 'nullable|string|max:50',
            'period' => 'required|string|max:50',
            'year' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('production.mps.index')->with('success', 'MasterProductionSchedule updated.');
    }

    public function destroy(string $id)
    {
        MasterProductionSchedule::findOrFail($id)->delete();
        return redirect()->route('production.mps.index')->with('success', 'MasterProductionSchedule deleted.');
    }
}