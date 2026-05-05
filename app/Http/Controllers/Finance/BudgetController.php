<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Finance/Budgets/Index', ['budgets' => $budgets]);
    }

    public function create()
    {
        return Inertia::render('Finance/Budgets/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'budget_number' => 'nullable|string|max:50',
            'budget_name' => 'required|string|max:100',
            'budget_year' => 'required|integer',
            'budget_type' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Budget::create($data);
        return redirect()->route('finance.budgets.index')->with('success', 'Budget created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Finance/Budgets/Show', ['budget' => Budget::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Finance/Budgets/Edit', ['budget' => Budget::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Budget::findOrFail($id);
        $data = $request->validate([
            'budget_number' => 'nullable|string|max:50',
            'budget_name' => 'required|string|max:100',
            'budget_year' => 'required|integer',
            'budget_type' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('finance.budgets.index')->with('success', 'Budget updated.');
    }

    public function destroy(string $id)
    {
        Budget::findOrFail($id)->delete();
        return redirect()->route('finance.budgets.index')->with('success', 'Budget deleted.');
    }
}