@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Daftar Peserta Tour</h2>
    
    @if (isset($buses) && $buses->count() > 0)
        <a href="{{ route('peserta_tour.create', ['bus_id' => $buses[0]->id]) }}" class="btn btn-primary">Tambah Peserta</a>
    @else
        <p>Tidak ada bus yang tersedia.</p>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Nomor Telepon</th>
                <th>Nomor Kartu</th>
                <th>Bus Lokasi</th>
                <th>Status</th>
                <th>Tempat Duduk</th> 
                <th>Waktu Check-In</th> 
                <th>Waktu Check-Out</th> 
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesertaTours as $pesertaTour)
                <tr>
                    <td>{{ $pesertaTour->id }}</td>
                    <td>{{ $pesertaTour->fullname }}</td>
                    <td>{{ $pesertaTour->phone_number }}</td>
                    <td>{{ $pesertaTour->card_number }}</td>
                    <td>{{ $pesertaTour->bus->nama_bus ?? 'N/A' }}</td> <!-- Mengambil nama bus dari relasi -->
                    <td>{{ $pesertaTour->status }}</td>
                    <td>{{ $pesertaTour->seat }}</td>
                    <td>{{ $pesertaTour->clock_in ? $pesertaTour->clock_in->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>{{ $pesertaTour->clock_out ? $pesertaTour->clock_out->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('peserta_tour.edit', $pesertaTour->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('peserta_tour.destroy', $pesertaTour->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
