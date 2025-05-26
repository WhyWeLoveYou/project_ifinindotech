<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
        }

        .sidebar {
            min-width: 220px;
            max-width: 220px;
            min-height: 100vh;
            background: #343a40;
            color: #fff;
        }

        .sidebar .nav-link {
            color: #adb5bd;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #fff;
            background: #495057;
        }

        .sidebar .sidebar-heading {
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: .05em;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <nav class="sidebar d-flex flex-column p-3">
            <div class="sidebar-heading mb-4">
                <span>My Sidebar</span>
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/orders" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="bi bi-basket me-2"></i></i> Orders
                    </a>
                </li>
                <li>
                    <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="bi bi-person me-2"></i> Users
                    </a>
                </li>
                <li>
                    <a href="/products" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam me-2"></i> Products
                    </a>
                </li>
            </ul>
            <hr>
        </nav>
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
