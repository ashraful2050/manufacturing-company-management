<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\NonConformanceReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NonConformanceController extends Controller
{
    public function index()
    {
        $ncrList = NonConformanceReport::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Quality/Ncr/Index', ['ncrList' => $ncrList]);
    }

    public function create()
    {
        return Inertia::render('Quality/Ncr/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ncr_number' => 'nullable|string|max:50',
            'ncr_date' => 'required|date',
            'nc_type' => 'nullable|string|max:100',
            'description' => 'required|string',
            'severity' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        NonConformanceReport::create($data);
        return redirect()->route('quality.ncr.index')->with('success', 'NonConformanceReport created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Quality/Ncr/Show', ['nonConformanceReport' => NonConformanceReport::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Quality/Ncr/Edit', ['nonConformanceReport' => NonConformanceReport::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = NonConformanceReport::findOrFail($id);
        $data = $request->validate([
            'ncr_number' => 'nullable|string|max:50',
            'ncr_date' => 'required|date',
            'nc_type' => 'nullable|string|max:100',
            'description' => 'required|string',
            'severity' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('quality.ncr.index')->with('success', 'NonConformanceReport updated.');
    }

    public function destroy(string $id)
    {
        NonConformanceReport::findOrFail($id)->delete();
        return redirect()->route('quality.ncr.index')->with('success', 'NonConformanceReport deleted.');
    }
}