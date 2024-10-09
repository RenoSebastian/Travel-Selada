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
    
        Log::info('Login attempt:', ['username' => $username]);
    
        $user = User::attemptLogin($username, $password);
    
        if ($user) {
            Log::info('User found:', ['username' => $user->username]);
    
            Auth::login($user);
            $request->session()->regenerate();
    
            Log::info('User logged in:', ['username' => $user->username]);
    
            if ($user->hasFullAccess()) {
                return redirect()->route('admin.dashboard')->with('status', 'Welcome, you have full access.');
            } else {
                return redirect()->route('user.dashboard')->with('status', 'Welcome, you have limited access.');
            }
        } else {
            Log::warning('Login failed:', ['username' => $username]);
            return redirect()->back()->withErrors(['login' => 'Invalid username or password']);
        }
    }
    

    public function loginApk(Request $request)
    {
        Log::info('APK login attempt:', [
            'username' => $request->username,
        ]);

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user) {
            Log::info('User found:', ['user_id' => $user->id, 'username' => $user->username]);

            if (Hash::check($request->password, $user->password)) {
                Log::info('APK login successful:', ['user_id' => $user->id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'id' => (string)$user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'fullname' => $user->fullname,
                    ],
                ]);
            } else {
                Log::warning('Invalid password for user:', ['username' => $request->username]);
            }
        } else {
            Log::warning('User not found:', ['username' => $request->username]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid username or password.',
        ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
