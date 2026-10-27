<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        if (!auth()->user()->isActive()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}