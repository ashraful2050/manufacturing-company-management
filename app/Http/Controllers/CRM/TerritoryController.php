<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Territory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TerritoryController extends Controller
{
    public function index()
    {
        $territories = Territory::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/Territories/Index', ['territories' => $territories]);
    }

    public function create()
    {
        return Inertia::render('CRM/Territories/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Territory::create($data);
        return redirect()->route('crm.territories.index')->with('success', 'Territory created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/Territories/Show', ['territory' => Territory::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/Territories/Edit', ['territory' => Territory::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Territory::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('crm.territories.index')->with('success', 'Territory updated.');
    }

    public function destroy(string $id)
    {
        Territory::findOrFail($id)->delete();
        return redirect()->route('crm.territories.index')->with('success', 'Territory deleted.');
    }
}