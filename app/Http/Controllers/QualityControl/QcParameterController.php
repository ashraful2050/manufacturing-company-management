<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\QcParameter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QcParameterController extends Controller
{
    public function index()
    {
        $parameters = QcParameter::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Quality/Parameters/Index', ['parameters' => $parameters]);
    }

    public function create()
    {
        return Inertia::render('Quality/Parameters/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'parameter_type' => 'required|string|max:50',
            'uom' => 'nullable|string|max:20',
            'min_value' => 'nullable|numeric',
            'max_value' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        QcParameter::create($data);
        return redirect()->route('quality.parameters.index')->with('success', 'QcParameter created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Quality/Parameters/Show', ['qcParameter' => QcParameter::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Quality/Parameters/Edit', ['qcParameter' => QcParameter::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = QcParameter::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'parameter_type' => 'required|string|max:50',
            'uom' => 'nullable|string|max:20',
            'min_value' => 'nullable|numeric',
            'max_value' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('quality.parameters.index')->with('success', 'QcParameter updated.');
    }

    public function destroy(string $id)
    {
        QcParameter::findOrFail($id)->delete();
        return redirect()->route('quality.parameters.index')->with('success', 'QcParameter deleted.');
    }
}