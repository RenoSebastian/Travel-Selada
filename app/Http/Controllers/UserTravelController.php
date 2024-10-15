<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Entities\UserTravel;
use App\Entities\Role;
use Illuminate\Support\Str;
use App\Entities\Bus;

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
        $buses = Bus::all(); 
        return view('user_travel.create', compact('roles', 'buses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user_travel',
            'email' => 'required|email|max:255|unique:user_travel',
            'phone' => 'nullable|string|max:15',
            'role_id' => 'required|integer',
            'password' => 'required|string|min:8',
            'id_bus' => 'required|exists:buses,id', // Validate that id_bus exists in buses table
        ]);

        try {
            // Create a new user travel record
            $userTravel = new UserTravel();
            $userTravel->id = (string) Str::uuid(); // Set UUID as the ID
            $userTravel->fullname = $validatedData['fullname'];
            $userTravel->username = $validatedData['username'];
            $userTravel->email = $validatedData['email'];
            $userTravel->phone = $validatedData['phone'];
            $userTravel->role_id = $validatedData['role_id'];
            $userTravel->password = bcrypt($validatedData['password']);
            $userTravel->id_bus = $validatedData['id_bus']; // Store the id of the bus
            $userTravel->save();

            return redirect()->route('user_travel.index')->with('success', 'User travel created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user travel: ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $user = UserTravel::find($id); // Temukan pengguna berdasarkan ID
        $roles = Role::all();
        $buses = Bus::all();
        return view('user_travel.edit', compact('user', 'roles', 'buses')); // Kirim data pengguna ke view edit
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'role_id' => 'required|integer',
            'password' => 'nullable|string|min:8', // Password bisa dikosongkan
        ]);

        try {
            // Temukan user berdasarkan id
            $userTravel = UserTravel::findOrFail($id);

            // Update data yang diisi
            $userTravel->fullname = $validatedData['fullname'];
            $userTravel->username = $validatedData['username'];
            $userTravel->email = $validatedData['email'];
            $userTravel->phone = $validatedData['phone'];
            $userTravel->role_id = $validatedData['role_id'];

            // Jika password diisi, maka update
            if (!empty($validatedData['password'])) {
                $userTravel->password = bcrypt($validatedData['password']);
            }

            $userTravel->save();

            return redirect()->route('user_travel.index')->with('success', 'User travel updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user travel: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = UserTravel::findOrFail($id);
        $user->delete();

        return redirect()->route('user_travel.index')->with('success', 'User deleted successfully.');
    }

    public function createTourLeader()
    {
        return view('user_travel.create_tour_leader'); // Pastikan view ini ada
    }

    public function storeTourLeader(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user_travel',
            'email' => 'required|email|max:255|unique:user_travel',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        try {
            $userTravel = new UserTravel();
            $userTravel->id = (string) Str::uuid(); // Menetapkan UUID sebagai ID
            $userTravel->fullname = $validatedData['fullname'];
            $userTravel->username = $validatedData['username'];
            $userTravel->email = $validatedData['email'];
            $userTravel->phone = $validatedData['phone'];
            $userTravel->role_id = 3; // Role ID default untuk tour leader
            $userTravel->password = bcrypt($validatedData['password']);
            $userTravel->save();

            return redirect()->route('user_travel.index')->with('success', 'Tour Leader created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create Tour Leader: ' . $e->getMessage());
        }
    }
}
