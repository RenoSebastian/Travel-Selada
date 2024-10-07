<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Members;
use App\Entities\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NfcController extends Controller
{

    private function parseUUID($id)
    {
        // Cek apakah ID yang diberikan sesuai dengan format UUID
        if (strpos($id, '-') !== false) {
            // Jika ada tanda '-', asumsikan sudah benar dan return apa adanya
            return $id;
        }
    
        // Jika tidak ada tanda '-', buat string UUID yang valid (ini hanya contoh)
        // Pisahkan bagian-bagian UUID berdasarkan panjang karakter UUID (8-4-4-4-12)
        return substr($id, 0, 8) . '-' . substr($id, 8, 4) . '-' . substr($id, 12, 4) . '-' . substr($id, 16, 4) . '-' . substr($id, 20);
    }
    

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

            $member_id = $this->parseUUID($member->id); // Gunakan parseUUID

            // Buat entri baru di tabel absensi dengan clock_in
            Absensi::create([
            'id' => Str::uuid(), // Generate UUID untuk ID
            'member_id' => $member_id, // Gunakan id UUID penuh dari tabel members
            'clock_in' => $currentTimestamp,
            'created_by' => 'system', // Atur siapa yang membuat (bisa diubah sesuai kebutuhan)
            'updated_at' => $currentTimestamp,
            'created_at' => $currentTimestamp,
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

            $member_id = $this->parseUUID($member->id); // Gunakan parseUUID

            // Buat entri baru di tabel absensi dengan clock_out
            Absensi::create([
            'id' => Str::uuid(), // Generate UUID untuk ID
            'member_id' => $member_id, // Gunakan id UUID penuh dari tabel members
            'clock_in' => $currentTimestamp,
            'created_by' => 'system', // Atur siapa yang membuat (bisa diubah sesuai kebutuhan)
            'updated_at' => $currentTimestamp,
            'created_at' => $currentTimestamp,
            ]);

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
