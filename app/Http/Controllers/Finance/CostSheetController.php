<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\CostSheet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostSheetController extends Controller
{
    public function index()
    {
        $costSheets = CostSheet::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Finance/CostSheets/Index', ['costSheets' => $costSheets]);
    }

    public function create()
    {
        return Inertia::render('Finance/CostSheets/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sheet_number' => 'nullable|string|max:50',
            'sheet_date' => 'required|date',
            'cost_type' => 'required|string|max:50',
            'total_material_cost' => 'nullable|numeric|min:0',
            'total_labour_cost' => 'nullable|numeric|min:0',
            'total_overhead_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        CostSheet::create($data);
        return redirect()->route('finance.cost-sheets.index')->with('success', 'CostSheet created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Finance/CostSheets/Show', ['costSheet' => CostSheet::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Finance/CostSheets/Edit', ['costSheet' => CostSheet::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = CostSheet::findOrFail($id);
        $data = $request->validate([
            'sheet_number' => 'nullable|string|max:50',
            'sheet_date' => 'required|date',
            'cost_type' => 'required|string|max:50',
            'total_material_cost' => 'nullable|numeric|min:0',
            'total_labour_cost' => 'nullable|numeric|min:0',
            'total_overhead_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('finance.cost-sheets.index')->with('success', 'CostSheet updated.');
    }

    public function destroy(string $id)
    {
        CostSheet::findOrFail($id)->delete();
        return redirect()->route('finance.cost-sheets.index')->with('success', 'CostSheet deleted.');
    }
}