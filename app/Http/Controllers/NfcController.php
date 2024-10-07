<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use Carbon\Carbon;

class NfcController extends Controller
{
    public function checkin(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'tag_nfc' => 'required|string',
            ]);
    
            $member = Members::where('card_number', $request->tag_nfc)->first();
    
            if (!$member) {
                return response()->json([
                    'message' => 'Member not found.',
                ], 404);
            }
    
            if ($member->status == 1) {
                return response()->json([
                    'message' => 'Member already checked in.',
                ], 200);
            }
    
            $member->status = 1;
            $currentTimestamp = Carbon::now();
            $member->updated_at = $currentTimestamp;
            $member->save();
    
            \App\Entities\Absensi::create([
                'member_id' => $member->id,
                'clock_in' => $currentTimestamp,
                'created_by' => 'system',
            ]);
    
            return response()->json([
                'fullname' => $member->fullname,
                'status' => 'HADIR',
                'updated_at' => $currentTimestamp->toDateTimeString(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function checkout(Request $request)
    {
        try {
            $request->validate([
                'tag_nfc' => 'required|string',
            ]);
    
            $member = Members::where('card_number', $request->tag_nfc)->first();
    
            if (!$member) {
                return response()->json([
                    'message' => 'Member not found.',
                ], 404);
            }
    
            if ($member->status == 0) {
                return response()->json([
                    'message' => 'Member already checked out.',
                ], 200);
            }
    
            $member->status = 0;
            $currentTimestamp = Carbon::now();
            $member->updated_at = $currentTimestamp;
            $member->save();
    
            $absensi = \App\Entities\Absensi::where('member_id', $member->id)->orderBy('id', 'desc')->first();
    
            if ($absensi) {
                $absensi->clock_out = $currentTimestamp;
                $absensi->updated_by = 'system';
                $absensi->save();
            }
    
            return response()->json([
                'fullname' => $member->fullname,
                'status' => 'CHECKOUT',
                'updated_at' => $currentTimestamp->toDateTimeString(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
