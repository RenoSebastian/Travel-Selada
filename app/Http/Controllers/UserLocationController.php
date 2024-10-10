<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UserLocation;
use App\Entities\User;
use App\Entities\MLocation;
use Illuminate\Support\Str;

class UserLocationController extends Controller
{
    public function create()
    {
        // Ambil semua lokasi dari tabel MLocation
        $locations = MLocation::all();

        // Ambil semua user (tourguide)
        $users = User::where('is_active', true)->get();

        return view('user_locations.create', compact('locations', 'users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:m_locations,id',
        ]);

        try {
            // Buat UserLocation baru
            UserLocation::create([
                'id' => Str::uuid(),
                'user_id' => $request->user_id,
                'brand_id' => 65, // Set brand_id menjadi 65
                'location_id' => $request->location_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('user_locations.create')->with('success', 'User location berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('user_locations.create')->with('error', 'Terjadi kesalahan saat menambahkan user location: ' . $e->getMessage());
        }
    }

     // Metode untuk menampilkan daftar user locations
     public function index(Request $request)
     {
         // Mengambil semua user locations dengan pagination
         $userLocations = UserLocation::with(['location'])->paginate(10); // Menampilkan 10 entri per halaman
 
         return view('user_locations.index', compact('userLocations'));
     }
}
