<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use App\Entities\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class NfcController extends Controller
{
    public function checkin(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'tag_nfc' => 'required|string',
            ]);

            Log::info("Request checkin received for tag_nfc: " . $request->tag_nfc);

            $member = Members::where('card_number', $request->tag_nfc)->first();

            if (!$member) {
                Log::warning("Member not found for tag_nfc: " . $request->tag_nfc);
                return response()->json([
                    'message' => 'Member not found.',
                ], 404);
            }

            // Jika status sudah 1, tidak perlu ubah lagi, kembalikan pesan
            if ($member->status == 1) {
                Log::info("Member already checked in with tag_nfc: " . $request->tag_nfc);
                return response()->json([
                    'message' => 'KAMU SUDAH HADIR GAUSAH CAPER',
                ], 200);
            }

            // Ubah status menjadi 1 (HADIR) dan simpan waktu checkin
            $member->status = 1;
            $currentTimestamp = Carbon::now();
            $member->updated_at = $currentTimestamp;
            $member->save();

            // Buat entri baru di tabel absensi dengan clock_in
            Absensi::create([
                'id' => Str::uuid(),
                'member_id' => $member->id,
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
            // Validasi input
            $request->validate([
                'tag_nfc' => 'required|string',
            ]);

            Log::info("Request checkout received for tag_nfc: " . $request->tag_nfc);

            $member = Members::where('card_number', $request->tag_nfc)->first();

            if (!$member) {
                Log::warning("Member not found for tag_nfc: " . $request->tag_nfc);
                return response()->json([
                    'message' => 'Member not found.',
                ], 404);
            }

            // Jika status sudah 0, tidak perlu ubah lagi, kembalikan pesan
            if ($member->status == 0) {
                Log::info("Member already checked out with tag_nfc: " . $request->tag_nfc);
                return response()->json([
                    'message' => 'KAMU SUDAH CHECKOUT GAUSAH CAPER',
                ], 200);
            }

            // Ubah status menjadi 0 (CHECKOUT) dan simpan waktu checkout
            $member->status = 0;
            $currentTimestamp = Carbon::now();
            $member->updated_at = $currentTimestamp;
            $member->save();

            // Cari entri absensi terakhir dan simpan clock_out
            $absensi = Absensi::where('member_id', $member->id)->orderBy('id', 'desc')->first();
            if ($absensi) {
                $absensi->clock_out = $currentTimestamp;
                $absensi->updated_by = 'system';
                $absensi->save();
            } else {
                Log::warning("Absensi entry not found for member: " . $member->fullname);
            }

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
}
