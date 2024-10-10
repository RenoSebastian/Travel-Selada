@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Admin dashboard, where you can manage transactions, terminals, and agents.</p>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
@endsection
