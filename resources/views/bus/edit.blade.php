@extends('layouts.dashboard')

@section('title', 'Edit Data Bus')

@section('content')
<div class="container mt-4">
    <h2>Edit Data Bus</h2>

    <!-- Form untuk mengedit data bus -->
    <form action="{{ route('bus.update', $bus->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nama_bus" class="form-label">Nama Bus</label>
            <input type="text" class="form-control" id="nama_bus" name="nama_bus" value="{{ $bus->nama_bus }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat_penjemputan" class="form-label">Alamat Penjemputan</label>
            <input type="text" class="form-control" id="alamat_penjemputan" name="alamat_penjemputan" value="{{ $bus->alamat_penjemputan }}" required>
        </div>

        <div class="mb-3">
            <label for="tipe_bus" class="form-label">Tipe Bus</label>
            <input type="text" class="form-control" id="tipe_bus" name="tipe_bus" value="{{ $bus->tipe_bus }}" required>
        </div>

        <div class="mb-3">
            <label for="tour_leader" class="form-label">Tour Leader</label>
            <input type="text" class="form-control" id="tour_leader" name="tour_leader" value="{{ $bus->tour_leader }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Data Bus</button>
    </form>

    <!-- Tabel untuk menampilkan peserta tour yang sudah terdaftar di bus ini -->
    <h4 class="mt-5">Peserta Tour Terdaftar</h4>
    @if($pesertaTour->isEmpty())
        <p>Tidak ada peserta tour yang terdaftar di bus ini.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Seat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesertaTour as $peserta)
                    <tr>
                        <td>{{ $peserta->id }}</td>
                        <td>{{ $peserta->fullname }}</td>
                        <td>{{ $peserta->phone_number }}</td>
                        <td>{{ $peserta->status }}</td>
                        <td>{{ $peserta->seat }}</td>
                        <td>
                            <a href="{{ route('peserta_tour.edit', $peserta->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('peserta_tour.destroy', $peserta->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
