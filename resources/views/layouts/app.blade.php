<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Travel Agency</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Własne style -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar-nav .nav-item .nav-link {
            margin-right: 10px;
        }

        .navbar-nav .nav-item .btn {
            font-weight: bold;
            border-width: 2px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-item .btn:hover {
            background-color: #007bff; /* Niebieski dla primary */
            color: white;
        }

        .navbar-nav .nav-item .btn-outline-success:hover {
            background-color: #28a745; /* Zielony dla success */
            color: white;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card h5 {
            font-size: 1.2rem;
        }

        .btn {
            font-size: 0.9rem;
        }

        /* Wysoki kontrast */
        body.high-contrast {
            background-color: #000;
            color: #fff;
        }

        body.high-contrast a {
            color: #1e90ff;
        }

        body.high-contrast .btn {
            background-color: #444;
            color: #fff;
            border-color: #fff;
        }

        body.high-contrast .btn:hover {
            background-color: #555;
        }

        body.high-contrast .navbar {
            background-color: #000;
        }

        body.high-contrast .navbar a {
            color: #fff;
        }

        body.high-contrast .card {
            background-color: #222;
            color: #fff;
            border: 1px solid #444;
        }

        body.high-contrast .card .btn {
            background-color: #444;
            color: #fff;
        }

        body.high-contrast .card .btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Travel Agency</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary nav-link" href="{{ route('packages') }}">Packages</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-outline-primary nav-link" href="{{ route('profile.edit') }}#trips">My Trips</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="btn btn-outline-secondary me-2" id="increaseFont">A+</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-secondary" id="decreaseFont">A-</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-dark" id="toggleContrast">Toggle Contrast</button>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="btn btn-outline-success nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-success nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-success nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Skrypt obsługi czcionki i kontrastu -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const increaseFontButton = document.getElementById("increaseFont");
            const decreaseFontButton = document.getElementById("decreaseFont");
            const toggleContrastButton = document.getElementById("toggleContrast");

            let fontSize = 100;

            increaseFontButton?.addEventListener("click", function () {
                if (fontSize < 150) {
                    fontSize += 10;
                    document.body.style.fontSize = fontSize + "%";
                }
            });

            decreaseFontButton?.addEventListener("click", function () {
                if (fontSize > 50) {
                    fontSize -= 10;
                    document.body.style.fontSize = fontSize + "%";
                }
            });

            if (localStorage.getItem("highContrast") === "true") {
                document.body.classList.add("high-contrast");
            }

            toggleContrastButton?.addEventListener("click", function () {
                const isHighContrast = document.body.classList.toggle("high-contrast");
                localStorage.setItem("highContrast", isHighContrast);
            });
        });
    </script>
</body>
</html>
