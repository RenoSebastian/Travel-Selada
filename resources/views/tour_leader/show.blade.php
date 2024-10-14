@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Daftar Peserta Tour - {{ $bus->nama_bus }}</h2>

    @if($pesertaTours->isEmpty())
        <p>Tidak ada peserta yang terdaftar di bus ini.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Nomor Telepon</th>
                    <th>Nomor Kursi</th>
                    <th>Status</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesertaTours as $peserta)
                    <tr>
                        <td>{{ $peserta->fullname }}</td>
                        <td>{{ $peserta->phone_number }}</td>
                        <td>{{ $peserta->seat }}</td>
                        <td>{{ $peserta->status == 1 ? 'Sudah Masuk' : 'Belum Masuk' }}</td>
                        <td>{{ $peserta->clock_in ?? 'N/A' }}</td>
                        <td>{{ $peserta->clock_out ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
