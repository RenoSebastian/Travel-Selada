<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta Tour</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Peserta Tour</h2>

        <form action="{{ route('peserta_tour.update', $pesertaTour->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Metode PUT untuk update -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $pesertaTour->fullname }}" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $pesertaTour->phone_number }}" required>
            </div>
            <div class="mb-3">
                <label for="card_number" class="form-label">Nomor Kartu</label>
                <input type="text" class="form-control" id="card_number" name="card_number" value="{{ $pesertaTour->card_number }}" required>
            </div>
            <div class="mb-3">
                <label for="bis_location" class="form-label">Lokasi Bus</label>
                <select class="form-control" id="bus_location" name="bus_location" required>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}" {{ $bus->id == $pesertaTour->bus_location ? 'selected' : '' }}>
                            {{ $bus->nama_bus }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="number" class="form-control" id="status" name="status" value="{{ $pesertaTour->status }}" required>
            </div>
            <div class="mb-3">
        <label for="seat" class="form-label">Tempat Duduk</label>
        <input type="text" class="form-control" id="seat" name="seat" value="{{ $pesertaTour->seat }}" required>
        </div>
        
        <div class="mb-3">
            <label for="clock_in" class="form-label">Waktu Check-In</label>
            <input type="datetime-local" class="form-control" id="clock_in" name="clock_in" value="{{ $pesertaTour->clock_in ? $pesertaTour->clock_in->format('Y-m-d\TH:i') : '' }}">
        </div>
        
        <div class="mb-3">
            <label for="clock_out" class="form-label">Waktu Check-Out</label>
            <input type="datetime-local" class="form-control" id="clock_out" name="clock_out" value="{{ $pesertaTour->clock_out ? $pesertaTour->clock_out->format('Y-m-d\TH:i') : '' }}">
        </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
