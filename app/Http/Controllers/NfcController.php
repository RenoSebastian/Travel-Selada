<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use App\Entities\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NfcController extends Controller
{
    public function checkin(Request $request)
    {
        // Validasi input
        $request->validate([
            'tag_nfc' => 'required|string',
        ]);

        // Cari data member berdasarkan TAG_NFC yang dikirim (disamakan dengan card_number)
        $member = Members::where('card_number', $request->tag_nfc)->first();

        // Jika tidak ditemukan, kirimkan pesan error
        if (!$member) {
            return response()->json([
                'message' => 'Member not found.',
            ], 404);
        }

        // Jika status sudah 1, tidak perlu ubah lagi, kembalikan pesan
        if ($member->status == 1) {
            return response()->json([
                'message' => 'KAMU SUDAH HADIR GAUSAH CAPER',
            ], 200);
        }

        // Jika status 0, ubah menjadi 1 (HADIR) dan simpan waktu checkin
        $member->status = 1;
        $currentTimestamp = Carbon::now();
        $member->updated_at = $currentTimestamp;
        $member->save();

        // Simpan data ke tabel absensi
        Absensi::create([
            'member_id' => $member->id, // Ambil ID dari member
            'clock_in' => $currentTimestamp, // Simpan waktu checkin
            'created_by' => 'system', // Set created_by
        ]);

        // Log the check-in event
        Log::info("Check-in successful for member ID: {$member->id} at {$currentTimestamp}");

        // Kembalikan data member dan waktu checkin
        return response()->json([
            'fullname' => $member->fullname,
            'email' => $member->email,
            'phone' => $member->phone,
            'balance' => $member->balance,
            'status' => 'HADIR', // Status diubah menjadi HADIR
            'card_number' => $member->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(), // Kembalikan waktu checkin
        ], 200);
    }

    public function checkout(Request $request)
    {
        // Validasi input
        $request->validate([
            'tag_nfc' => 'required|string',
        ]);

        // Cari data member berdasarkan TAG_NFC yang dikirim (disamakan dengan card_number)
        $member = Members::where('card_number', $request->tag_nfc)->first();

        // Jika tidak ditemukan, kirimkan pesan error
        if (!$member) {
            return response()->json([
                'message' => 'Member not found.',
            ], 404);
        }

        // Jika status sudah 0, tidak perlu ubah lagi, kembalikan pesan
        if ($member->status == 0) {
            return response()->json([
                'message' => 'KAMU SUDAH CHECKOUT GAUSAH CAPER',
            ], 200);
        }

        // Jika status 1, ubah menjadi 0 (LOGOUT) dan simpan waktu logout
        $member->status = 0;
        $currentTimestamp = Carbon::now();
        $member->updated_at = $currentTimestamp;
        $member->save();

        // Update absensi untuk member yang checkout
        $absensi = Absensi::where('member_id', $member->id)
            ->whereNull('clock_out') // Ambil data absensi yang belum checkout
            ->first();

        if ($absensi) {
            $absensi->clock_out = $currentTimestamp; // Simpan waktu checkout
            $absensi->save(); // Simpan perubahan

            // Log the check-out event
            Log::info("Check-out successful for member ID: {$member->id} at {$currentTimestamp}");
        } else {
            return response()->json([
                'message' => 'No check-in record found for checkout.',
            ], 404);
        }

        // Kembalikan data member dan waktu logout
        return response()->json([
            'fullname' => $member->fullname,
            'email' => $member->email,
            'phone' => $member->phone,
            'balance' => $member->balance,
            'status' => 'CHECKOUT', // Status diubah menjadi LOGOUT
            'card_number' => $member->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(), // Kembalikan waktu logout
        ], 200);
    }
}
