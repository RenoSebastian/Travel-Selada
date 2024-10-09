<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UserLocation;
use App\Entities\MemberData;

class LocationController extends Controller
{
    public function showForm()
    {
        return view('locations.form');
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
}
