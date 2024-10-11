@extends('layouts.dashboard')

@section('title', 'Data Bus')

@section('content')
    <div class="container mt-4">
        <h2>Data Bus</h2>
        <a href="{{ route('bus.create') }}" class="btn btn-primary mb-3">Tambah Data Bus</a>

        <!-- Tabel untuk data dari tabel bus -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Bus</th>
                    <th>Alamat</th>
                    <th>Tipe Bus</th>
                    <th>Tour Leader</th>
                    <th>Action</th> <!-- Kolom untuk Action -->
                </tr>
            </thead>
            <tbody>
            @foreach($buses as $bus)
                @foreach($mbuses as $mbus)
                    @foreach($user_travel as $tourlead)
                        @if($bus->tipe_bus == $mbus->id && $bus->tl_id == $tourlead->id)
                            <tr>
                                <td>{{ $bus->id }}</td>
                                <td>{{ $bus->nama_bus }}</td>
                                <td>{{ $bus->alamat_penjemputan }}</td>
                                <td>{{ $mbus->kapasitas_bus }}</td>
                                <td>{{ $tourlead->fullname }}</td>
                                <td>
                                    <a href="{{ route('bus.edit', $bus->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('bus.destroy', $bus->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <a href="{{ route('peserta_tour.create', $bus->id) }}" class="btn btn-info">Registrasi</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
