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
        try {
            Log::info('Request checkin received for tag_nfc: ' . $request->tag_nfc);

            // Validasi input
            $request->validate([
                'tag_nfc' => 'required|string',
            ]);

            // Cari member berdasarkan card_number yang cocok dengan tag_nfc
            $member = Members::where('card_number', $request->tag_nfc)->first();

            if (!$member) {
                Log::warning('Member not found for tag_nfc: ' . $request->tag_nfc);
                return response()->json([
                    'message' => 'Member not found.',
                ], 404);
            }

            // Pastikan kita meng-cast member_id dengan UUID parser
            $member_id = $this->parseUUID($member->id); // Gunakan parseUUID

            // Ubah status menjadi 1 (HADIR) dan simpan waktu checkin
            $member->status = 1;
            $currentTimestamp = Carbon::now();
            $member->updated_at = $currentTimestamp;
            $member->save();

            // Buat entri baru di tabel absensi dengan clock_in
            Absensi::create([
                'id' => Str::uuid(), // Generate UUID untuk ID
                'member_id' => $member_id, // Gunakan member_id yang diparse
                'clock_in' => $currentTimestamp,
                'created_by' => 'system',
            ]);

            Log::info("Checkin successful for member: " . $member->fullname);

            return response()->json([
                'fullname' => $member->fullname,
                'email' => $member->email,
                'phone' => $member->phone,
                'balance' => $member->balance,
                'status' => 'HADIR',
                'card_number' => $member->card_number,
                'updated_at' => $currentTimestamp->toDateTimeString(),
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error in checkin for tag_nfc: " . $request->tag_nfc . " - " . $e->getMessage());
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkout(Request $request)
    {
        try {
            Log::info('Request checkout received for tag_nfc: ' . $request->tag_nfc);

            // Validasi input
            $request->validate([
                'tag_nfc' => 'required|string',
            ]);

            $member = Members::where('card_number', $request->tag_nfc)->first();

            if (!$member) {
                Log::warning('Member not found for tag_nfc: ' . $request->tag_nfc);
                return response()->json([
                    'message' => 'Member not found.',
                ], 404);
            }

            // Pastikan kita meng-cast member_id dengan UUID parser
            $member_id = $this->parseUUID($member->id); // Gunakan parseUUID

            // Ubah status menjadi 0 (CHECKOUT) dan simpan waktu checkout
            $member->status = 0;
            $currentTimestamp = Carbon::now();
            $member->updated_at = $currentTimestamp;
            $member->save();

            // Buat entri baru di tabel absensi dengan clock_out
            Absensi::create([
                'id' => Str::uuid(),
                'member_id' => $member_id,
                'clock_out' => $currentTimestamp,
                'created_by' => 'system',
            ]);

            Log::info("Checkout successful for member: " . $member->fullname);

            return response()->json([
                'fullname' => $member->fullname,
                'email' => $member->email,
                'phone' => $member->phone,
                'balance' => $member->balance,
                'status' => 'CHECKOUT',
                'card_number' => $member->card_number,
                'updated_at' => $currentTimestamp->toDateTimeString(),
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error in checkout for tag_nfc: " . $request->tag_nfc . " - " . $e->getMessage());
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function parseUUID($id)
    {
        if (strpos($id, '-') !== false) {
            return $id;
        }
        return substr($id, 0, 8) . '-' . substr($id, 8, 4) . '-' . substr($id, 12, 4) . '-' . substr($id, 16, 4) . '-' . substr($id, 20);
    }
}
