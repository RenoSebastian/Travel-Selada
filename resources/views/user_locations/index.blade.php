<!-- resources/views/user_locations/index.blade.php -->

@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>User Locations</h1>

    <!-- Notifikasi sukses -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
     <!-- Tombol untuk menambah user location -->
     <a href="{{ route('user_locations.create') }}" class="btn btn-primary mb-3">Tambah User Location</a>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Brand ID</th>
                <th>Location ID</th>
                <th>Location Name</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userLocations as $userLocation)
            <tr>
                <td>{{ $userLocation->id }}</td>
                <td>{{ $userLocation->user_id }}</td>
                <td>{{ $userLocation->brand_id }}</td>
                <td>{{ $userLocation->location_id }}</td>
                <td>{{ $userLocation->location->name ?? 'N/A' }}</td> <!-- Mengambil nama lokasi -->
                <td>{{ $userLocation->created_at }}</td>
                <td>{{ $userLocation->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination-wrapper">
        {{ $userLocations->links() }}
    </div>
</div>
@endsection
