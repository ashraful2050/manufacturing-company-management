<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Documents/Files/Index', ['documents' => $documents]);
    }

    public function create()
    {
        return Inertia::render('Documents/Files/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'document_category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Document::create($data);
        return redirect()->route('documents.files.index')->with('success', 'Document created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Documents/Files/Show', ['document' => Document::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Documents/Files/Edit', ['document' => Document::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Document::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'document_category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);
        $record->update($data);
        return redirect()->route('documents.files.index')->with('success', 'Document updated.');
    }

    public function destroy(string $id)
    {
        Document::findOrFail($id)->delete();
        return redirect()->route('documents.files.index')->with('success', 'Document deleted.');
    }
}