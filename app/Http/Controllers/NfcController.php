<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use Carbon\Carbon;

class NfcController extends Controller
{
    public function checkin(Request $request)
{
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

    // Simpan data absensi (checkin)
    \App\Entities\Absensi::create([
        'member_id' => $member->id, // Simpan berdasarkan member_id dari tabel members
        'clock_in' => $currentTimestamp,
        'created_by' => 'system', // Atur siapa yang membuat (bisa diubah sesuai kebutuhan)
    ]);

    // Kembalikan data member dan waktu checkin
    return response()->json([
        'fullname' => $member->fullname,
        'email' => $member->email,
        'phone' => $member->phone,
        'balance' => $member->balance,
        'status' => 'HADIR',
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

    $member = Members::where('card_number', $request->tag_nfc)->first();

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

    // Jika status 1, ubah menjadi 0 (LOGOUT) dan simpan waktu checkout
    $member->status = 0;
    $currentTimestamp = Carbon::now();
    $member->updated_at = $currentTimestamp;
    $member->save();

    // Update data absensi dengan waktu checkout
    $absensi = \App\Entities\Absensi::where('member_id', $member->id)->orderBy('id', 'desc')->first();
    
    if ($absensi) {
        $absensi->clock_out = $currentTimestamp;
        $absensi->updated_by = 'system'; // Atur siapa yang mengupdate (bisa diubah sesuai kebutuhan)
        $absensi->save();
    }

    // Kembalikan data member dan waktu logout
    return response()->json([
        'fullname' => $member->fullname,
        'email' => $member->email,
        'phone' => $member->phone,
        'balance' => $member->balance,
        'status' => 'CHECKOUT',
        'card_number' => $member->card_number,
        'updated_at' => $currentTimestamp->toDateTimeString(), // Kembalikan waktu logout
    ], 200);
}
}
