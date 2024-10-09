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
        // Validate incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|string',
        ]);

        $userId = $validatedData['user_id'];

        // Retrieve location_id based on user_id
        $userLocation = UserLocation::where('user_id', $userId)->first();

        if ($userLocation) {
            $locationId = $userLocation->location_id;

            // Retrieve all member data with the same location_id
            $matchingMembers = MemberData::where('location_id', $locationId)->get()->map(function ($member) {
                return [
                    'name' => $member->fullname,
                    'phone' => $member->phone,
                    'code' => $member->code,
                    'seat' => $member->name,
                ];
            });

            // Return JSON response with detailed data
            return response()->json([
                'status' => 'success',
                'data' => [
                    'userId' => $userId,
                    'locationId' => $locationId,
                    'matchingMembers' => $matchingMembers,
                ],
            ]);
        }

        // Return JSON response for no matching members
        return response()->json([
            'status' => 'success',
            'data' => [
                'userId' => $userId,
                'locationId' => null,
                'matchingMembers' => [],
            ],
        ]);
    }

}
