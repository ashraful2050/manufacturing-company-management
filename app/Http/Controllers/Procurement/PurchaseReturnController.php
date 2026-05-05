<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\PurchaseReturn;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $purchaseReturns = PurchaseReturn::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Procurement/PurchaseReturns/Index', ['purchaseReturns' => $purchaseReturns]);
    }

    public function create()
    {
        return Inertia::render('Procurement/PurchaseReturns/Create');
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
        PurchaseReturn::create($data);
        return redirect()->route('procurement.purchase-returns.index')->with('success', 'PurchaseReturn created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Procurement/PurchaseReturns/Show', ['purchaseReturn' => PurchaseReturn::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Procurement/PurchaseReturns/Edit', ['purchaseReturn' => PurchaseReturn::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = PurchaseReturn::findOrFail($id);
        $data = $request->validate([
            'return_number' => 'nullable|string|max:50',
            'return_date' => 'required|date',
            'return_reason' => 'nullable|string|max:100',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('procurement.purchase-returns.index')->with('success', 'PurchaseReturn updated.');
    }

    public function destroy(string $id)
    {
        PurchaseReturn::findOrFail($id)->delete();
        return redirect()->route('procurement.purchase-returns.index')->with('success', 'PurchaseReturn deleted.');
    }
}