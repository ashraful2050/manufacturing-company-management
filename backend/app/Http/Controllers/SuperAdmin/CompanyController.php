<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Plan;
use App\Models\User;
use App\Models\Role;
use App\Models\CompanySubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::with('plan', 'owner')
            ->withCount('users');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('is_active', $request->status === 'active');
        }

        $companies = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $plans = Plan::where('is_active', true)->get(['id', 'name', 'slug']);

        return Inertia::render('SuperAdmin/Companies/Index', [
            'companies' => $companies,
            'plans' => $plans,
            'filters' => $request->only('search', 'status'),
        ]);
    }

    public function create()
    {
        $plans = Plan::where('is_active', true)->orderBy('sort_order')->get();
        return Inertia::render('SuperAdmin/Companies/Create', ['plans' => $plans]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies,email',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
            'plan_id' => 'required|exists:plans,id',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8',
            'trial_days' => 'nullable|integer|min:0|max:365',
        ]);

        $slug = Str::slug($validated['company_name']);
        $originalSlug = $slug;
        $count = 1;
        while (Company::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $company = Company::create([
            'name' => $validated['company_name'],
            'slug' => $slug,
            'email' => $validated['company_email'],
            'phone' => $validated['company_phone'],
            'address' => $validated['company_address'],
            'plan_id' => $validated['plan_id'],
            'is_active' => true,
            'trial_ends_at' => isset($validated['trial_days']) && $validated['trial_days'] > 0
                ? now()->addDays($validated['trial_days'])
                : null,
        ]);

        // Create admin user
        $adminUser = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'user_type' => 'admin',
            'company_id' => $company->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $company->update(['owner_user_id' => $adminUser->id]);

        // Create default roles
        $adminRole = Role::create([
            'company_id' => $company->id,
            'name' => 'Admin',
            'slug' => 'admin',
            'is_system_role' => true,
        ]);

        $adminUser->update(['role_id' => $adminRole->id]);

        // Create active subscription
        CompanySubscription::create([
            'company_id' => $company->id,
            'plan_id' => $validated['plan_id'],
            'starts_at' => now(),
            'expires_at' => now()->addYear(),
            'amount_paid' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('superadmin.companies.index')
            ->with('success', 'Company created successfully!');
    }

    public function show(Company $company)
    {
        $company->load('plan', 'owner', 'branches', 'subscriptions.plan');
        $company->loadCount('users');
        return Inertia::render('SuperAdmin/Companies/Show', ['company' => $company]);
    }

    public function edit(Company $company)
    {
        $plans = Plan::where('is_active', true)->orderBy('sort_order')->get();
        return Inertia::render('SuperAdmin/Companies/Edit', [
            'company' => $company->load('plan'),
            'plans' => $plans,
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'plan_id' => 'required|exists:plans,id',
            'is_active' => 'boolean',
        ]);

        $company->update($validated);

        return redirect()->route('superadmin.companies.index')
            ->with('success', 'Company updated successfully!');
    }

    public function toggleStatus(Company $company)
    {
        $company->update(['is_active' => !$company->is_active]);
        return back()->with('success', 'Company status updated.');
    }
}
