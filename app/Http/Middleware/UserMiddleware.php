<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('Checking authentication status.');

        if (Auth::check()) {
            Log::info('User is authenticated:', ['user' => Auth::user()]);
            $user = Auth::user();
            // Check if the user is not the admin
            if ($user->username !== 'kantin_rsij_1') {
                return $next($request); // Allow access to the user
            } else {
                Log::warning('Access denied for admin user:', ['username' => $user->username]);
            }
        } else {
            Log::warning('User is not authenticated.');
        }

        return redirect()->route('login')->withErrors('Access denied.');
    }
}
