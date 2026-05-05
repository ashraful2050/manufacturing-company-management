<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaveController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Hr/Leave/Index', ['leaveRequests' => $leaveRequests]);
    }

    public function create()
    {
        return Inertia::render('Hr/Leave/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'leave_number' => 'nullable|string|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'total_days' => 'required|numeric|min:0.5',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        LeaveRequest::create($data);
        return redirect()->route('hr.leave.index')->with('success', 'LeaveRequest created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Hr/Leave/Show', ['leaveRequest' => LeaveRequest::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Hr/Leave/Edit', ['leaveRequest' => LeaveRequest::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = LeaveRequest::findOrFail($id);
        $data = $request->validate([
            'leave_number' => 'nullable|string|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'total_days' => 'required|numeric|min:0.5',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('hr.leave.index')->with('success', 'LeaveRequest updated.');
    }

    public function destroy(string $id)
    {
        LeaveRequest::findOrFail($id)->delete();
        return redirect()->route('hr.leave.index')->with('success', 'LeaveRequest deleted.');
    }
}