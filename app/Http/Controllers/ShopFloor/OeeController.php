<?php

namespace App\Http\Controllers\ShopFloor;

use App\Http\Controllers\Controller;
use App\Models\OeeRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OeeController extends Controller
{
    public function index()
    {
        $oeeRecords = OeeRecord::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('ShopFloor/Oee/Index', ['oeeRecords' => $oeeRecords]);
    }

    public function create()
    {
        return Inertia::render('ShopFloor/Oee/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'record_date' => 'required|date',
            'availability' => 'required|numeric|min:0|max:100',
            'performance' => 'required|numeric|min:0|max:100',
            'quality' => 'required|numeric|min:0|max:100',
            'oee' => 'required|numeric|min:0|max:100',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        OeeRecord::create($data);
        return redirect()->route('shop-floor.oee.index')->with('success', 'OeeRecord created.');
    }

    public function show(string $id)
    {
        return Inertia::render('ShopFloor/Oee/Show', ['oeeRecord' => OeeRecord::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('ShopFloor/Oee/Edit', ['oeeRecord' => OeeRecord::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = OeeRecord::findOrFail($id);
        $data = $request->validate([
            'record_date' => 'required|date',
            'availability' => 'required|numeric|min:0|max:100',
            'performance' => 'required|numeric|min:0|max:100',
            'quality' => 'required|numeric|min:0|max:100',
            'oee' => 'required|numeric|min:0|max:100',
        ]);
        $record->update($data);
        return redirect()->route('shop-floor.oee.index')->with('success', 'OeeRecord updated.');
    }

    public function destroy(string $id)
    {
        OeeRecord::findOrFail($id)->delete();
        return redirect()->route('shop-floor.oee.index')->with('success', 'OeeRecord deleted.');
    }
}