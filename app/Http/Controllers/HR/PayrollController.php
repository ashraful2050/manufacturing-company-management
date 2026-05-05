<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Hr/Payroll/Index', ['payrolls' => $payrolls]);
    }

    public function create()
    {
        return Inertia::render('Hr/Payroll/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'payroll_number' => 'nullable|string|max:50',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
            'gross_salary' => 'required|numeric|min:0',
            'total_deductions' => 'nullable|numeric|min:0',
            'net_salary' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Payroll::create($data);
        return redirect()->route('hr.payroll.index')->with('success', 'Payroll created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Hr/Payroll/Show', ['payroll' => Payroll::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Hr/Payroll/Edit', ['payroll' => Payroll::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Payroll::findOrFail($id);
        $data = $request->validate([
            'payroll_number' => 'nullable|string|max:50',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
            'gross_salary' => 'required|numeric|min:0',
            'total_deductions' => 'nullable|numeric|min:0',
            'net_salary' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('hr.payroll.index')->with('success', 'Payroll updated.');
    }

    public function destroy(string $id)
    {
        Payroll::findOrFail($id)->delete();
        return redirect()->route('hr.payroll.index')->with('success', 'Payroll deleted.');
    }
}