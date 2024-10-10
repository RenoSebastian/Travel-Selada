<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Data Bus</h2>

        <!-- Tabel untuk data dari tabel bus -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Bus</th>
                    <th>Alamat</th>
                    <th>Tipe Bus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                <tr>
                    <td>{{ $bus->id }}</td>
                    <td>{{ $bus->nama_bus }}</td>
                    <td>{{ $bus->alamat }}</td>
                    <td>{{ $bus->tipe_bus }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Data MBus</h2>

        <!-- Tabel untuk data dari tabel m_bus -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kapasitas Bus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mbuses as $mbus)
                <tr>
                    <td>{{ $mbus->id }}</td>
                    <td>{{ $mbus->kapasitas_bus }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
