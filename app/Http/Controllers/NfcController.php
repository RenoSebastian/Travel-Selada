<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use App\Entities\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Log;

class NfcController extends Controller
{
    public function checkin(Request $request)
    {
        // Validate input
        $request->validate([
            'tag_nfc' => 'required|string',
        ]);

        // Find member data based on TAG_NFC which is the card_number
        $member = Members::where('card_number', $request->tag_nfc)->first();

        // If not found, return an error message
        if (!$member) {
            Log::error("Member not found for tag: {$request->tag_nfc}");
            return response()->json(['message' => 'Member not found.'], 404);
        }

        // If status is already 1 (present), return a message
        if ($member->status == 1) {
            return response()->json(['message' => 'KAMU SUDAH HADIR GAUSAH CAPER'], 200);
        }

        // Update member status to present (1) and save check-in time
        $member->status = 1;
        $currentTimestamp = Carbon::now();
        $member->updated_at = $currentTimestamp;
        $member->save();

        // Create a new attendance record
        Absensi::create([
            'member_id' => $member->id, // This should be a UUID
            'clock_in' => $currentTimestamp,
            'created_by' => 'system', // Or however you determine the creator
            'updated_at' => $currentTimestamp,
            'created_at' => $currentTimestamp,
        ]);

        // Return member data and check-in time
        return response()->json([
            'fullname' => $member->fullname,
            'email' => $member->email,
            'phone' => $member->phone,
            'balance' => $member->balance,
            'status' => 'HADIR', // Status changed to HADIR
            'card_number' => $member->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(), // Return check-in time
        ], 200);
    }

    public function checkout(Request $request)
    {
        // Validate input
        $request->validate([
            'tag_nfc' => 'required|string',
        ]);

        // Find member data based on TAG_NFC which is the card_number
        $member = Members::where('card_number', $request->tag_nfc)->first();

        // If not found, return an error message
        if (!$member) {
            Log::error("Member not found for tag: {$request->tag_nfc}");
            return response()->json(['message' => 'Member not found.'], 404);
        }

        // Find the attendance record for this member that is not checked out
        $absensi = Absensi::where('member_id', $member->id)
            ->whereNull('clock_out')
            ->first();

        // If no active attendance record, return an error message
        if (!$absensi) {
            return response()->json(['message' => 'No active check-in found for this member.'], 404);
        }

        // If status is already 0 (not present), return a message
        if ($member->status == 0) {
            return response()->json(['message' => 'KAMU SUDAH CHECKOUT GAUSAH CAPER'], 200);
        }

        // Update member status to not present (0) and save check-out time
        $member->status = 0;
        $currentTimestamp = Carbon::now();
        $member->updated_at = $currentTimestamp;
        $member->save();

        // Update the attendance record with clock out time
        $absensi->clock_out = $currentTimestamp;
        $absensi->updated_at = $currentTimestamp;
        $absensi->save();

        // Return member data and check-out time
        return response()->json([
            'fullname' => $member->fullname,
            'email' => $member->email,
            'phone' => $member->phone,
            'balance' => $member->balance,
            'status' => 'CHECKOUT', // Status changed to CHECKOUT
            'card_number' => $member->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(), // Return check-out time
        ], 200);
    }
}