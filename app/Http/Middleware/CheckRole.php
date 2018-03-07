<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Added "Auth Middleware" functionality to detect Auth status
        // So that we dont have to also add the "auth middleware" to our routes/controllers
        if (!Auth::check()) {
            return redirect('login');
        }

        // Get user
        $user = Auth::user();

        // Check its role
        if ($user->hasRole($role)) {
            return $next($request);
        }

        // If user dont have the role let him know
        return redirect('unauthorized');
    }
}
