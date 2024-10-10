<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tipe Bus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
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
                    <th>Tipe Bus</th>
                    <th>Kapasitas Bus</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mbuses as $mbus)
                    <tr>
                        <td>{{ $mbus->id }}</td>
                        <td>{{ $mbus->tipe_bus }}</td>
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

    <!-- Script untuk SweetAlert -->
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
</body>
</html>
