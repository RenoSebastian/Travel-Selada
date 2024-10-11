@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Tambah Peserta Tour</h1>

    <form action="{{ route('peserta_tour.store') }}" method="POST">
        @csrf

        <div id="peserta-container">
            <div class="peserta-form">
                <input type="hidden" name="bus_id" value="{{ $bus_id }}">
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
            </div>
        </div>
        <button type="button" class="btn btn-danger remove-peserta" style="display:none;">Hapus</button>
        <button type="button" class="btn btn-primary" id="add-peserta">Tambah Peserta</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    document.getElementById('add-peserta').addEventListener('click', function() {
        const container = document.getElementById('peserta-container');
        const pesertaForm = document.createElement('div');
        pesertaForm.classList.add('peserta-form');

        pesertaForm.innerHTML = `
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
            <button type="button" class="btn btn-danger remove-peserta">Hapus</button>
        `;
        
        container.appendChild(pesertaForm);
    });

    document.getElementById('peserta-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-peserta')) {
            const pesertaForms = document.querySelectorAll('.peserta-form');
            if (pesertaForms.length > 1) { // Pastikan lebih dari satu peserta
                e.target.parentElement.remove();
            } else {
                alert('Minimal satu peserta harus ada!');
            }
        }
    });
</script>
@endsection
