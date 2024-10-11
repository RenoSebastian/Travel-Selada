<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Entities\UserTravel;
use App\Entities\Role;

class UserTravelController extends Controller
{
    public function index()
    {
        $users = UserTravel::all(); // Ambil semua pengguna
        return view('user_travel.index', compact('users')); // Kirim data pengguna ke view
    }

    public function create()
    {
        $roles = Role::all();
        return view('user_travel.create', compact( 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'username' => 'required|unique:user_travel',
            'password' => 'required',
            'email' => 'required|email|unique:user_travel',
            'phone' => 'nullable',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        UserTravel::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('user_travel.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = UserTravel::find($id); // Temukan pengguna berdasarkan ID
        $roles = Role::all();
        return view('user_travel.edit', compact('user', 'roles')); // Kirim data pengguna ke view edit
    }

    public function update(Request $request, $id)
    {
        $user = UserTravel::findOrFail($id);

        $request->validate([
            'fullname' => 'required',
            'username' => 'required|unique:user_travel,username,' . $user->id,
            'password' => 'nullable',
            'email' => 'required|email|unique:user_travel,email,' . $user->id,
            'phone' => 'nullable',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user_travel.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = UserTravel::findOrFail($id);
        $user->delete();

        return redirect()->route('user_travel.index')->with('success', 'User deleted successfully.');
    }
}
