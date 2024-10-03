<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .centered-button {
            text-align: center;
        }
        .centered-button button {
            padding: 15px 30px;
            font-size: 18px;
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
        }
        .centered-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="centered-button">
        <button onclick="window.location.href='/members';">Lihat Data Members</button>
    </div>

</body>
</html>
