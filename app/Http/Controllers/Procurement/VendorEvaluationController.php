<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\VendorEvaluation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = VendorEvaluation::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Procurement/VendorEvaluations/Index', ['evaluations' => $evaluations]);
    }

    public function create()
    {
        return Inertia::render('Procurement/VendorEvaluations/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'evaluation_number' => 'nullable|string|max:50',
            'evaluation_date' => 'required|date',
            'evaluation_period' => 'nullable|string|max:100',
            'total_score' => 'nullable|numeric|min:0|max:100',
            'rating' => 'nullable|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        VendorEvaluation::create($data);
        return redirect()->route('procurement.vendor-evaluations.index')->with('success', 'VendorEvaluation created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Procurement/VendorEvaluations/Show', ['vendorEvaluation' => VendorEvaluation::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Procurement/VendorEvaluations/Edit', ['vendorEvaluation' => VendorEvaluation::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = VendorEvaluation::findOrFail($id);
        $data = $request->validate([
            'evaluation_number' => 'nullable|string|max:50',
            'evaluation_date' => 'required|date',
            'evaluation_period' => 'nullable|string|max:100',
            'total_score' => 'nullable|numeric|min:0|max:100',
            'rating' => 'nullable|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('procurement.vendor-evaluations.index')->with('success', 'VendorEvaluation updated.');
    }

    public function destroy(string $id)
    {
        VendorEvaluation::findOrFail($id)->delete();
        return redirect()->route('procurement.vendor-evaluations.index')->with('success', 'VendorEvaluation deleted.');
    }
}