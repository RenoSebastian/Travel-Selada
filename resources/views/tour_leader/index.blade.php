@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Daftar Peserta Tour</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Bus yang Anda Kelola</h3>
        </div>
        <div class="card-body">
            @if($buses->isEmpty())
                <p>Anda tidak memiliki bus yang terdaftar.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Bus</th>
                            <th>Lokasi Penjemputan</th>
                            <th>Tipe Bus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buses as $bus)
                            <tr>
                                <td>{{ $bus->nama_bus }}</td>
                                <td>{{ $bus->alamat_penjemputan }}</td>
                                <td>{{ $bus->mbus->nama_tipe_bus ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('tour_leader.show', $bus->id) }}" class="btn btn-primary">Lihat Peserta</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
