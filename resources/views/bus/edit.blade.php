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

    <h3 class="mt-4">Peserta Tour yang Terdaftar</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>No. Telepon</th>
                <th>Tempat Duduk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesertaTours as $pesertaTour)
                <tr>
                    <td>{{ $pesertaTour->id }}</td>
                    <td>{{ $pesertaTour->fullname }}</td>
                    <td>{{ $pesertaTour->phone_number }}</td>
                    <td>{{ $pesertaTour->seat }}</td>
                    <td>
                        <form action="{{ route('peserta_tour.destroy', $pesertaTour->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mt-4">Tambah Peserta Tour Baru</h3>
    <form id="addPesertaForm">
        @csrf
        <table class="table table-bordered" id="pesertaTable">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>No. Telepon</th>
                    <th>Tempat Duduk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="fullname[]" class="form-control" required></td>
                    <td><input type="text" name="phone_number[]" class="form-control" required></td>
                    <td><input type="text" name="seat[]" class="form-control" required></td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeRow(this)">Hapus</button>
                        <button type="button" class="btn btn-success" onclick="addPesertaRow(this)">Tambah Peserta</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-success mt-2">Simpan Peserta</button>
    </form>
</div>

<script>
    function addPesertaRow(button) {
        const row = button.closest('tr');
        const inputs = row.querySelectorAll('input');

        // Cek apakah semua input pada baris yang aktif sudah terisi
        const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');

        if (allFilled) {
            const tableBody = document.querySelector('#pesertaTable tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="fullname[]" class="form-control" required></td>
                <td><input type="text" name="phone_number[]" class="form-control" required></td>
                <td><input type="text" name="seat[]" class="form-control" required></td>
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">Hapus</button>
                <button type="button" class="btn btn-success" onclick="addPesertaRow(this)">Tambah Peserta</button>
            `;
            tableBody.appendChild(newRow);
        } else {
            alert('Harap lengkapi semua input sebelum menambahkan peserta baru.');
        }
    }

    function removeRow(button) {
        const row = button.parentElement.parentElement;
        row.remove();
    }
</script>
@endsection