<!-- resources/views/layouts/admin/dashboard.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Admin dashboard, where you can manage transactions, terminals, and agents.</a>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
@endsection
