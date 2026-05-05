<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceWorkOrder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaintenanceWorkOrderController extends Controller
{
    public function index()
    {
        $workOrders = MaintenanceWorkOrder::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Maintenance/WorkOrders/Index', ['workOrders' => $workOrders]);
    }

    public function create()
    {
        return Inertia::render('Maintenance/WorkOrders/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wo_number' => 'nullable|string|max:50',
            'wo_date' => 'required|date',
            'work_type' => 'required|string|max:50',
            'priority' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        MaintenanceWorkOrder::create($data);
        return redirect()->route('maintenance.work-orders.index')->with('success', 'MaintenanceWorkOrder created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Maintenance/WorkOrders/Show', ['maintenanceWorkOrder' => MaintenanceWorkOrder::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Maintenance/WorkOrders/Edit', ['maintenanceWorkOrder' => MaintenanceWorkOrder::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = MaintenanceWorkOrder::findOrFail($id);
        $data = $request->validate([
            'wo_number' => 'nullable|string|max:50',
            'wo_date' => 'required|date',
            'work_type' => 'required|string|max:50',
            'priority' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('maintenance.work-orders.index')->with('success', 'MaintenanceWorkOrder updated.');
    }

    public function destroy(string $id)
    {
        MaintenanceWorkOrder::findOrFail($id)->delete();
        return redirect()->route('maintenance.work-orders.index')->with('success', 'MaintenanceWorkOrder deleted.');
    }
}