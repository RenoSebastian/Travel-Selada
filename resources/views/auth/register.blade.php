<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #2196F3, #81C784);
            color: #333;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 1em;
            color: #0D47A1;
            text-align: center;
        }

        form {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5em;
            border-radius: 8px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        label {
            display: block;
            margin-top: 1em;
            font-weight: bold;
            color: #0D47A1;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            margin-top: 0.5em;
            border: 1px solid #42A5F5;
            border-radius: 6px;
            font-size: 1em;
            background-color: #E3F2FD;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #1E88E5;
            outline: none;
            background-color: #E3F2FD;
        }

        button {
            margin-top: 1.5em;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            background-color: #0D47A1;
            color: white;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #1E88E5;
            transform: translateY(-2px);
        }

        .error-message {
            color: #D32F2F;
            font-size: 0.9em;
            margin-top: 0.5em;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 1.2em;
        }

        @media (max-width: 500px) {
            form {
                padding: 2em;
            }

            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <form action="{{ route('register') }}" method="POST">
        <h1>Register</h1>
        
        @csrf
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            @error('username')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
            @error('phone')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" value="{{ old('fullname') }}" required>
            @error('fullname')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="role_id">Role:</label>
            <select id="role_id" name="role_id" required>
                <option value="">Select Role</option>
                <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>Role 1</option>
                <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>Role 2</option>
                <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Role 3</option>
            </select>
            @error('role_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>