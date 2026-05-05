<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\MrpRun;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MrpController extends Controller
{
    public function index()
    {
        $mrpRuns = MrpRun::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Production/Mrp/Index', ['mrpRuns' => $mrpRuns]);
    }

    public function create()
    {
        return Inertia::render('Production/Mrp/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'run_number' => 'nullable|string|max:50',
            'run_date' => 'required|date',
            'run_type' => 'nullable|string|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        MrpRun::create($data);
        return redirect()->route('production.mrp.index')->with('success', 'MrpRun created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Production/Mrp/Show', ['mrpRun' => MrpRun::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Production/Mrp/Edit', ['mrpRun' => MrpRun::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = MrpRun::findOrFail($id);
        $data = $request->validate([
            'run_number' => 'nullable|string|max:50',
            'run_date' => 'required|date',
            'run_type' => 'nullable|string|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('production.mrp.index')->with('success', 'MrpRun updated.');
    }

    public function destroy(string $id)
    {
        MrpRun::findOrFail($id)->delete();
        return redirect()->route('production.mrp.index')->with('success', 'MrpRun deleted.');
    }
}