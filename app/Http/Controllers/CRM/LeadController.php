<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/Leads/Index', ['leads' => $leads]);
    }

    public function create()
    {
        return Inertia::render('CRM/Leads/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lead_number' => 'nullable|string|max:50',
            'title' => 'required|string|max:200',
            'lead_source' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'priority' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Lead::create($data);
        return redirect()->route('crm.leads.index')->with('success', 'Lead created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/Leads/Show', ['lead' => Lead::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/Leads/Edit', ['lead' => Lead::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Lead::findOrFail($id);
        $data = $request->validate([
            'lead_number' => 'nullable|string|max:50',
            'title' => 'required|string|max:200',
            'lead_source' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'priority' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $record->update($data);
        return redirect()->route('crm.leads.index')->with('success', 'Lead updated.');
    }

    public function destroy(string $id)
    {
        Lead::findOrFail($id)->delete();
        return redirect()->route('crm.leads.index')->with('success', 'Lead deleted.');
    }
}