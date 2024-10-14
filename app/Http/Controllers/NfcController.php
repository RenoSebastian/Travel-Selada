<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use App\Entities\Absensi;
use App\Entities\UserLocation;
use App\Entities\PesertaTour;
use App\Entities\Bus;
use Illuminate\Support\Facades\Auth;
use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class NfcController extends Controller
{
    public function checkin(Request $request)
    {
        \Log::info('Request checkin received for tag_nfc: ' . $request->tag_nfc);
        $request->validate([
            'tag_nfc' => 'required|string',
        ]);
        $pesertaTour = PesertaTour::where('card_number', $request->tag_nfc)->first();
    
        if (!$pesertaTour) {
            \Log::warning('Participant not found for tag_nfc: ' . $request->tag_nfc);
            return response()->json([
                'message' => 'Participant not found.',
            ], 404);
        }
    
        \Log::info('Participant found:', [
            'participant_id' => $pesertaTour->id,
            'fullname' => $pesertaTour->fullname,
            'bus_location' => $pesertaTour->bus_location,
            'status' => $pesertaTour->status,
        ]);
    
        if ($pesertaTour->status == 1) {
            \Log::info('Participant already checked in with tag_nfc: ' . $request->tag_nfc);
            return response()->json([
                'message' => 'Sudah hadir',
            ], 200);
        }
    
        $pesertaTour->status = 1;
        $currentTimestamp = Carbon::now();
        $pesertaTour->updated_at = $currentTimestamp;
        $pesertaTour->save();
    
        Absensi::create([
            'id' => Str::uuid(),
            'participant_id' => $pesertaTour->id,
            'clock_in' => $currentTimestamp,
            'created_by' => null,
            'updated_by' => null, 
        ]);
    
        Log::info("Check-in successful for participant: " . $pesertaTour->fullname);
    
        return response()->json([
            'fullname' => $pesertaTour->fullname,
            'phone' => $pesertaTour->phone_number,
            'seat' => $pesertaTour->seat,
            'status' => 'HADIR',
            'card_number' => $pesertaTour->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(),
        ], 200);
    }

    public function checkout(Request $request)
    {
        \Log::info('Request checkout received for tag_nfc: ' . $request->tag_nfc);
        $request->validate([
            'tag_nfc' => 'required|string',
        ]);
        
        $pesertaTour = PesertaTour::where('card_number', $request->tag_nfc)->first();
        
        if (!$pesertaTour) {
            \Log::warning('Participant not found for tag_nfc: ' . $request->tag_nfc);
            return response()->json([
                'message' => 'Participant not found.',
            ], 404);
        }
        
        \Log::info('Participant found:', [
            'participant_id' => $pesertaTour->id,
            'fullname' => $pesertaTour->fullname,
            'bus_location' => $pesertaTour->bus_location,
            'status' => $pesertaTour->status,
        ]);
        
        if ($pesertaTour->status == 0) {
            \Log::info('Participant already checked out with tag_nfc: ' . $request->tag_nfc);
            return response()->json([
                'message' => 'Sudah Keluar',
            ], 200);
        }
        
        $pesertaTour->status = 0;
        $currentTimestamp = Carbon::now();
        $pesertaTour->updated_at = $currentTimestamp;

        $pesertaTour->clock_out = $currentTimestamp;

        $pesertaTour->save();

        Absensi::create([
            'id' => Str::uuid(),
            'participant_id' => $pesertaTour->id,
            'clock_in' => $pesertaTour->clock_in,
            'clock_out' => $currentTimestamp,
            'created_by' => null,
            'updated_by' => null, 
        ]);
        
        Log::info("Check-out successful for participant: " . $pesertaTour->fullname);
        
        return response()->json([
            'fullname' => $pesertaTour->fullname,
            'phone' => $pesertaTour->phone_number,
            'seat' => $pesertaTour->seat,
            'status' => 'Keluar',
            'card_number' => $pesertaTour->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(),
        ], 200);
    }
    
    public function checkoutAll(Request $request)
    {
        \Log::info('Request checkout all received for user_id: ' . $request->user_id);

        $request->validate([
            'user_id' => 'required|string',
        ]);

        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            \Log::error('User not found for user_id: ' . $request->user_id);
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        $idBus = $user->id_bus;  

        $pesertaTours = PesertaTour::where('bus_location', $idBus)
            ->where('status', 1)
            ->get();

        if ($pesertaTours->isEmpty()) {
            \Log::warning('No participants found for bus_location: ' . $idBus);
            return response()->json([
                'message' => 'No participants found for this bus location.',
            ], 404);
        }

        $currentTimestamp = Carbon::now();

        foreach ($pesertaTours as $pesertaTour) {
            \Log::info('Checking out participant:', [
                'participant_id' => $pesertaTour->id,
                'fullname' => $pesertaTour->fullname,
                'bus_location' => $pesertaTour->bus_location,
            ]);

            $pesertaTour->update([
                'status' => 0,
                'updated_at' => $currentTimestamp,
                'clock_out' => $currentTimestamp,
            ]);

            Absensi::create([
                'id' => Str::uuid(),
                'participant_id' => $pesertaTour->id,
                'clock_in' => $pesertaTour->clock_in,
                'clock_out' => $currentTimestamp,
                'created_by' => null,
                'updated_by' => null,
            ]);

            \Log::info("Check-out successful for participant: " . $pesertaTour->fullname);
        }

        return response()->json([
            'message' => 'All participants checked out successfully.',
            'checked_out_count' => $pesertaTours->count(),
            'timestamp' => $currentTimestamp->toDateTimeString(),
        ], 200);
    }
    
}
