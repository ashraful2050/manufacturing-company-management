<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('Hr/Attendance/Index', ['attendances' => $attendances]);
    }

    public function create()
    {
        return Inertia::render('Hr/Attendance/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'attendance_date' => 'required|date',
            'check_in' => 'nullable|string',
            'check_out' => 'nullable|string',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Attendance::create($data);
        return redirect()->route('hr.attendance.index')->with('success', 'Attendance created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Hr/Attendance/Show', ['attendance' => Attendance::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Hr/Attendance/Edit', ['attendance' => Attendance::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = Attendance::findOrFail($id);
        $data = $request->validate([
            'attendance_date' => 'required|date',
            'check_in' => 'nullable|string',
            'check_out' => 'nullable|string',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('hr.attendance.index')->with('success', 'Attendance updated.');
    }

    public function destroy(string $id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->route('hr.attendance.index')->with('success', 'Attendance deleted.');
    }
}