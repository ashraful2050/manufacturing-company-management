<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\SalesTarget;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesTargetController extends Controller
{
    public function index()
    {
        $salesTargets = SalesTarget::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/SalesTargets/Index', ['salesTargets' => $salesTargets]);
    }

    public function create()
    {
        return Inertia::render('CRM/SalesTargets/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'target_period' => 'required|string|max:50',
            'year' => 'required|integer|min:2000|max:2100',
            'target_for' => 'required|string|max:50',
            'target_amount' => 'required|numeric|min:0',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        SalesTarget::create($data);
        return redirect()->route('crm.sales-targets.index')->with('success', 'SalesTarget created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/SalesTargets/Show', ['salesTarget' => SalesTarget::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/SalesTargets/Edit', ['salesTarget' => SalesTarget::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = SalesTarget::findOrFail($id);
        $data = $request->validate([
            'target_period' => 'required|string|max:50',
            'year' => 'required|integer|min:2000|max:2100',
            'target_for' => 'required|string|max:50',
            'target_amount' => 'required|numeric|min:0',
        ]);
        $record->update($data);
        return redirect()->route('crm.sales-targets.index')->with('success', 'SalesTarget updated.');
    }

    public function destroy(string $id)
    {
        SalesTarget::findOrFail($id)->delete();
        return redirect()->route('crm.sales-targets.index')->with('success', 'SalesTarget deleted.');
    }
}