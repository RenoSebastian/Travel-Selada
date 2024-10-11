@extends('layouts.dashboard')

@section('title', 'Data Tipe Bus')

@section('content')
    <div class="container mt-4">
        <h2>Data Tipe Bus</h2>

        <a href="{{ route('m_bus.create') }}" class="btn btn-primary mb-3">Tambah Data Tipe Bus</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kapasitas Bus</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mbuses as $mbus)
                    <tr>
                        <td>{{ $mbus->id }}</td>
                        <td>{{ $mbus->kapasitas_bus }}</td>
                        <td>
                            <a href="{{ route('m_bus.edit', $mbus->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('m_bus.destroy', $mbus->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
