@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Tambah Peserta Tour</h1>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <form action="{{ route('peserta_tour.store') }}" method="POST">
        @csrf

        <div id="peserta-container">
            <div class="peserta-form">
                <div class="form-group">
                    <label for="fullname">Nama Lengkap:</label>
                    <input type="text" name="fullname[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Nomor Telepon:</label>
                    <input type="text" name="phone_number[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="seat">Seat:</label>
                    <input type="text" name="seat[]" class="form-control" required>
                </div>
                <input type="hidden" name="bus_id" value="{{ $bus_id }}">
            </div>
        </div>

        <button type="button" class="btn btn-primary" id="add-peserta">Tambah Peserta</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    document.getElementById('add-peserta').addEventListener('click', function() {
        const container = document.getElementById('peserta-container');
        const pesertaForm = `
            <div class="peserta-form">
                <div class="form-group">
                    <label for="fullname">Nama Lengkap:</label>
                    <input type="text" name="fullname[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Nomor Telepon:</label>
                    <input type="text" name="phone_number[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="seat">seat:</label>
                    <input type="text" name="seat[]" class="form-control" required>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', pesertaForm);
    });
</script>
@endsection
