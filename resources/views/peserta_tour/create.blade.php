@extends('layouts.dashboard')

@section('title', 'Registrasi Peserta Tour')

@section('content')
    <div class="container mt-4">
        <h2>Registrasi Peserta Tour untuk Bus {{ $bus->nama_bus }}</h2>

        <form action="{{ route('peserta_tour.store') }}" method="POST">
            @csrf
            <input type="hidden" name="bus_location" value="{{ $bus->id }}">

            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
            </div>

            <div class="form-group">
                <label for="seat">Seat:</label>
                <input type="text" name="seat" class="form-control" value="{{ old('seat') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Peserta</button>
        </form>
    </div>
@endsection
