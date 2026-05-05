<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\JobCard;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobCardController extends Controller
{
    public function index()
    {
        $jobCards = JobCard::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Production/JobCards/Index', ['jobCards' => $jobCards]);
    }

    public function create()
    {
        return Inertia::render('Production/JobCards/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'card_number' => 'nullable|string|max:50',
            'card_date' => 'required|date',
            'planned_qty' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        JobCard::create($data);
        return redirect()->route('production.job-cards.index')->with('success', 'JobCard created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Production/JobCards/Show', ['jobCard' => JobCard::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Production/JobCards/Edit', ['jobCard' => JobCard::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = JobCard::findOrFail($id);
        $data = $request->validate([
            'card_number' => 'nullable|string|max:50',
            'card_date' => 'required|date',
            'planned_qty' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('production.job-cards.index')->with('success', 'JobCard updated.');
    }

    public function destroy(string $id)
    {
        JobCard::findOrFail($id)->delete();
        return redirect()->route('production.job-cards.index')->with('success', 'JobCard deleted.');
    }
}