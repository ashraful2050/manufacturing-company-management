<?php

namespace App\Http\Controllers\Compliance;

use App\Http\Controllers\Controller;
use App\Models\ComplianceRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComplianceController extends Controller
{
    public function index()
    {
        $records = ComplianceRecord::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Compliance/Records/Index', ['records' => $records]);
    }

    public function create()
    {
        return Inertia::render('Compliance/Records/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'record_number' => 'nullable|string|max:50',
            'compliance_type' => 'required|string|max:100',
            'regulation_body' => 'nullable|string|max:100',
            'compliance_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        ComplianceRecord::create($data);
        return redirect()->route('compliance.records.index')->with('success', 'ComplianceRecord created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Compliance/Records/Show', ['complianceRecord' => ComplianceRecord::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Compliance/Records/Edit', ['complianceRecord' => ComplianceRecord::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = ComplianceRecord::findOrFail($id);
        $data = $request->validate([
            'record_number' => 'nullable|string|max:50',
            'compliance_type' => 'required|string|max:100',
            'regulation_body' => 'nullable|string|max:100',
            'compliance_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('compliance.records.index')->with('success', 'ComplianceRecord updated.');
    }

    public function destroy(string $id)
    {
        ComplianceRecord::findOrFail($id)->delete();
        return redirect()->route('compliance.records.index')->with('success', 'ComplianceRecord deleted.');
    }
}