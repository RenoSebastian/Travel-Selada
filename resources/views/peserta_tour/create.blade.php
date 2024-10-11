@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Tambah Peserta Tour</h1>

    <form id="peserta-form">
        @csrf

        <div id="peserta-container">
            <div class="peserta-form">
                <input type="hidden" name="bus" value="{{ $bus_id }}">
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
            </div>
        </div>

        <button type="button" class="btn btn-primary" id="add-peserta">Tambah Peserta</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<!-- Modal untuk Sisa Kapasitas -->
<div class="modal fade" id="capacityModal" tabindex="-1" role="dialog" aria-labelledby="capacityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="capacityModalLabel">Bus Penuh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bus telah penuh. Sisa kapasitas adalah <span id="remaining-capacity"></span> peserta.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-primary" id="continue-button">Lanjutkan</button>
            </div>
        </div>
    </div>
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
            if (pesertaForms.length > 1) {
                e.target.parentElement.remove();
            } else {
                alert('Minimal satu peserta harus ada!');
            }
        }
    });

    document.getElementById('peserta-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah pengiriman form default

        const formData = new FormData(this);

        fetch("{{ route('peserta_tour.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'full') {
                // Tampilkan modal dengan sisa kapasitas
                document.getElementById('remaining-capacity').innerText = data.sisaKapasitas;
                $('#capacityModal').modal('show');
            } else {
                // Tindakan jika berhasil
                window.location.href = "{{ route('bus.index') }}"; // Ganti ke URL yang sesuai
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    document.getElementById('continue-button').addEventListener('click', function() {
        // Tindakan untuk melanjutkan setelah pop-up
        alert('Anda memilih untuk melanjutkan.'); // Ganti dengan logika sesuai jika diperlukan
        $('#capacityModal').modal('hide'); // Menyembunyikan modal
    });
</script>
@endsection
