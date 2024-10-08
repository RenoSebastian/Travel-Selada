<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Lokasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Input Data Lokasi</h1>

    <form action="{{ route('location.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="form-group">
                    <label for="business_id">Business ID:</label>
                    <input type="text" class="form-control" id="business_id" name="business_id" required placeholder="Masukkan UUID untuk Business ID">
                </div>

                <div class="form-group">
                    <label for="brand_id">Brand ID (UUID):</label>
                    <input type="text" class="form-control" id="brand_id" name="brand_id" required>
                </div>

                <div class="form-group">
                    <label for="name">Nama Lokasi:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="address">Alamat:</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="phone">Telepon:</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <label for="add_stock_allowed">Izinkan Penambahan Stok:</label>
                    <select class="form-control" id="add_stock_allowed" name="add_stock_allowed" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="point_of_sale_allowed">Izinkan Titik Penjualan:</label>
                    <select class="form-control" id="point_of_sale_allowed" name="point_of_sale_allowed" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="created_by">Dibuat Oleh:</label>
                    <input type="text" class="form-control" id="created_by" name="created_by" required>
                </div>

                <div class="form-group">
                    <label for="updated_by">Diperbarui Oleh:</label>
                    <input type="text" class="form-control" id="updated_by" name="updated_by" required>
                </div>

                <button type="submit" class="btn btn-success btn-block mt-3">Simpan</button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3 text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
