<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PriceListController extends Controller
{
    public function index()
    {
        $priceLists = PriceList::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/PriceLists/Index', ['priceLists' => $priceLists]);
    }

    public function create()
    {
        return Inertia::render('CRM/PriceLists/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'customer_type' => 'nullable|string|max:50',
            'currency_code' => 'nullable|string|max:10',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        PriceList::create($data);
        return redirect()->route('crm.price-lists.index')->with('success', 'PriceList created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/PriceLists/Show', ['priceList' => PriceList::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/PriceLists/Edit', ['priceList' => PriceList::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = PriceList::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'customer_type' => 'nullable|string|max:50',
            'currency_code' => 'nullable|string|max:10',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('crm.price-lists.index')->with('success', 'PriceList updated.');
    }

    public function destroy(string $id)
    {
        PriceList::findOrFail($id)->delete();
        return redirect()->route('crm.price-lists.index')->with('success', 'PriceList deleted.');
    }
}