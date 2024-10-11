<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #2196F3, #64B5F6);
            color: #333;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 1em;
            color: #1A237E;
        }

        form {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5em;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 1em;
            text-align: left;
            color: #1A237E;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-top: 0.5em;
            border: 1px solid #BBDEFB;
            border-radius: 8px;
            font-size: 1em;
            transition: border 0.3s;
            background-color: #E3F2FD;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border: 1px solid #1976D2;
            outline: none;
            background-color: #E1F5FE;
        }

        button {
            margin-top: 1.5em;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            background-color: #1E88E5;
            color: white;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #1565C0;
            transform: translateY(-2px);
        }

        .register-button {
            margin-top: 1em;
            padding: 12px;
            width: 100%;
            display: inline-block;
            text-align: center;
            border-radius: 8px;
            background-color: #64B5F6;
            color: white;
            font-size: 1.1em;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .register-button:hover {
            background-color: #42A5F5;
            transform: translateY(-2px);
        }

        div {
            color: #D32F2F;
            margin-bottom: 1em;
            font-weight: bold;
        }

        @media (max-width: 500px) {
            h1 {
                font-size: 2em;
            }

            form {
                padding: 2em;
            }

            button {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <form action="{{ route('login.post') }}" method="POST">
        <h1>Login</h1>
        
        @csrf
        @if ($errors->any())
            <div>
                <strong>{{ $errors->first() }}</strong>
            </div>
        @endif

        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>

        <a href="{{ route('register.form') }}" class="register-button">Register</a>
    </form>
</body>
</html>
