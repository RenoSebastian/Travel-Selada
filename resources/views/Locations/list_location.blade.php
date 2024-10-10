@extends('layouts.dashboard')

@section('title', 'Daftar Lokasi')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Daftar Lokasi</h1>

    <div class="text-right mb-3">
        <a href="{{ route('location.create') }}" class="btn btn-primary">Tambah Lokasi</a>
    </div>

    @if($locations->isEmpty())
        <div class="alert alert-warning text-center">Tidak ada lokasi yang tersedia.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Business ID</th>
                    <th>Brand ID</th>
                    <th>Nama Lokasi</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Stok Diizinkan</th>
                    <th>Titik Penjualan Diizinkan</th>
                    <th>Dibuat Oleh</th>
                    <th>Diperbarui Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                    <tr>
                        <td>{{ $location->business_id }}</td>
                        <td>{{ $location->brand_id }}</td>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->address }}</td>
                        <td>{{ $location->email }}</td>
                        <td>{{ $location->phone }}</td>
                        <td>{{ $location->add_stock_allowed ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $location->point_of_sale_allowed ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $location->created_by }}</td>
                        <td>{{ $location->updated_by }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
                <form method="GET" action="{{ route('location.index') }}" class="form-inline">
                    <label for="per_page" class="mr-2">Tampilkan:</label>
                    <select name="per_page" id="per_page" class="form-control mr-2" onchange="this.form.submit()">
                        <option value="5" {{ request('per_page') == 10 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 20 ? 'selected' : '' }}>10</option>
                    <select>
                    <label for="per_page" class="mr-2">data</label>
                </form>
            </div>
            <div class="col-md-6 text-right">
                {{ $locations->links() }} <!-- Pagination links -->
            </div>
        </div>
    @endif
</div>
@endsection
