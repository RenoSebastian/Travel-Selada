<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Navbar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        #sidebarMenu {
            background-color: #64B5F6; /* Lighter blue color */
            height: 100vh;
            transition: all 0.3s ease;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            color: #333;
            padding: 10px;
            display: block;
            text-align: center;
        }

        .nav-link.active {
            background-color: #64B5F6;
            color: white;
            font-weight: bold;
        }

        .nav-link:hover {
            background-color: #ddd;
            color: black;
        }

        .btn-custom {
            background-color: #BBDEFB;
            color: black;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-custom:hover {
            background-color: #8A6D58;
        }

        .collapsed-sidebar {
            width: 0;
            overflow: hidden;
            transition: width 0.3s ease;
        }

        #sidebarMenu.collapsed-sidebar {
            display: none;
        }
    </style>
</head>
<body>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('user.dashboard') }}" class="btn btn-custom" aria-current="page">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="user"></span> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <span data-feather="log-out"></span> Logout
                    </a>
                </li>
        </ul>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();

    document.getElementById("toggleSidebar").addEventListener("click", function() {
        let sidebar = document.getElementById("sidebarMenu");
        sidebar.classList.toggle("collapsed-sidebar");
    });
</script>
</body>
</html>
