<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\RequestForQuotation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RfqController extends Controller
{
    public function index()
    {
        $rfqs = RequestForQuotation::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Procurement/Rfq/Index', ['rfqs' => $rfqs]);
    }

    public function create()
    {
        return Inertia::render('Procurement/Rfq/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rfq_number' => 'nullable|string|max:50',
            'rfq_date' => 'required|date',
            'required_date' => 'nullable|date',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        RequestForQuotation::create($data);
        return redirect()->route('procurement.rfq.index')->with('success', 'RequestForQuotation created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Procurement/Rfq/Show', ['requestForQuotation' => RequestForQuotation::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Procurement/Rfq/Edit', ['requestForQuotation' => RequestForQuotation::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = RequestForQuotation::findOrFail($id);
        $data = $request->validate([
            'rfq_number' => 'nullable|string|max:50',
            'rfq_date' => 'required|date',
            'required_date' => 'nullable|date',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('procurement.rfq.index')->with('success', 'RequestForQuotation updated.');
    }

    public function destroy(string $id)
    {
        RequestForQuotation::findOrFail($id)->delete();
        return redirect()->route('procurement.rfq.index')->with('success', 'RequestForQuotation deleted.');
    }
}