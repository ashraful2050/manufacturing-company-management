<?php

namespace App\Http\Controllers\ShopFloor;

use App\Http\Controllers\Controller;
use App\Models\MachineDowntime;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MachineDowntimeController extends Controller
{
    public function index()
    {
        $downtimes = MachineDowntime::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('ShopFloor/Downtime/Index', ['downtimes' => $downtimes]);
    }

    public function create()
    {
        return Inertia::render('ShopFloor/Downtime/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'downtime_number' => 'nullable|string|max:50',
            'start_time' => 'required|date',
            'downtime_type' => 'nullable|string|max:100',
            'duration_minutes' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        MachineDowntime::create($data);
        return redirect()->route('shop-floor.downtime.index')->with('success', 'MachineDowntime created.');
    }

    public function show(string $id)
    {
        return Inertia::render('ShopFloor/Downtime/Show', ['machineDowntime' => MachineDowntime::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('ShopFloor/Downtime/Edit', ['machineDowntime' => MachineDowntime::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = MachineDowntime::findOrFail($id);
        $data = $request->validate([
            'downtime_number' => 'nullable|string|max:50',
            'start_time' => 'required|date',
            'downtime_type' => 'nullable|string|max:100',
            'duration_minutes' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('shop-floor.downtime.index')->with('success', 'MachineDowntime updated.');
    }

    public function destroy(string $id)
    {
        MachineDowntime::findOrFail($id)->delete();
        return redirect()->route('shop-floor.downtime.index')->with('success', 'MachineDowntime deleted.');
    }
}