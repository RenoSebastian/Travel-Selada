@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Admin dashboard, where you can manage transactions, terminals, and agents.</p>

    <!-- Tambahkan tombol untuk mengarah ke Input Data Brand -->
    <a href="{{ route('brand.create') }}" class="btn btn-primary">Input Data Brand</a>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
@endsection
    