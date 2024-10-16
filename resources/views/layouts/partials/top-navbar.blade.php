<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Navbar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .navbar {
            background-color: #03A9F4; /* Lighter blue color */
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white;
        }

        .nav-link {
            color: white;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffdd57; /* Yellow hover color for contrast */
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-color: #333;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-nav .nav-item .nav-link {
            position: relative;
        }

        .navbar-nav .nav-item .nav-link:hover::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            left: 0;
            bottom: -5px;
            background-color: #ffdd57;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <button id="toggleSidebar" class="btn btn-light me-2">☰</button>
        <a class="navbar-brand" href="#">Travel-Selada</a>

        <button class="btn btn-light me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ml-auto">
                
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
</body>
</html>
