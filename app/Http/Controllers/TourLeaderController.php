<?php   

namespace App\Http\Controllers;

use App\Entities\PesertaTour;
use App\Entities\Bus;
use App\Entities\UserTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TourLeaderController extends Controller
{
    public function index()
    {
        // Ambil ID user yang login (Tour Leader)
        $userId = Auth::id();

        // Ambil user travel yang login dan id_bus yang mereka handle
        $userTravel = UserTravel::find($userId);

        // Jika user travel tidak memiliki bus, beri notifikasi dan catat log
        if (!$userTravel || !$userTravel->id_bus) {
            Log::warning('User dengan ID ' . $userId . ' tidak memiliki bus yang terdaftar.');
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki bus yang terdaftar.');
        }

        // Cari bus yang dihandle oleh user travel
        $bus = Bus::find($userTravel->id_bus);

        // Jika tidak ada bus, beri notifikasi dan catat log
        if (!$bus) {
            Log::error('Bus tidak ditemukan untuk user dengan ID ' . $userId . ' dan bus ID ' . $userTravel->id_bus);
            return redirect()->route('user.dashboard')->with('error', 'Bus tidak ditemukan.');
        }

        // Ambil daftar peserta tour berdasarkan bus_location (id bus)
        $pesertaTours = PesertaTour::where('bus_location', $bus->id)->get();

        if ($pesertaTours->isEmpty()) {
            Log::info('Tidak ada peserta tour ditemukan untuk bus ID ' . $bus->id);
        } else {
            Log::info('Peserta tour ditemukan untuk bus ID ' . $bus->id . ': ' . $pesertaTours->count() . ' peserta.');
        }

        // Format data peserta
        $pesertaData = $pesertaTours->map(function ($peserta) {
            return [
                'fullname' => $peserta->fullname,
                'phone' => $peserta->phone_number,
                'class' => $peserta->class,
                'status' => $peserta->status,
            ];
        });

        // Beri notifikasi keberhasilan
        return view('tour_leader.index', compact('bus', 'pesertaData'))
            ->with('success', 'Data peserta berhasil diambil.');
    }

    public function show($busId)
    {
        // Ambil ID user yang login (Tour Leader)
        $userId = Auth::id();

        // Ambil user travel yang login
        $userTravel = UserTravel::find($userId);

        // Verifikasi bahwa bus tersebut adalah bus yang dimiliki oleh user travel
        if ($userTravel->id_bus != $busId) {
            Log::warning('User dengan ID ' . $userId . ' mencoba mengakses bus yang tidak dimiliki. Bus ID: ' . $busId);
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak berhak melihat data bus ini.');
        }

        // Ambil bus yang dipilih
        $bus = Bus::findOrFail($busId);

        // Ambil daftar peserta yang ada di bus tersebut
        $pesertaTours = PesertaTour::where('bus_location', $busId)->get();

        if ($pesertaTours->isEmpty()) {
            Log::info('Tidak ada peserta tour ditemukan untuk bus ID ' . $busId);
        } else {
            Log::info('Peserta tour ditemukan untuk bus ID ' . $busId . ': ' . $pesertaTours->count() . ' peserta.');
        }

        // Format data peserta
        $pesertaData = $pesertaTours->map(function ($peserta) {
            return [
                'fullname' => $peserta->fullname,
                'phone' => $peserta->phone_number,
                'class' => $peserta->class,
                'status' => $peserta->status,
            ];
        });

        // Beri notifikasi keberhasilan
        return view('tour_leader.show', compact('bus', 'pesertaData'))
            ->with('success', 'Data peserta berhasil diambil.');
    }
}
