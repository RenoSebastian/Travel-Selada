<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        Log::info('Login attempt:', [
            'username' => $username,
        ]);

        $user = User::attemptLogin($username, $password);

        if ($user) {
            Log::info('Login successful for user:', ['user_id' => $user->id]);

            if ($user->hasFullAccess()) {
                Log::info('User has full access:', ['user_id' => $user->id]);
                return redirect()->route('landing')->with('status', 'Welcome, you have full access.');
            } else {
                Log::info('User has limited access:', ['user_id' => $user->id]);
                return redirect()->route('login')->with('status', 'Welcome, you have limited access.');
            }
        } else {
            Log::warning('Login failed:', ['username' => $username]);
            return redirect()->back()->withErrors(['login' => 'Invalid username or password']);
        }
    }

    public function loginApk(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        Log::info('APK login attempt:', [
            'username' => $username,
        ]);

        $user = User::attemptLogin($username, $password);

        if ($user) {
            Log::info('APK login successful:', ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                ],
            ]);
        } else {
            Log::warning('APK login failed:', ['username' => $username]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password.',
            ], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
