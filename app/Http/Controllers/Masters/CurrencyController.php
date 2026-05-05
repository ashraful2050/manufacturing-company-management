<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Masters/Currencies/Index', ['currencies' => $currencies]);
    }

    public function create()
    {
        return Inertia::render('Masters/Currencies/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'nullable|numeric|min:0',
            'is_base_currency' => 'boolean',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Currency::create($data);
        return redirect()->route('masters.currencies.index')->with('success', 'Currency created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Masters/Currencies/Show', ['currency' => Currency::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Masters/Currencies/Edit', ['currency' => Currency::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Currency::findOrFail($id);
        $data = $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'nullable|numeric|min:0',
            'is_base_currency' => 'boolean',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('masters.currencies.index')->with('success', 'Currency updated.');
    }

    public function destroy(string $id)
    {
        Currency::findOrFail($id)->delete();
        return redirect()->route('masters.currencies.index')->with('success', 'Currency deleted.');
    }
}