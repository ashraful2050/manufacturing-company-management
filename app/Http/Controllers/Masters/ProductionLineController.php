<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\ProductionLine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductionLineController extends Controller
{
    public function index()
    {
        $productionLines = ProductionLine::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Masters/ProductionLines/Index', ['productionLines' => $productionLines]);
    }

    public function create()
    {
        return Inertia::render('Masters/ProductionLines/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'line_type' => 'nullable|string|max:100',
            'capacity_per_shift' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        ProductionLine::create($data);
        return redirect()->route('masters.production-lines.index')->with('success', 'ProductionLine created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Masters/ProductionLines/Show', ['productionLine' => ProductionLine::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Masters/ProductionLines/Edit', ['productionLine' => ProductionLine::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = ProductionLine::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'line_type' => 'nullable|string|max:100',
            'capacity_per_shift' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('masters.production-lines.index')->with('success', 'ProductionLine updated.');
    }

    public function destroy(string $id)
    {
        ProductionLine::findOrFail($id)->delete();
        return redirect()->route('masters.production-lines.index')->with('success', 'ProductionLine deleted.');
    }
}