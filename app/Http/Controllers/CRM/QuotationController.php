<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/Quotations/Index', ['quotations' => $quotations]);
    }

    public function create()
    {
        return Inertia::render('CRM/Quotations/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quotation_number' => 'nullable|string|max:50',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'status' => 'required|string|max:50',
            'grand_total' => 'nullable|numeric|min:0',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Quotation::create($data);
        return redirect()->route('crm.quotations.index')->with('success', 'Quotation created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/Quotations/Show', ['quotation' => Quotation::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/Quotations/Edit', ['quotation' => Quotation::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Quotation::findOrFail($id);
        $data = $request->validate([
            'quotation_number' => 'nullable|string|max:50',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'status' => 'required|string|max:50',
            'grand_total' => 'nullable|numeric|min:0',
        ]);
        $record->update($data);
        return redirect()->route('crm.quotations.index')->with('success', 'Quotation updated.');
    }

    public function destroy(string $id)
    {
        Quotation::findOrFail($id)->delete();
        return redirect()->route('crm.quotations.index')->with('success', 'Quotation deleted.');
    }
}