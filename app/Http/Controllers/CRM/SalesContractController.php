<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\SalesContract;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesContractController extends Controller
{
    public function index()
    {
        $contracts = SalesContract::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/SalesContracts/Index', ['contracts' => $contracts]);
    }

    public function create()
    {
        return Inertia::render('CRM/SalesContracts/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contract_number' => 'nullable|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'contract_value' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        SalesContract::create($data);
        return redirect()->route('crm.sales-contracts.index')->with('success', 'SalesContract created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/SalesContracts/Show', ['salesContract' => SalesContract::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/SalesContracts/Edit', ['salesContract' => SalesContract::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = SalesContract::findOrFail($id);
        $data = $request->validate([
            'contract_number' => 'nullable|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'contract_value' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('crm.sales-contracts.index')->with('success', 'SalesContract updated.');
    }

    public function destroy(string $id)
    {
        SalesContract::findOrFail($id)->delete();
        return redirect()->route('crm.sales-contracts.index')->with('success', 'SalesContract deleted.');
    }
}