<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('companies')
            ->with('features')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('SuperAdmin/Plans/Index', ['plans' => $plans]);
    }

    public function create()
    {
        $features = Feature::where('is_active', true)
            ->orderBy('module')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('module');

        return Inertia::render('SuperAdmin/Plans/Create', ['featuresByModule' => $features]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'required|numeric|min:0',
            'max_users' => 'required|integer|min:-1',
            'max_branches' => 'required|integer|min:-1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'feature_ids' => 'array',
            'feature_ids.*' => 'exists:features,id',
        ]);

        $plan = Plan::create([
            ...$validated,
            'slug' => Str::slug($validated['name']),
        ]);

        if (!empty($validated['feature_ids'])) {
            $syncData = [];
            foreach ($validated['feature_ids'] as $featureId) {
                $syncData[$featureId] = ['is_enabled' => true];
            }
            $plan->features()->sync($syncData);
        }

        return redirect()->route('superadmin.plans.index')
            ->with('success', 'Plan created successfully!');
    }

    public function edit(Plan $plan)
    {
        $features = Feature::where('is_active', true)
            ->orderBy('module')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('module');

        $enabledFeatureIds = $plan->features()->pluck('features.id')->toArray();

        return Inertia::render('SuperAdmin/Plans/Edit', [
            'plan' => $plan,
            'featuresByModule' => $features,
            'enabledFeatureIds' => $enabledFeatureIds,
        ]);
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'required|numeric|min:0',
            'max_users' => 'required|integer|min:-1',
            'max_branches' => 'required|integer|min:-1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'feature_ids' => 'array',
            'feature_ids.*' => 'exists:features,id',
        ]);

        $plan->update($validated);

        $syncData = [];
        foreach ($validated['feature_ids'] ?? [] as $featureId) {
            $syncData[$featureId] = ['is_enabled' => true];
        }
        $plan->features()->sync($syncData);

        return redirect()->route('superadmin.plans.index')
            ->with('success', 'Plan updated successfully!');
    }

    public function destroy(Plan $plan)
    {
        if ($plan->companies()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete plan with active companies.']);
        }

        $plan->delete();
        return redirect()->route('superadmin.plans.index')
            ->with('success', 'Plan deleted successfully!');
    }
}
