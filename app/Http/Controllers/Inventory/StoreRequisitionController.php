<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\StoreRequisition;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreRequisitionController extends Controller
{
    public function index()
    {
        $storeRequisitions = StoreRequisition::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Inventory/StoreRequisitions/Index', ['storeRequisitions' => $storeRequisitions]);
    }

    public function create()
    {
        return Inertia::render('Inventory/StoreRequisitions/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'requisition_number' => 'nullable|string|max:50',
            'requisition_date' => 'required|date',
            'required_date' => 'nullable|date',
            'priority' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        StoreRequisition::create($data);
        return redirect()->route('inventory.store-requisitions.index')->with('success', 'StoreRequisition created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Inventory/StoreRequisitions/Show', ['storeRequisition' => StoreRequisition::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Inventory/StoreRequisitions/Edit', ['storeRequisition' => StoreRequisition::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = StoreRequisition::findOrFail($id);
        $data = $request->validate([
            'requisition_number' => 'nullable|string|max:50',
            'requisition_date' => 'required|date',
            'required_date' => 'nullable|date',
            'priority' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('inventory.store-requisitions.index')->with('success', 'StoreRequisition updated.');
    }

    public function destroy(string $id)
    {
        StoreRequisition::findOrFail($id)->delete();
        return redirect()->route('inventory.store-requisitions.index')->with('success', 'StoreRequisition deleted.');
    }
}