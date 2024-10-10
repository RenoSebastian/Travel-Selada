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
            background: linear-gradient(to right, #d1c4e9, #b39ddb);
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 1em;
            color: #333;
        }

        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2.5em;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
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
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-top: 0.5em;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border: 1px solid #6a1b9a;
            outline: none;
        }

        button {
            margin-top: 1.5em;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            background-color: #6a1b9a;
            color: white;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #4a148c;
            transform: translateY(-2px);
        }

        div {
            color: red;
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
    </form>
</body>
</html>
