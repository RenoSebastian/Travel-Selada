@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Admin dashboard, where you can manage transactions, terminals, and agents.</p>

    <a href="{{ route('location.create') }}" class="btn btn-primary">Input Data Brand</a>

    <a href="{{ route('users.create') }}" class="btn btn-primary">Input User</a>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
@endsection
