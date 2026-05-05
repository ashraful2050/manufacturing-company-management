<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account has been deactivated.']);
        }

        if ($user->user_type !== 'superadmin' && !$user->company_id) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'No company assigned to your account.']);
        }

        if ($user->user_type !== 'superadmin' && $user->company && !$user->company->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Your company account is suspended.']);
        }

        return $next($request);
    }
}
