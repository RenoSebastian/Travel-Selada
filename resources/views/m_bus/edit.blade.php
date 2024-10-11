<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Tipe Bus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Data Tipe Bus</h2>

        <!-- Form edit data m_bus -->
        <form action="{{ route('m_bus.update', $mbus->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Method spoofing untuk PUT -->

            <div class="mb-3">
                <label for="kapasitas_bus" class="form-label">Kapasitas Bus</label>
                <input type="number" class="form-control" id="kapasitas_bus" name="kapasitas_bus" value="{{ old('kapasitas_bus', $mbus->kapasitas_bus) }}" required>
                @error('kapasitas_bus')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
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

</body>
</html>
