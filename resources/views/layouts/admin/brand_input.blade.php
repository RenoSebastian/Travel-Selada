@extends('layouts.dashboard')

@section('title', 'Input Data Brand')

@section('content')
    <h1>Input Data Brand</h1>

    <form action="{{ route('brand.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="business_id">Business ID:</label>
            <input type="text" class="form-control" id="business_id" name="business_id" required>
        </div>
        
        <div class="form-group">
            <label for="name">Nama Brand:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi:</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="created_by">Dibuat Oleh:</label>
            <input type="text" class="form-control" id="created_by" name="created_by" required>
        </div>

        <div class="form-group">
            <label for="updated_by">Diperbarui Oleh:</label>
            <input type="text" class="form-control" id="updated_by" name="updated_by" required>
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
