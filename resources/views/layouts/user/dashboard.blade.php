@extends('layouts.dashboard-tourlead')

@section('title', 'User Dashboard')

@section('content')
    <h1>Tour Leader Dashboard</h1>
    <p>selamat datang Tour leader.</p>
    <li class="nav-item">
        <a href="{{ route('tour_leader.index') }}" class="btn btn-custom">data peserta tour</a>
    </li>
@endsection
