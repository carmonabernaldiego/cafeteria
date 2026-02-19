<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cafetería KFE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --kfe-cafe: #4E342E;
            --kfe-cafe-claro: #6D4C41;
            --kfe-crema: #EFEBE9;
            --kfe-naranja: #FF6F00;
            --kfe-dorado: #FFB300;
        }

        body {
            background-color: #f8f5f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--kfe-cafe), var(--kfe-cafe-claro)) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 1px;
        }

        .navbar-brand i {
            color: var(--kfe-dorado);
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s;
            border-radius: 8px;
            margin: 0 2px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn-kfe {
            background: linear-gradient(135deg, var(--kfe-cafe), var(--kfe-cafe-claro));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-kfe:hover {
            background: linear-gradient(135deg, var(--kfe-cafe-claro), var(--kfe-cafe));
            color: white;
            box-shadow: 0 4px 12px rgba(78, 52, 46, 0.3);
        }

        .btn-naranja {
            background: linear-gradient(135deg, var(--kfe-naranja), #FF8F00);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-naranja:hover {
            background: linear-gradient(135deg, #FF8F00, var(--kfe-naranja));
            color: white;
            box-shadow: 0 4px 12px rgba(255, 111, 0, 0.3);
        }

        .page-header {
            background: white;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .table thead th {
            background-color: var(--kfe-cafe);
            color: white;
            border: none;
            font-weight: 600;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .badge-kfe {
            background-color: var(--kfe-naranja);
            color: white;
            font-size: 0.85rem;
            padding: 0.4em 0.8em;
            border-radius: 6px;
        }

        .stat-card {
            border-left: 4px solid var(--kfe-naranja);
            background: white;
        }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--kfe-cafe);
        }

        .stat-card .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @yield('styles')
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('ventas.index') }}">
                <i class="bi bi-cup-hot-fill"></i> KFE Cafetería
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}"
                            href="{{ route('ventas.index') }}">
                            <i class="bi bi-cart"></i> Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}"
                            href="{{ route('categorias.index') }}">
                            <i class="bi bi-tags"></i> Categorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}"
                            href="{{ route('productos.index') }}">
                            <i class="bi bi-basket-fill"></i> Productos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}"
                            href="{{ route('reportes.index') }}">
                            <i class="bi bi-bar-chart"></i> Reportes
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-center py-4 mt-5 text-muted">
        <small>&copy; {{ date('Y') }} Cafetería KFE</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>

</html>
