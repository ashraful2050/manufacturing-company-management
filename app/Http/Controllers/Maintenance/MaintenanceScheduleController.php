<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaintenanceScheduleController extends Controller
{
    public function index()
    {
        $schedules = MaintenanceSchedule::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Maintenance/Schedules/Index', ['schedules' => $schedules]);
    }

    public function create()
    {
        return Inertia::render('Maintenance/Schedules/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'schedule_name' => 'required|string|max:100',
            'maintenance_type' => 'required|string|max:50',
            'frequency' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        MaintenanceSchedule::create($data);
        return redirect()->route('maintenance.schedules.index')->with('success', 'MaintenanceSchedule created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Maintenance/Schedules/Show', ['maintenanceSchedule' => MaintenanceSchedule::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Maintenance/Schedules/Edit', ['maintenanceSchedule' => MaintenanceSchedule::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = MaintenanceSchedule::findOrFail($id);
        $data = $request->validate([
            'schedule_name' => 'required|string|max:100',
            'maintenance_type' => 'required|string|max:50',
            'frequency' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('maintenance.schedules.index')->with('success', 'MaintenanceSchedule updated.');
    }

    public function destroy(string $id)
    {
        MaintenanceSchedule::findOrFail($id)->delete();
        return redirect()->route('maintenance.schedules.index')->with('success', 'MaintenanceSchedule deleted.');
    }
}