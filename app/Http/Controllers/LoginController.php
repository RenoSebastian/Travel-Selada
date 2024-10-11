<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use App\Entities\UserLocation;
use App\Entities\MLocation;
use App\Entities\MBrand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
    
        $user = User::where('username', $username)->first();
        if ($user) {
            Log::info('User found:', ['user_id' => $user->id, 'role_id' => $user->role_id]);
        } else {
            Log::warning('User not found:', ['username' => $username]);
            return back()->withErrors([
                'login' => 'Invalid username or password.',
            ])->withInput();
        }
    
        if (Hash::check($password, $user->password)) {
            Log::info('Password check passed for user:', ['user_id' => $user->id]);
            
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'role_id' => $user->role_id,
            ]);
    
            $roleId = (int) $user->role_id;
            Log::info('Redirecting user based on role_id:', ['role_id' => $roleId]);
    
            if ($roleId === 2) {
                Log::info('User is admin, redirecting to admin dashboard.');
                return redirect()->route('admin.dashboard')->with('status', 'Welcome, you have access to the admin dashboard.');
            } else {
                Log::info('User is not admin, redirecting to user dashboard.');
                return redirect()->route('user.dashboard')->with('status', 'Welcome, you have limited access.');
            }
        } else {
            Log::info('Failed login attempt - invalid password:', ['user_id' => $user->id]);
            return back()->withErrors([
                'login' => 'Invalid username or password.',
            ])->withInput();
        }
    }
    
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|max:20',
            'fullname' => 'required|string|max:255',
            'role_id' => 'required|in:1,2,3',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'fullname' => $request->fullname,
            'role_id' => $request->role_id,
        ]);

        Log::info('New user registered:', ['user_id' => $user->id, 'username' => $user->username]);

        Auth::login($user);

        return view('auth.login');
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
                        'phone' => $user->phone,
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
        session()->flush();
        return redirect()->route('login');
    }
}
