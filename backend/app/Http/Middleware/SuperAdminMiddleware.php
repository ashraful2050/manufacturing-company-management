<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->user_type !== 'superadmin') {
            abort(403, 'Access denied. Super Admin only.');
        }

        return $next($request);
    }
}
