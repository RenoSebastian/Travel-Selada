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
    
        // Fetch location_id based on user_id
        $userLocation = UserLocation::where('user_id', $userId)->first();
    
        if ($userLocation) {
            $locationId = $userLocation->location_id;
    
            // Fetch all member data that have the same location_id
            $matchingMembers = MemberData::where('location_id', $locationId)->get();
    
            return response()->json([
                'user_id' => $userId,
                'location_id' => $locationId,
                'data' => $matchingMembers, // Return the member data
            ]);
        }
    
        return response()->json([
            'user_id' => $userId,
            'location_id' => null,
            'data' => [], // Return an empty array if no members found
        ]);
    }    
}
