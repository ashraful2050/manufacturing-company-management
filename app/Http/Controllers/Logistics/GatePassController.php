<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;
use App\Models\GatePass;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GatePassController extends Controller
{
    public function index()
    {
        $gatePasses = GatePass::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Logistics/GatePasses/Index', ['gatePasses' => $gatePasses]);
    }

    public function create()
    {
        return Inertia::render('Logistics/GatePasses/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gate_pass_number' => 'nullable|string|max:50',
            'pass_date' => 'required|date',
            'pass_type' => 'required|string|max:50',
            'party_name' => 'nullable|string|max:100',
            'vehicle_number' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        GatePass::create($data);
        return redirect()->route('logistics.gate-passes.index')->with('success', 'GatePass created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Logistics/GatePasses/Show', ['gatePass' => GatePass::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Logistics/GatePasses/Edit', ['gatePass' => GatePass::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = GatePass::findOrFail($id);
        $data = $request->validate([
            'gate_pass_number' => 'nullable|string|max:50',
            'pass_date' => 'required|date',
            'pass_type' => 'required|string|max:50',
            'party_name' => 'nullable|string|max:100',
            'vehicle_number' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('logistics.gate-passes.index')->with('success', 'GatePass updated.');
    }

    public function destroy(string $id)
    {
        GatePass::findOrFail($id)->delete();
        return redirect()->route('logistics.gate-passes.index')->with('success', 'GatePass deleted.');
    }
}