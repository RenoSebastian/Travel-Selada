@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Edit User Travel</h2>

    <!-- Menampilkan flash message untuk berhasil atau gagal -->
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

    <form action="{{ route('user_travel.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Menggunakan PUT untuk update data -->

        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $user->fullname) }}" required>
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password (Kosongkan jika tidak ingin mengubah):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="form-group">
            <label for="role_id">Role:</label>
            <select name="role_id" class="form-control">
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
