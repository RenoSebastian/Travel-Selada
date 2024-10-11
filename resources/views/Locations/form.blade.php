<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input User ID Peserta Tour</title>
</head>
<body>
    <h1>Input User ID Peserta Tour</h1>

    <form action="{{ route('peserta.index') }}" method="POST">
        @csrf
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" id="user_id" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
