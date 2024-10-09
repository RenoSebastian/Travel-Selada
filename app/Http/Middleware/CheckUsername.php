<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUsername
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = session('user_id');
        $username = session('username');

        if (!$username || $username !== 'kantin_rsij_1') {
            Log::warning('Access denied due to invalid username.', [
                'user_id' => $userId,
                'username' => $username,
                'ip_address' => $request->ip(),
                'timestamp' => now(),
            ]);

            return redirect()->route('user.dashboard')->withErrors(['access' => 'Access denied. You do not have permission to access this page.']);
        }

        Log::info('Access granted to user.', [
            'user_id' => $userId,
            'username' => $username,
            'ip_address' => $request->ip(),
            'timestamp' => now(),
        ]);

        return $next($request);
    }
}
