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
    
        // Cari entri absensi terbaru berdasarkan member_id
        $absensi = \App\Entities\Absensi::where('member_id', $member->id)->orderBy('id', 'desc')->first();
    
        // Jika entri absensi sudah ada dan clock_in masih kosong, perbarui clock_in
        if ($absensi && is_null($absensi->clock_in)) {
            $absensi->clock_in = $currentTimestamp;
            $absensi->updated_by = 'system';
            $absensi->save();
        } else {
            // Jika belum ada entri absensi, buat entri baru dengan clock_in
            \App\Entities\Absensi::create([
                'member_id' => $member->id,
                'clock_in' => $currentTimestamp,
                'created_by' => 'system',
            ]);
        }
    
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
        
        // Jika absensi ditemukan, update clock_out
        if ($absensi && is_null($absensi->clock_out)) {
            $absensi->clock_out = $currentTimestamp;
            $absensi->updated_by = 'system';
            $absensi->save();
        } else {
            // Jika tidak ada entri absensi yang cocok atau clock_out sudah diisi, kembalikan pesan error
            return response()->json([
                'message' => 'Absensi tidak ditemukan atau sudah di-checkout.',
            ], 400);
        }

        // Kembalikan data member dan waktu checkout
        return response()->json([
            'fullname' => $member->fullname,
            'email' => $member->email,
            'phone' => $member->phone,
            'balance' => $member->balance,
            'status' => 'CHECKOUT',
            'card_number' => $member->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(), // Kembalikan waktu checkout
        ], 200);
    }

}
