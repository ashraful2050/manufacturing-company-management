<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/Opportunities/Index', ['opportunities' => $opportunities]);
    }

    public function create()
    {
        return Inertia::render('CRM/Opportunities/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'stage' => 'required|string|max:50',
            'estimated_value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Opportunity::create($data);
        return redirect()->route('crm.opportunities.index')->with('success', 'Opportunity created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/Opportunities/Show', ['opportunity' => Opportunity::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/Opportunities/Edit', ['opportunity' => Opportunity::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Opportunity::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'stage' => 'required|string|max:50',
            'estimated_value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
        ]);
        $record->update($data);
        return redirect()->route('crm.opportunities.index')->with('success', 'Opportunity updated.');
    }

    public function destroy(string $id)
    {
        Opportunity::findOrFail($id)->delete();
        return redirect()->route('crm.opportunities.index')->with('success', 'Opportunity deleted.');
    }
}