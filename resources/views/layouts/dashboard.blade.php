<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div id="app">
        <!-- Top Navbar -->
        @include('layouts.partials.top-navbar')

        <div class="container-fluid">
            <div class="row">
                <!-- Side Navbar -->
                @include('layouts.partials.side-navbar')

                <!-- Main Content -->
                <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
    