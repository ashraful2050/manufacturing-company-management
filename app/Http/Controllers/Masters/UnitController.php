<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('name')->paginate(20);
        return Inertia::render('Masters/Units/Index', compact('units'));
    }

    public function create()
    {
        return Inertia::render('Masters/Units/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'abbreviation'     => 'required|string|max:20',
            'unit_type'        => 'required|string|max:50',
            'decimal_places'   => 'nullable|integer|min:0|max:6',
            'is_active'        => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Unit::create($data);
        return redirect()->route('masters.units.index')->with('success', 'Unit created.');
    }

    public function show(string $id)
    {
        $unit = Unit::findOrFail($id);
        return Inertia::render('Masters/Units/Show', compact('unit'));
    }

    public function edit(string $id)
    {
        $unit = Unit::findOrFail($id);
        return Inertia::render('Masters/Units/Edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        $data = $request->validate([
            'name'           => 'required|string|max:100',
            'abbreviation'   => 'required|string|max:20',
            'unit_type'      => 'required|string|max:50',
            'decimal_places' => 'nullable|integer|min:0|max:6',
            'is_active'      => 'boolean',
        ]);
        $unit->update($data);
        return redirect()->route('masters.units.index')->with('success', 'Unit updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Unit::findOrFail($id)->delete();
        return redirect()->route('masters.units.index')->with('success', 'Unit deleted.');
    }
}
