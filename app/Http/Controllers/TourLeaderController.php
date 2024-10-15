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
        $userTravel = UserTravel::find($userId);

        // Jika user travel tidak memiliki bus, beri notifikasi
        if (!$userTravel || !$userTravel->id_bus) {
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki bus yang terdaftar.');
        }

        // Cari bus yang dihandle oleh user travel
        $bus = Bus::find($userTravel->id_bus);

        // Jika tidak ada bus, beri notifikasi bahwa user belum memiliki bus
        if (!$bus) {
            return redirect()->route('user.dashboard')->with('error', 'Bus tidak ditemukan.');
        }

        // Ambil daftar peserta tour berdasarkan bus_location (id bus)
        $pesertaTours = PesertaTour::where('bus_location', $bus->id)->get();

        // Format data peserta
        $pesertaData = $pesertaTours->map(function ($peserta) {
            return [
                'fullname' => $peserta->fullname,
                'phone' => $peserta->phone_number,
                'class' => $peserta->class,
                'status' => $peserta->status,
            ];
        });

        return view('tour_leader.index', compact('bus', 'pesertaData'));
    }

    public function show($busId)
    {
        // Ambil ID user yang login (Tour Leader)
        $userId = Auth::id();

        // Ambil user travel yang login
        $userTravel = UserTravel::find($userId);

        // Verifikasi bahwa bus tersebut adalah bus yang dimiliki oleh user travel
        if ($userTravel->id_bus != $busId) {
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak berhak melihat data bus ini.');
        }

        // Ambil bus yang dipilih
        $bus = Bus::findOrFail($busId);

        // Ambil daftar peserta yang ada di bus tersebut
        $pesertaTours = PesertaTour::where('bus_location', $busId)->get();

        // Format data peserta
        $pesertaData = $pesertaTours->map(function ($peserta) {
            return [
                'fullname' => $peserta->fullname,
                'phone' => $peserta->phone_number,
                'class' => $peserta->class,
                'status' => $peserta->status,
            ];
        });

        return view('tour_leader.show', compact('bus', 'pesertaData'));
    }
}
