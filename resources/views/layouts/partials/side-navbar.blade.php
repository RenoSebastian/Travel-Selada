<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Navbar with Top Navbar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Sidebar style */
        #sidebarMenu {
            transition: all 0.3s ease;
            background-color: #B2EBF2; /* Warna pastel biru muda */
            height: 100vh;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            color: #333;
            padding: 10px;
            display: block;
            text-align: center; /* Rata tengah untuk tombol */
        }

        .nav-link.active {
            background-color: #efaf32; /* Warna kuning favorit */
            color: white;
            font-weight: bold;
        }

        .nav-link:hover {
            background-color: #ddd;
            color: black;
        }

        /* Button style */
        .btn-custom {
            width: 100%; /* Buat tombol memenuhi lebar */
            margin-bottom: 10px; /* Spasi antar tombol */
        }

        /* Sidebar toggle transition */
        .collapsed-sidebar {
            width: 0;
            overflow: hidden;
            transition: width 0.3s ease;
        }

        /* Sidebar hidden when collapsed */
        #sidebarMenu.collapsed-sidebar {
            display: none;
        }

        /* Top Navbar style */
        .navbar {
            background-color: #efaf32; /* Warna kuning favorit */
            padding: 10px;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        /* Move toggle to the top-navbar */
        #toggleSidebar {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link active" aria-current="page">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('location.create') }}" class="btn btn-primary btn-custom">Input Data Brand</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-custom">Input User</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="btn btn-primary btn-custom">
                                <span data-feather="file"></span>
                                Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="btn btn-primary btn-custom">
                                <span data-feather="credit-card"></span>
                                Terminals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="btn btn-primary btn-custom">
                                <span data-feather="users"></span>
                                Agents
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1>Welcome to the Dashboard</h1>
                <p>This is the main content area.</p>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        // Activate feather icons
        feather.replace();

        // Toggle sidebar visibility
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            let sidebar = document.getElementById("sidebarMenu");
            if (sidebar.classList.contains("collapsed-sidebar")) {
                sidebar.classList.remove("collapsed-sidebar");
            } else {
                sidebar.classList.add("collapsed-sidebar");
            }
        });
    </script>
</body>
</html>
