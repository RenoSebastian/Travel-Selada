@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Create New User Travel</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user_travel.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}" required>
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label for="role_id">Role:</label>
            <select name="role_id" class="form-control">
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        

        <div class="form-group">
            <label for="id_bus">Bus:</label>
            <select name="id_bus" class="form-control" required>
                <option value="">Select Bus</option>
                @foreach ($buses as $bus)
                    <option value="{{ $bus->id }}" {{ old('id_bus') == $bus->id ? 'selected' : '' }}>
                        {{ $bus->nama_bus }} (Kapasitas: {{ $bus->mbus->kapasitas_bus }})
                    </option>
                @endforeach
            </select>
        </div>




        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection
