<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxRateController extends Controller
{
    public function index()
    {
        $taxRates = TaxRate::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Masters/TaxRates/Index', ['taxRates' => $taxRates]);
    }

    public function create()
    {
        return Inertia::render('Masters/TaxRates/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'rate' => 'required|numeric|min:0|max:100',
            'tax_type' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        TaxRate::create($data);
        return redirect()->route('masters.tax-rates.index')->with('success', 'TaxRate created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Masters/TaxRates/Show', ['taxRate' => TaxRate::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Masters/TaxRates/Edit', ['taxRate' => TaxRate::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = TaxRate::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'rate' => 'required|numeric|min:0|max:100',
            'tax_type' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('masters.tax-rates.index')->with('success', 'TaxRate updated.');
    }

    public function destroy(string $id)
    {
        TaxRate::findOrFail($id)->delete();
        return redirect()->route('masters.tax-rates.index')->with('success', 'TaxRate deleted.');
    }
}