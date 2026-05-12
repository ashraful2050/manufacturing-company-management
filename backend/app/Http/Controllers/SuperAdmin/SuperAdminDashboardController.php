<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Plan;
use App\Models\User;
use App\Models\CompanySubscription;
use Inertia\Inertia;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::where('is_active', true)->count(),
            'total_users' => User::where('user_type', '!=', 'superadmin')->count(),
            'total_plans' => Plan::where('is_active', true)->count(),
            'revenue_monthly' => CompanySubscription::where('status', 'active')
                ->whereMonth('starts_at', now()->month)
                ->sum('amount_paid'),
            'new_companies_this_month' => Company::whereMonth('created_at', now()->month)->count(),
        ];

        $recentCompanies = Company::with('plan', 'owner')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $planStats = Plan::withCount('companies')
            ->where('is_active', true)
            ->get()
            ->map(fn($p) => ['name' => $p->name, 'count' => $p->companies_count]);

        return Inertia::render('SuperAdmin/Dashboard', [
            'stats' => $stats,
            'recentCompanies' => $recentCompanies,
            'planStats' => $planStats,
        ]);
    }
}
