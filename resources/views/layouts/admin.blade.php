<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админка')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f4f6f9; min-height: 100vh; }

        .admin-topbar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .admin-topbar .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.3rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .admin-topbar .brand i { color: #e94560; }
        .admin-topbar .brand:hover { color: #fff; }

        .admin-topbar .nav-link {
            color: rgba(255,255,255,0.75);
            transition: color 0.2s ease;
        }
        .admin-topbar .nav-link:hover,
        .admin-topbar .nav-link.active { color: #e94560; }

        .page-wrapper { padding: 2rem 0; }

        .page-header {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .page-header h1 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 700;
            color: #1a1a2e;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #eef0f4;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        .card-body { padding: 1.5rem; }

        .btn-primary {
            background: #e94560;
            border-color: #e94560;
            font-weight: 500;
        }
        .btn-primary:hover,
        .btn-primary:focus {
            background: #c73652;
            border-color: #c73652;
        }

        .table { margin-bottom: 0; }
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #eef0f4;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            padding: 1rem;
            white-space: nowrap;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #eef0f4;
        }
        .table tbody tr:hover { background: #fafbfc; }

        code {
            background: #f4f6f9;
            padding: 2px 8px;
            border-radius: 4px;
            color: #e94560;
            font-size: 0.85rem;
        }

        .form-label {
            font-weight: 500;
            color: #1a1a2e;
            margin-bottom: 0.4rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e4eb;
            padding: 0.6rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #e94560;
            box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.15);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #adb5bd;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            color: #dee2e6;
        }
    </style>
</head>
<body>

<nav class="admin-topbar">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <a href="{{ route('admin.categories.index') }}" class="brand">
            <i class="fas fa-store"></i> ShopName Admin
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-th-list me-1"></i> Категории
            </a>
            <a href="/" class="nav-link">
                <i class="fas fa-home me-1"></i> На сайт
            </a>

            @auth
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                       data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->avatar_url }}"
                             alt="{{ auth()->user()->name }}"
                             class="rounded-circle"
                             style="width: 32px; height: 32px; object-fit: cover;">
                        <span class="text-white">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user me-2"></i>Профиль
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Выйти
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fas fa-sign-in-alt me-1"></i> Вход
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus me-1"></i> Регистрация
                </a>
            @endauth
        </div>
    </div>
</nav>

<div class="page-wrapper">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="page-header">
            <h1>@yield('title', 'Админка')</h1>
            @yield('header_actions')
        </div>

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
