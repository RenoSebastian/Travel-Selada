<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Bus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Data Bus</h2>

        <!-- Tampilkan pesan sukses jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form input data bus -->
        <form action="{{ route('bus.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_bus" class="form-label">Nama Bus</label>
                <input type="text" class="form-control" id="nama_bus" name="nama_bus" value="{{ old('nama_bus') }}" required>
                @error('nama_bus')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}" required>
                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="tipe_bus" class="form-label">Tipe Bus</label>
                <select class="form-control" id="tipe_bus" name="tipe_bus" required>
                    <option value="">Pilih Tipe Bus</option>
                    @foreach($mbuses as $mbus)
                        <option value="{{ $mbus->id }}">{{ $mbus->tipe_bus }} (Kapasitas: {{ $mbus->kapasitas_bus }})</option>
                    @endforeach
                </select>
                @error('tipe_bus')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
