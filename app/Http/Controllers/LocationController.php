<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UserLocation;
use App\Entities\MLocation;
use App\Entities\MemberData;

class LocationController extends Controller
{
    public function showForm()
    {
        return view('Locations.form');
    }

    public function getLocations(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|string',
        ]);

        $userId = $validatedData['user_id'];

        // Ambil location_id berdasarkan user_id
        $userLocation = UserLocation::where('user_id', $userId)->first();

        if ($userLocation) {
            $locationId = $userLocation->location_id;

            // Ambil semua member data yang memiliki location_id yang sama
            $matchingMembers = MemberData::where('location_id', $locationId)->get();

            return view('locations.index', [
                'userId' => $userId,
                'locationId' => $locationId,
                'matchingMembers' => $matchingMembers,
            ]);
        }

        return view('locations.index', [
            'userId' => $userId,
            'locationId' => null,
            'matchingMembers' => collect(), // Kembalikan koleksi kosong
        ]);
    }
    
    public function create()
    {
        return view('layouts.admin.location_input');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|string|max:255',
            'brand_id' => 'required|uuid', // Ubah validasi di sini
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'add_stock_allowed' => 'required|boolean',
            'point_of_sale_allowed' => 'required|boolean',
            'created_by' => 'required|string|max:255',
            'updated_by' => 'required|string|max:255',
        ]);

        // Simpan data lokasi ke database
        MLocation::create([
            'business_id' => $request->business_id,
            'brand_id' => $request->brand_id, // Pastikan ini diubah
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'add_stock_allowed' => $request->add_stock_allowed,
            'point_of_sale_allowed' => $request->point_of_sale_allowed,
            'created_by' => $request->created_by,
            'updated_by' => $request->updated_by,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('location.create')->with('success', 'Lokasi berhasil disimpan!');
    }
}
