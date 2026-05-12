<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('company')
            ->where('user_type', 'admin')
            ->orderByDesc('created_at');

        if ($request->search) {
            $query->where(fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
            );
        }

        if ($request->company_id) {
            $query->where('company_id', $request->company_id);
        }

        $users = $query->paginate(15)->withQueryString();
        $companies = Company::orderBy('name')->get(['id', 'name']);

        return Inertia::render('SuperAdmin/AdminUsers/Index', [
            'users' => $users,
            'companies' => $companies,
            'filters' => $request->only('search', 'company_id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'company_id' => 'required|exists:companies,id',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'admin',
            'company_id' => $validated['company_id'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return back()->with('success', 'Admin user created successfully!');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'User status updated.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
            'must_change_password' => true,
        ]);

        return back()->with('success', 'Password reset successfully!');
    }
}
