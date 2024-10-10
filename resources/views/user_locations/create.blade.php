<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input User Location</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Input User Location</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user_locations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">Tourguide:</label>
            <select name="user_id" class="form-control" required>
                <option value="">Pilih Tourguide</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="location_id">Lokasi:</label>
            <select name="location_id" class="form-control" required>
                <option value="">Pilih Lokasi</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->id }} | {{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
