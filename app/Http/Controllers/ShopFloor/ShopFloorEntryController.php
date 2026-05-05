<?php

namespace App\Http\Controllers\ShopFloor;

use App\Http\Controllers\Controller;
use App\Models\ShopFloorEntry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopFloorEntryController extends Controller
{
    public function index()
    {
        $entries = ShopFloorEntry::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('ShopFloor/Entries/Index', ['entries' => $entries]);
    }

    public function create()
    {
        return Inertia::render('ShopFloor/Entries/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'entry_number' => 'nullable|string|max:50',
            'entry_date' => 'required|date',
            'actual_qty' => 'required|numeric|min:0',
            'rejected_qty' => 'nullable|numeric|min:0',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        ShopFloorEntry::create($data);
        return redirect()->route('shop-floor.entries.index')->with('success', 'ShopFloorEntry created.');
    }

    public function show(string $id)
    {
        return Inertia::render('ShopFloor/Entries/Show', ['shopFloorEntry' => ShopFloorEntry::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('ShopFloor/Entries/Edit', ['shopFloorEntry' => ShopFloorEntry::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = ShopFloorEntry::findOrFail($id);
        $data = $request->validate([
            'entry_number' => 'nullable|string|max:50',
            'entry_date' => 'required|date',
            'actual_qty' => 'required|numeric|min:0',
            'rejected_qty' => 'nullable|numeric|min:0',
        ]);
        $record->update($data);
        return redirect()->route('shop-floor.entries.index')->with('success', 'ShopFloorEntry updated.');
    }

    public function destroy(string $id)
    {
        ShopFloorEntry::findOrFail($id)->delete();
        return redirect()->route('shop-floor.entries.index')->with('success', 'ShopFloorEntry deleted.');
    }
}