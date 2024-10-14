@extends('layouts.dashboard-tourlead')

@section('content')
<div class="container">
    <h1>Detail Bus</h1>

    {{-- Tampilkan informasi detail bus --}}
    <h2>Bus: {{ $bus->nama_bus }} (ID: {{ $bus->id }})</h2>
    <p>Alamat Penjemputan: {{ $bus->alamat_penjemputan }}</p>
    <p>Tipe Bus: {{ $bus->mbus->tipe_bus }} (Kapasitas: {{ $bus->mbus->kapasitas_bus }})</p>

    {{-- Tampilkan daftar peserta tour --}}
    <h3>Peserta Tour:</h3>
    @if($pesertaTours->isEmpty())
        <p>Tidak ada peserta yang terdaftar di bus ini.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Nomor Telepon</th>
                    <th>Nomor Kartu</th>
                    <th>Status</th>
                    <th>Nomor Kursi</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesertaTours as $peserta)
                    <tr>
                        <td>{{ $peserta->fullname }}</td>
                        <td>{{ $peserta->phone_number }}</td>
                        <td>{{ $peserta->card_number }}</td>
                        <td>{{ $peserta->status }}</td>
                        <td>{{ $peserta->seat }}</td>
                        <td>{{ $peserta->clock_in ? $peserta->clock_in : 'Belum Masuk' }}</td>
                        <td>{{ $peserta->clock_out ? $peserta->clock_out : 'Belum Keluar' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Tombol kembali ke daftar bus --}}
    <a href="{{ route('tour_leader.index') }}" class="btn btn-primary">Kembali ke Daftar Bus</a>
</div>
@endsection
