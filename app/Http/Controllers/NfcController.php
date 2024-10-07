<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use Carbon\Carbon;
use App\Entities\Absensi;

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
    
        // Cari entri absensi berdasarkan member_id yang cocok dengan id di tabel members
        $absensi = Absensi::where('member_id', $member->id)->orderBy('id', 'desc')->first();
    
        // Jika absensi ditemukan, update clock_in
        if ($absensi) {
            $absensi->clock_in = $currentTimestamp;
            $absensi->updated_by = 'system';
            $absensi->save();
        } else {
            return response()->json([
                'message' => 'Absensi tidak ditemukan.',
            ], 404);
        }
    
        // Kembalikan data member dan waktu checkin
        return response()->json([
            'fullname' => $member->fullname,
            'email' => $member->email,
            'phone' => $member->phone,
            'balance' => $member->balance,
            'status' => 'HADIR',
            'card_number' => $member->card_number,
            'updated_at' => $currentTimestamp->toDateTimeString(),
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

        // Jika status 1, ubah menjadi 0 (CHECKOUT) dan simpan waktu checkout
        $member->status = 0;
        $currentTimestamp = Carbon::now();
        $member->updated_at = $currentTimestamp;
        $member->save();

        // Cari entri absensi berdasarkan member_id yang cocok dengan id di tabel members
        $absensi =Absensi::where('member_id', $member->id)->orderBy('id', 'desc')->first();

        // Jika absensi ditemukan, update clock_out
        if ($absensi && is_null($absensi->clock_out)) {
            $absensi->clock_out = $currentTimestamp;
            $absensi->updated_by = 'system';
            $absensi->save();
        } else {
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
            'updated_at' => $currentTimestamp->toDateTimeString(),
        ], 200);
    }

}
