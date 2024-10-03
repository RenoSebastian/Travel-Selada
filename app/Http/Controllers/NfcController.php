<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members; // Model untuk tabel members

class NfcController extends Controller
{
    public function checkNfcTag(Request $request)
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

        // Jika ditemukan, kembalikan data member
        return response()->json([
            'fullname' => $member->fullname,
            'email' => $member->email,
            'phone' => $member->phone,
            'balance' => $member->balance,
            'status' => $member->status,
            'card_number' => $member->card_number,
            // Tambahkan data lainnya jika diperlukan
        ], 200);
    }
}
