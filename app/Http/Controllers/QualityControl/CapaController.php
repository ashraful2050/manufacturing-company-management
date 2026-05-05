<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\Capa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CapaController extends Controller
{
    public function index()
    {
        $capaList = Capa::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Quality/Capa/Index', ['capaList' => $capaList]);
    }

    public function create()
    {
        return Inertia::render('Quality/Capa/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'capa_number' => 'nullable|string|max:50',
            'capa_date' => 'required|date',
            'capa_type' => 'required|string|max:50',
            'root_cause' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Capa::create($data);
        return redirect()->route('quality.capa.index')->with('success', 'Capa created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Quality/Capa/Show', ['capa' => Capa::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Quality/Capa/Edit', ['capa' => Capa::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Capa::findOrFail($id);
        $data = $request->validate([
            'capa_number' => 'nullable|string|max:50',
            'capa_date' => 'required|date',
            'capa_type' => 'required|string|max:50',
            'root_cause' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('quality.capa.index')->with('success', 'Capa updated.');
    }

    public function destroy(string $id)
    {
        Capa::findOrFail($id)->delete();
        return redirect()->route('quality.capa.index')->with('success', 'Capa deleted.');
    }
}