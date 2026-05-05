<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\SalesReturn;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesReturnController extends Controller
{
    public function index()
    {
        $salesReturns = SalesReturn::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Inventory/SalesReturns/Index', ['salesReturns' => $salesReturns]);
    }

    public function create()
    {
        return Inertia::render('Inventory/SalesReturns/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'return_number' => 'nullable|string|max:50',
            'return_date' => 'required|date',
            'return_reason' => 'nullable|string|max:100',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        SalesReturn::create($data);
        return redirect()->route('inventory.sales-returns.index')->with('success', 'SalesReturn created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Inventory/SalesReturns/Show', ['salesReturn' => SalesReturn::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Inventory/SalesReturns/Edit', ['salesReturn' => SalesReturn::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = SalesReturn::findOrFail($id);
        $data = $request->validate([
            'return_number' => 'nullable|string|max:50',
            'return_date' => 'required|date',
            'return_reason' => 'nullable|string|max:100',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('inventory.sales-returns.index')->with('success', 'SalesReturn updated.');
    }

    public function destroy(string $id)
    {
        SalesReturn::findOrFail($id)->delete();
        return redirect()->route('inventory.sales-returns.index')->with('success', 'SalesReturn deleted.');
    }
}