<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->paginate(20);
        return Inertia::render('Masters/Brands/Index', compact('brands'));
    }

    public function create()
    {
        return Inertia::render('Masters/Brands/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:100',
            'code'              => 'nullable|string|max:50',
            'country_of_origin' => 'nullable|string|max:100',
            'website'           => 'nullable|url|max:255',
            'description'       => 'nullable|string',
            'is_active'         => 'boolean',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Brand::create($data);
        return redirect()->route('masters.brands.index')->with('success', 'Brand created.');
    }

    public function show(string $id)
    {
        return Inertia::render('Masters/Brands/Show', ['brand' => Brand::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Masters/Brands/Edit', ['brand' => Brand::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);
        $data = $request->validate([
            'name'              => 'required|string|max:100',
            'code'              => 'nullable|string|max:50',
            'country_of_origin' => 'nullable|string|max:100',
            'website'           => 'nullable|url|max:255',
            'description'       => 'nullable|string',
            'is_active'         => 'boolean',
        ]);
        $brand->update($data);
        return redirect()->route('masters.brands.index')->with('success', 'Brand updated.');
    }

    public function destroy(string $id)
    {
        Brand::findOrFail($id)->delete();
        return redirect()->route('masters.brands.index')->with('success', 'Brand deleted.');
    }
}

