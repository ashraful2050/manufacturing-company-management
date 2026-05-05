<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\MaterialIssue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaterialIssueController extends Controller
{
    public function index()
    {
        $materialIssues = MaterialIssue::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Inventory/MaterialIssues/Index', ['materialIssues' => $materialIssues]);
    }

    public function create()
    {
        return Inertia::render('Inventory/MaterialIssues/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'issue_number' => 'nullable|string|max:50',
            'issue_date' => 'required|date',
            'issue_type' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        MaterialIssue::create($data);
        return redirect()->route('inventory.material-issues.index')->with('success', 'MaterialIssue created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Inventory/MaterialIssues/Show', ['materialIssue' => MaterialIssue::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Inventory/MaterialIssues/Edit', ['materialIssue' => MaterialIssue::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = MaterialIssue::findOrFail($id);
        $data = $request->validate([
            'issue_number' => 'nullable|string|max:50',
            'issue_date' => 'required|date',
            'issue_type' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('inventory.material-issues.index')->with('success', 'MaterialIssue updated.');
    }

    public function destroy(string $id)
    {
        MaterialIssue::findOrFail($id)->delete();
        return redirect()->route('inventory.material-issues.index')->with('success', 'MaterialIssue deleted.');
    }
}