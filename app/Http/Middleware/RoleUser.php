<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $page
     * @param  string  $action
     */
    public function handle($request, Closure $next, $page = null, $action = 'view')
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // If no specific page is required, just check if user is authenticated
        if (!$page) {
            return $next($request);
        }

        // Check if user has permission for the specific page and action
        if (!$user->hasPermission($page, $action)) {
            abort(403, "You do not have permission to {$action} on {$page} page.");
        }

        return $next($request);
    }
}