@extends('layouts.dashboard')

@section('title', 'Input Data Brand')

@section('content')
    <h1>Input Data Brand</h1>

    <form action="{{ route('brand.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="brand_name">Nama Brand:</label>
            <input type="text" class="form-control" id="brand_name" name="brand_name" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
@endsection
