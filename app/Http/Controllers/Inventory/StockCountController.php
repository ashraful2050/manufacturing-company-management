<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\StockCountSession;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockCountController extends Controller
{
    public function index()
    {
        $sessions = StockCountSession::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Inventory/StockCount/Index', ['sessions' => $sessions]);
    }

    public function create()
    {
        return Inertia::render('Inventory/StockCount/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'session_number' => 'nullable|string|max:50',
            'count_date' => 'required|date',
            'count_type' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        StockCountSession::create($data);
        return redirect()->route('inventory.stock-count.index')->with('success', 'StockCountSession created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Inventory/StockCount/Show', ['stockCountSession' => StockCountSession::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Inventory/StockCount/Edit', ['stockCountSession' => StockCountSession::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = StockCountSession::findOrFail($id);
        $data = $request->validate([
            'session_number' => 'nullable|string|max:50',
            'count_date' => 'required|date',
            'count_type' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('inventory.stock-count.index')->with('success', 'StockCountSession updated.');
    }

    public function destroy(string $id)
    {
        StockCountSession::findOrFail($id)->delete();
        return redirect()->route('inventory.stock-count.index')->with('success', 'StockCountSession deleted.');
    }
}