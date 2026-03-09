<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MMV Admin | @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --saffron: #FF6B00;
            --deep-red: #B22222;
            --turmeric: #F4A22D;
            --dark: #1A0A00;
            --sidebar-bg: #1e1107;
            --card-bg: #fff;
            --body-bg: #f5f0ea;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: var(--body-bg); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0; top: 0;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s;
        }
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,107,0,0.2);
            font-size: 1.4rem;
            font-weight: 900;
            color: var(--saffron);
            letter-spacing: 2px;
        }
        .sidebar-brand span { color: var(--turmeric); }
        .sidebar-brand small { display: block; font-size: 0.65rem; color: #888; font-weight: 400; letter-spacing: 1px; }
        .sidebar-menu { padding: 1rem 0; }
        .menu-section { color: #666; font-size: 0.65rem; padding: 1rem 1.5rem 0.3rem; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.75rem 1.5rem;
            color: #bbb;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,107,0,0.1);
            color: var(--saffron);
            border-left-color: var(--saffron);
        }
        .sidebar-menu a i { width: 18px; text-align: center; font-size: 0.95rem; }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background: #fff;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar h1 { font-size: 1.3rem; font-weight: 600; color: var(--dark); }
        .topbar-right { display: flex; align-items: center; gap: 1.5rem; }
        .admin-avatar {
            width: 38px; height: 38px;
            background: var(--saffron);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 1rem;
        }
        .page-content { padding: 2rem; flex: 1; }

        /* CARDS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-left: 4px solid var(--saffron);
        }
        .stat-card.red { border-left-color: var(--deep-red); }
        .stat-card.green { border-left-color: #2E7D32; }
        .stat-card.blue { border-left-color: #1565C0; }
        .stat-icon {
            width: 55px; height: 55px;
            background: rgba(255,107,0,0.1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            color: var(--saffron);
        }
        .stat-card.red .stat-icon { background: rgba(178,34,34,0.1); color: var(--deep-red); }
        .stat-card.green .stat-icon { background: rgba(46,125,50,0.1); color: #2E7D32; }
        .stat-card.blue .stat-icon { background: rgba(21,101,192,0.1); color: #1565C0; }
        .stat-number { font-size: 1.8rem; font-weight: 700; color: var(--dark); }
        .stat-label { font-size: 0.85rem; color: #888; }

        /* TABLE */
        .data-card { background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 1.5rem; }
        .data-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; }
        .data-card-header h3 { font-size: 1.05rem; font-weight: 600; color: var(--dark); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f4ef; color: var(--dark); font-size: 0.8rem; font-weight: 600; padding: 0.75rem 1rem; text-align: left; }
        td { padding: 0.85rem 1rem; font-size: 0.88rem; border-bottom: 1px solid #f0ebe3; color: #333; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #faf7f3; }

        /* BUTTONS */
        .btn {
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s;
        }
        .btn-primary { background: var(--saffron); color: #fff; }
        .btn-primary:hover { background: #e55a00; }
        .btn-danger { background: var(--deep-red); color: #fff; }
        .btn-danger:hover { background: #8b1a1a; }
        .btn-success { background: #2E7D32; color: #fff; }
        .btn-success:hover { background: #1b5e20; }
        .btn-sm { padding: 0.3rem 0.8rem; font-size: 0.78rem; }
        .btn-outline { background: transparent; border: 1.5px solid var(--saffron); color: var(--saffron); }
        .btn-outline:hover { background: var(--saffron); color: #fff; }

        /* BADGES */
        .badge {
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success { background: #E8F5E9; color: #2E7D32; }
        .badge-warning { background: #FFF8E1; color: #F57F17; }
        .badge-danger { background: #FFEBEE; color: #B22222; }
        .badge-info { background: #E3F2FD; color: #1565C0; }

        /* FORM */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #444; }
        .form-control {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s;
            background: #fff;
        }
        .form-control:focus { outline: none; border-color: var(--saffron); }

        /* ALERTS */
        .alert { padding: 0.8rem 1.2rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; }
        .alert-success { background: #E8F5E9; color: #2E7D32; border-left: 4px solid #2E7D32; }
        .alert-error { background: #FFEBEE; color: #B22222; border-left: 4px solid #B22222; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">MM<span>V</span><small>ADMIN PANEL</small></div>
    <nav class="sidebar-menu">
        @if(auth()->user()->role === 'admin')
        <div class="menu-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        @endif

        <div class="menu-section">Menu & Orders</div>
        <a href="{{ route('admin.menu.index') }}" class="{{ request()->routeIs('admin.menu*') ? 'active' : '' }}">
            <i class="fas fa-utensils"></i> Manage Menu
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders
        </a>

        @if(auth()->user()->role === 'admin')
        <div class="menu-section">Inventory</div>
        <a href="{{ route('admin.stocks.index') }}" class="{{ request()->routeIs('admin.stocks*') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i> Stock Management
        </a>

        <div class="menu-section">Marketing</div>
        <a href="{{ route('admin.catering.index') }}" class="{{ request()->routeIs('admin.catering*') ? 'active' : '' }}">
            <i class="fas fa-concierge-bell"></i> Catering Requests
        </a>
        <a href="{{ route('admin.franchise.index') }}" class="{{ request()->routeIs('admin.franchise*') ? 'active' : '' }}">
            <i class="fas fa-store"></i> Franchise Enquiries
        </a>

        <div class="menu-section">Users</div>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        @endif

        <div class="menu-section">Settings</div>
        <a href="{{ route('admin.best-sellers.index') }}" class="{{ request()->routeIs('admin.best-sellers*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Best Sellers Showcase
        </a>
        <a href="{{ route('admin.site-images.index') }}" class="{{ request()->routeIs('admin.site-images*') ? 'active' : '' }}">
            <i class="fas fa-images"></i> Website Images
        </a>
        <a href="{{ url('/') }}">
            <i class="fas fa-globe"></i> View Website
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
    </nav>
</aside>

<div class="main-content">
    <div class="topbar">
        <h1>@yield('title', 'Dashboard')</h1>
        <div class="topbar-right">
            <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <span style="font-size:0.9rem; color:#555;">{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
