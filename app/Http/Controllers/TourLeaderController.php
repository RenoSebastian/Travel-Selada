<?php   

namespace App\Http\Controllers;

use App\Entities\PesertaTour;
use App\Entities\Bus;
use App\Entities\UserTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourLeaderController extends Controller
{
    public function index()
    {
        // Ambil ID user yang login (Tour Leader)
        $userId = Auth::id();

        // Ambil user travel yang login dan id_bus yang mereka handle
        $userTravel = UserTravel::where('id', $userId)->first();

        // Jika user travel tidak memiliki bus, beri notifikasi
        if (!$userTravel || !$userTravel->id_bus) {
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki bus yang terdaftar.');
        }

        // Cari bus yang dihandle oleh user travel
        $bus = Bus::where('id', $userTravel->id_bus)->first();

        // Jika tidak ada bus, beri notifikasi bahwa user belum memiliki bus
        if (!$bus) {
            return redirect()->route('user.dashboard')->with('error', 'Bus tidak ditemukan.');
        }

        // Ambil daftar peserta tour berdasarkan bus_location (id bus)
        $pesertaTours = PesertaTour::where('bus_location', $bus->id)->with('bus')->get();

        return view('tour_leader.index', compact('bus', 'pesertaTours'));
    }

    public function show($busId)
    {
        // Pastikan bus yang dipilih sesuai dengan bus yang dihandle oleh user travel yang login
        $userId = Auth::id();
        $userTravel = UserTravel::where('id', $userId)->first();

        // Verifikasi bahwa bus tersebut adalah bus yang dimiliki oleh user travel
        if ($userTravel->id_bus != $busId) {
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak berhak melihat data bus ini.');
        }

        // Ambil bus yang dipilih
        $bus = Bus::where('id', $busId)->firstOrFail();

        // Ambil daftar peserta yang ada di bus tersebut
        $pesertaTours = PesertaTour::where('bus_location', $busId)->with('bus')->get();

        return view('tour_leader.show', compact('bus', 'pesertaTours'));
    }
}
