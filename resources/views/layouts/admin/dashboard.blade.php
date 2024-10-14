@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Admin dashboard, where you can manage transactions, terminals, and agents.</p>
    <li class="nav-item">
                <a href="{{ route('user_travel.index') }}" class="btn btn-custom">Data User</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('m_bus.index') }}" class="btn btn-custom">MasterData BUS</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bus.index') }}" class="btn btn-custom">Data Bus</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="btn btn-custom">MasterData User</a>
            </li>   
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
@endsection
