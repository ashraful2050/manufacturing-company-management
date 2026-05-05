<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Masters/Machines/Index', ['machines' => $machines]);
    }

    public function create()
    {
        return Inertia::render('Masters/Machines/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
            'machine_type' => 'nullable|string|max:100',
            'manufacturer' => 'nullable|string|max:100',
            'model_number' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Machine::create($data);
        return redirect()->route('masters.machines.index')->with('success', 'Machine created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Masters/Machines/Show', ['machine' => Machine::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Masters/Machines/Edit', ['machine' => Machine::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Machine::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
            'machine_type' => 'nullable|string|max:100',
            'manufacturer' => 'nullable|string|max:100',
            'model_number' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('masters.machines.index')->with('success', 'Machine updated.');
    }

    public function destroy(string $id)
    {
        Machine::findOrFail($id)->delete();
        return redirect()->route('masters.machines.index')->with('success', 'Machine deleted.');
    }
}