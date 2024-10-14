@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Tambah Peserta Tour</h1>

    <form id="peserta-form" method="POST" action="{{ route('peserta_tour.store', $busId) }}">
        @csrf

        <input type="hidden" name="bus_id" value="{{ $busId }}">

        <div class="form-group">
            <label for="fullname">Nama Lengkap:</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Nomor Telepon:</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="seat">Seat:</label>
            <input type="text" name="seat" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('bus.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Debug session
    console.log('{{ session('success') }}');
    console.log('{{ session('error') }}');

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif
</script>

@endsection
