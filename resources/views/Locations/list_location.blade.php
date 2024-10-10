<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lokasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
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
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
