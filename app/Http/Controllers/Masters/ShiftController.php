<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Masters/Shifts/Index', ['shifts' => $shifts]);
    }

    public function create()
    {
        return Inertia::render('Masters/Shifts/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Shift::create($data);
        return redirect()->route('masters.shifts.index')->with('success', 'Shift created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Masters/Shifts/Show', ['shift' => Shift::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Masters/Shifts/Edit', ['shift' => Shift::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Shift::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('masters.shifts.index')->with('success', 'Shift updated.');
    }

    public function destroy(string $id)
    {
        Shift::findOrFail($id)->delete();
        return redirect()->route('masters.shifts.index')->with('success', 'Shift deleted.');
    }
}