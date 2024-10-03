<!DOCTYPE html>
<html>
<head>
    <title>Daftar Members</title>
</head>
<body>

    <h1>Daftar Members</h1>

    @if ($members->isEmpty())
        <p>Tidak ada data member yang ditemukan.</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Balance</th>
                    <th>Card Number</th> <!-- Kolom Card Number -->
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->fullname }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->balance }}</td>
                        <td>{{ $member->card_number }}</td> <!-- Menampilkan Card Number -->
                        <td>{{ $member->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ url('/') }}">Kembali ke Landing Page</a>

</body>
</html>
