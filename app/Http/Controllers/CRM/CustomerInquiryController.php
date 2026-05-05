<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CustomerInquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerInquiryController extends Controller
{
    public function index()
    {
        $inquiries = CustomerInquiry::orderBy('id', 'desc')->paginate(20);
        return Inertia::render('CRM/Inquiries/Index', ['inquiries' => $inquiries]);
    }

    public function create()
    {
        return Inertia::render('CRM/Inquiries/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inquiry_number' => 'nullable|string|max:50',
            'inquiry_date' => 'required|date',
            'channel' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        CustomerInquiry::create($data);
        return redirect()->route('crm.inquiries.index')->with('success', 'CustomerInquiry created.');
    }

    public function show(string $id)
    {
        return Inertia::render('CRM/Inquiries/Show', ['customerInquiry' => CustomerInquiry::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('CRM/Inquiries/Edit', ['customerInquiry' => CustomerInquiry::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $record = CustomerInquiry::findOrFail($id);
        $data = $request->validate([
            'inquiry_number' => 'nullable|string|max:50',
            'inquiry_date' => 'required|date',
            'channel' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);
        $record->update($data);
        return redirect()->route('crm.inquiries.index')->with('success', 'CustomerInquiry updated.');
    }

    public function destroy(string $id)
    {
        CustomerInquiry::findOrFail($id)->delete();
        return redirect()->route('crm.inquiries.index')->with('success', 'CustomerInquiry deleted.');
    }
}