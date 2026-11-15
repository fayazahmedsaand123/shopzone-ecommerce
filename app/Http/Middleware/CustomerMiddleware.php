<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware {

    public function handle(Request $request, Closure $next) {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Please login to continue.'], 401);
            }
            return redirect()->route('login');
        }

        if (auth()->user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'This feature is only available to customer accounts.'], 403);
            }
            return redirect()->route('admin.dashboard');
        }

        if (!auth()->user()->isActive()) {
            auth()->logout();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Your account has been deactivated.'], 403);
            }
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}