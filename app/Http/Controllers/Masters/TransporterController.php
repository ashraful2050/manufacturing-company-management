<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransporterController extends Controller
{
    public function index()
    {
        $transporters = Transporter::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Masters/Transporters/Index', ['transporters' => $transporters]);
    }

    public function create()
    {
        return Inertia::render('Masters/Transporters/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Transporter::create($data);
        return redirect()->route('masters.transporters.index')->with('success', 'Transporter created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Masters/Transporters/Show', ['transporter' => Transporter::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Masters/Transporters/Edit', ['transporter' => Transporter::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Transporter::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);
        $record->update($data);
        return redirect()->route('masters.transporters.index')->with('success', 'Transporter updated.');
    }

    public function destroy(string $id)
    {
        Transporter::findOrFail($id)->delete();
        return redirect()->route('masters.transporters.index')->with('success', 'Transporter deleted.');
    }
}