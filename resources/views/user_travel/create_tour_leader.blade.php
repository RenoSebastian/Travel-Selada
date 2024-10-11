@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Input Tour Leader</h1>

    <form action="{{ route('user_travel.store_tour_leader') }}" method="POST" id="tourLeaderForm">
        @csrf
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" class="form-control" name="fullname" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Tour Leader</button>
    </form>
</div>

<script>
    document.getElementById('tourLeaderForm').onsubmit = function(event) {
        event.preventDefault(); // Mencegah form dari pengiriman default
        swal({
            title: "Are you sure?",
            text: "Do you want to create this tour leader?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, create it!"
        }).then((result) => {
            if (result.value) {
                this.submit(); // Mengirimkan form jika konfirmasi
            }
        });
    }
</script>

@if (session('error'))
    <script>
        swal("Error", "{{ session('error') }}", "error");
    </script>
@endif

@if (session('success'))
    <script>
        swal("Success", "{{ session('success') }}", "success");
    </script>
@endif

@endsection
