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
            <select class="form-control" id="tipe_bus" name="tipe_bus" required>
                <option value="">Pilih Tipe Bus</option>
                @foreach($mbuses as $mbus)
                    <option value="{{ $mbus->id }}" {{ $bus->tipe_bus == $mbus->id ? 'selected' : '' }}>
                        {{ $mbus->kapasitas_bus }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tour_leader" class="form-label">Tour Leader</label>
            <select class="form-control" id="tour_leader" name="tour_leader" required>
                <option value="">Pilih Tour Leader</option>
                @foreach($user_travel as $tourlead)
                    <option value="{{ $tourlead->id }}" {{ $bus->tl_id == $tourlead->id ? 'selected' : '' }}>
                        {{ $tourlead->fullname }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Data Bus</button>
    </form>

    <h3 class="mt-4">Peserta Tour yang Terdaftar</h3>
    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addPesertaModal">Tambah Peserta Tour</button>

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
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus peserta ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $pesertaTours->links() }}

    <!-- Modal Tambah Peserta -->
    <div class="modal fade" id="addPesertaModal" tabindex="-1" aria-labelledby="addPesertaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPesertaModalLabel">Tambah Peserta Tour Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPesertaForm">
                        @csrf
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="seat" class="form-label">Tempat Duduk</label>
                            <input type="text" class="form-control" name="seat" required>
                        </div>
                        <input type="hidden" name="bus_id" value="{{ $bus->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="savePesertaBtn">Simpan Peserta</button>
                </div>
            </div>
        </div>
    </div>

</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#savePesertaBtn').on('click', function() {
        const formData = $('#addPesertaForm').serialize(); // Mengambil data form

        $.ajax({
    url: "{{ route('peserta_tour.store', ['bus_id' => $bus->id]) }}",
    method: 'POST',
    data: formData,
    success: function(response) {
        // Menutup modal
        $('#addPesertaModal').modal('hide');

        // Menambahkan baris baru ke tabel peserta
        $('tbody').append(`
            <tr>
                <td>${response.id}</td>
                <td>${response.fullname}</td>
                <td>${response.phone_number}</td>
                <td>${response.seat}</td>
                <td>
                    <form action="{{ route('peserta_tour.destroy', '') }}/${response.id}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus peserta ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        `);
    },
    error: function(xhr) {
        console.error(xhr.responseText); // Log kesalahan ke konsol
        alert('Gagal menambahkan peserta. Silakan coba lagi.');
    }
});

    });
});
</script>
@endsection

@endsection