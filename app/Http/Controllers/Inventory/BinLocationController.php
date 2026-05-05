<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\BinLocation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BinLocationController extends Controller
{
    public function index()
    {
        $binLocations = BinLocation::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Inventory/BinLocations/Index', ['binLocations' => $binLocations]);
    }

    public function create()
    {
        return Inertia::render('Inventory/BinLocations/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bin_code' => 'required|string|max:50',
            'zone' => 'nullable|string|max:50',
            'row' => 'nullable|string|max:20',
            'rack' => 'nullable|string|max:20',
            'level' => 'nullable|string|max:20',
            'max_capacity' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        BinLocation::create($data);
        return redirect()->route('inventory.bin-locations.index')->with('success', 'BinLocation created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Inventory/BinLocations/Show', ['binLocation' => BinLocation::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Inventory/BinLocations/Edit', ['binLocation' => BinLocation::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = BinLocation::findOrFail($id);
        $data = $request->validate([
            'bin_code' => 'required|string|max:50',
            'zone' => 'nullable|string|max:50',
            'row' => 'nullable|string|max:20',
            'rack' => 'nullable|string|max:20',
            'level' => 'nullable|string|max:20',
            'max_capacity' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('inventory.bin-locations.index')->with('success', 'BinLocation updated.');
    }

    public function destroy(string $id)
    {
        BinLocation::findOrFail($id)->delete();
        return redirect()->route('inventory.bin-locations.index')->with('success', 'BinLocation deleted.');
    }
}