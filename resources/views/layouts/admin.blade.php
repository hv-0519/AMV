<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MMV Admin | @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--body-bg);
            display: flex;
            min-height: 100vh;
        }

        .mobile-sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(11, 4, 0, 0.52);
            backdrop-filter: blur(2px);
            z-index: 95;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .mobile-sidebar-backdrop.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .sidebar-brand-mark {
            width: 44px;
            height: 44px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .sidebar-brand-text strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 900;
            letter-spacing: 0.45px;
            color: var(--saffron);
        }

        .sidebar-brand-text small {
            display: block;
            font-size: 0.58rem;
            color: #888;
            font-weight: 500;
            letter-spacing: 0.95px;
            margin-top: 0.22rem;
            text-transform: uppercase;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            color: #666;
            font-size: 0.65rem;
            padding: 1rem 1.5rem 0.3rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

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

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 107, 0, 0.1);
            color: var(--saffron);
            border-left-color: var(--saffron);
        }

        .sidebar-menu a i {
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            background: #fff;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar h1 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .sidebar-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid #efe3d7;
            background: #fff7f0;
            color: var(--saffron);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            background: var(--saffron);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
        }

        .page-content {
            padding: 2rem;
            flex: 1;
            min-width: 0;
        }

        /* CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border-left: 4px solid var(--saffron);
        }

        .stat-card.red {
            border-left-color: var(--deep-red);
        }

        .stat-card.green {
            border-left-color: #2E7D32;
        }

        .stat-card.blue {
            border-left-color: #1565C0;
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            background: rgba(255, 107, 0, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--saffron);
        }

        .stat-card.red .stat-icon {
            background: rgba(178, 34, 34, 0.1);
            color: var(--deep-red);
        }

        .stat-card.green .stat-icon {
            background: rgba(46, 125, 50, 0.1);
            color: #2E7D32;
        }

        .stat-card.blue .stat-icon {
            background: rgba(21, 101, 192, 0.1);
            color: #1565C0;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
        }

        .stat-label {
            font-size: 0.85rem;
            color: #888;
        }

        /* TABLE */
        .data-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }

        .data-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
        }

        .data-card-header h3 {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--dark);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-card table {
            min-width: 720px;
        }

        th {
            background: #f8f4ef;
            color: var(--dark);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        td {
            padding: 0.85rem 1rem;
            font-size: 0.88rem;
            border-bottom: 1px solid #f0ebe3;
            color: #333;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #faf7f3;
        }

        .stack-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        .inline-tools {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

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

        .btn-primary {
            background: var(--saffron);
            color: #fff;
        }

        .btn-primary:hover {
            background: #e55a00;
        }

        .btn-danger {
            background: var(--deep-red);
            color: #fff;
        }

        .btn-danger:hover {
            background: #8b1a1a;
        }

        .btn-success {
            background: #2E7D32;
            color: #fff;
        }

        .btn-success:hover {
            background: #1b5e20;
        }

        .btn-sm {
            padding: 0.3rem 0.8rem;
            font-size: 0.78rem;
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--saffron);
            color: var(--saffron);
        }

        .btn-outline:hover {
            background: var(--saffron);
            color: #fff;
        }

        /* BADGES */
        .badge {
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .badge-warning {
            background: #FFF8E1;
            color: #F57F17;
        }

        .badge-danger {
            background: #FFEBEE;
            color: #B22222;
        }

        .badge-info {
            background: #E3F2FD;
            color: #1565C0;
        }

        /* FORM */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: #444;
        }

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

        .form-control:focus {
            outline: none;
            border-color: var(--saffron);
        }

        /* ALERTS */
        .alert {
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #E8F5E9;
            color: #2E7D32;
            border-left: 4px solid #2E7D32;
        }

        .alert-error {
            background: #FFEBEE;
            color: #B22222;
            border-left: 4px solid #B22222;
        }

        /* CRUD MODALS + LOADER */
        .crud-modal-backdrop {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 20% 15%, rgba(255, 107, 0, 0.20), rgba(15, 6, 0, 0.88) 60%);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1200;
            padding: 1.5rem;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.9s ease, visibility 0.9s ease;
        }

        .crud-modal-backdrop.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .crud-modal-panel {
            width: min(980px, 100%);
            max-height: 92vh;
            overflow: hidden;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: linear-gradient(165deg, #fffaf4, #fff 30%);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
            display: flex;
            flex-direction: column;
            transform: translateY(18px) scale(0.98);
            opacity: 0;
            transition: transform 0.34s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.28s ease;
        }

        .crud-modal-backdrop.is-open .crud-modal-panel {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .crud-modal-header {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid #f0ebe3;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, rgba(255, 107, 0, 0.08), rgba(244, 162, 45, 0.08));
        }

        .crud-modal-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .crud-modal-close {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid #e6dbcf;
            background: #fff;
            color: #6f5845;
            cursor: pointer;
            font-size: 1rem;
        }

        .crud-modal-close:hover {
            border-color: var(--saffron);
            color: var(--saffron);
        }

        .crud-modal-body {
            overflow-y: auto;
            padding: 1.2rem;
            background: #fff;
        }

        .crud-modal-body .data-card {
            box-shadow: none;
            border: 1px solid #f0ebe3;
            margin-bottom: 0;
        }

        .crud-modal-body .invalid-feedback {
            color: var(--deep-red);
            font-size: 0.78rem;
            margin-top: 0.25rem;
            display: block;
        }

        .crud-modal-body .is-invalid {
            border-color: var(--deep-red) !important;
        }

        .crud-modal-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 220px;
            color: #7b624e;
            font-weight: 600;
            gap: 0.65rem;
        }

        .crud-loader-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 6, 0, 0.84);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1400;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .crud-loader-overlay.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .crud-loader-card {
            width: min(420px, 100%);
            background: linear-gradient(170deg, #2a1307, #1a0a00 65%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 1.4rem 1.3rem;
            color: #ffe8d0;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            transform: translateY(10px) scale(0.97);
            opacity: 0;
            transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.24s ease;
        }

        .crud-loader-overlay.is-open .crud-loader-card {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .crud-loader-spinner {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            margin: 0 auto 0.9rem;
            border: 4px solid rgba(255, 255, 255, 0.18);
            border-top-color: var(--saffron);
            animation: spin 0.9s linear infinite;
        }

        .crud-loader-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .crud-loader-subtitle {
            font-size: 0.82rem;
            color: rgba(255, 232, 208, 0.75);
        }

        .crud-toast {
            position: fixed;
            right: 1.2rem;
            top: 1.2rem;
            z-index: 1500;
            min-width: 250px;
            max-width: 420px;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            color: #fff;
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25);
            display: none;
        }

        .crud-toast.show {
            display: block;
        }

        .crud-toast.success {
            background: #2E7D32;
        }

        .crud-toast.error {
            background: #B22222;
        }

        .crud-result-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 6, 0, 0.76);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1450;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .crud-result-backdrop.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .crud-result-card {
            width: min(420px, 100%);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: linear-gradient(160deg, #fffaf4, #fff 38%);
            box-shadow: 0 24px 55px rgba(0, 0, 0, 0.42);
            padding: 1.25rem;
            text-align: center;
            transform: translateY(10px) scale(0.97);
            opacity: 0;
            transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.24s ease;
        }

        .crud-result-backdrop.is-open .crud-result-card {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .crud-result-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            margin: 0 auto 0.8rem;
            display: grid;
            place-items: center;
            background: rgba(46, 125, 50, 0.14);
            color: #2E7D32;
            font-size: 1.4rem;
        }

        .crud-result-title {
            font-size: 1.12rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.3rem;
        }

        .crud-result-text {
            color: #6f5846;
            font-size: 0.88rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .crud-modal-backdrop,
            .crud-modal-panel,
            .crud-loader-overlay,
            .crud-loader-card,
            .crud-result-backdrop,
            .crud-result-card {
                transition: none !important;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.is-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .crud-modal-backdrop {
                padding: 0.7rem;
            }

            .crud-modal-body {
                padding: 0.8rem;
            }

            .topbar {
                padding: 0.9rem 1rem;
            }

            .topbar h1 {
                font-size: 1.05rem;
                line-height: 1.3;
            }

            .topbar-right {
                gap: 0.75rem;
            }

            .topbar-right span {
                display: none;
            }

            .sidebar-toggle {
                display: inline-flex;
            }

            .page-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stack-grid {
                grid-template-columns: 1fr;
            }

            .data-card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 0.8rem;
            }

            .data-card table {
                min-width: 640px;
            }
        }

        @media (max-width: 520px) {
            .page-content {
                padding: 0.85rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.45rem;
            }

            .btn {
                justify-content: center;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="mobile-sidebar-backdrop" id="mobileSidebarBackdrop" aria-hidden="true"></div>

    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/mmv-logo.svg') }}" alt="MMV Logo" class="sidebar-brand-mark">
            <div class="sidebar-brand-text">
                <strong>Mumbaiya Misal</strong>
                <small>Vadapav Admin</small>
            </div>
        </div>
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
            <a href="{{ route('admin.pairings.index') }}" class="{{ request()->routeIs('admin.pairings.*') ? 'active' : '' }}">
                <i class="fas fa-link"></i> Recommendations
            </a>
            <a href="{{ route('logout') }}" id="adminLogoutTrigger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        </nav>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-expanded="false" aria-controls="adminSidebar" aria-label="Toggle admin sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>@yield('title', 'Dashboard')</h1>
            </div>
            <div class="topbar-right">
                <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <span style="font-size:0.9rem; color:#555;">{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
        </div>

        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <div id="crudModal" class="crud-modal-backdrop" aria-hidden="true">
        <div class="crud-modal-panel" role="dialog" aria-modal="true" aria-labelledby="crudModalTitle">
            <div class="crud-modal-header">
                <h3 id="crudModalTitle" class="crud-modal-title">Manage Record</h3>
                <button type="button" class="crud-modal-close" data-crud-modal-close aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="crudModalBody" class="crud-modal-body"></div>
        </div>
    </div>

    <div id="crudLoader" class="crud-loader-overlay" aria-hidden="true">
        <div class="crud-loader-card">
            <div class="crud-loader-spinner"></div>
            <div id="crudLoaderTitle" class="crud-loader-title">Saving changes...</div>
            <div class="crud-loader-subtitle">Please wait while we complete this action.</div>
        </div>
    </div>

    <div id="crudToast" class="crud-toast"></div>

    <div id="crudResultModal" class="crud-result-backdrop" aria-hidden="true">
        <div class="crud-result-card" role="dialog" aria-modal="true" aria-labelledby="crudResultTitle">
            <div id="crudResultIcon" class="crud-result-icon"><i class="fas fa-check"></i></div>
            <h3 id="crudResultTitle" class="crud-result-title">Success</h3>
            <p id="crudResultText" class="crud-result-text">Action completed successfully.</p>
            <button type="button" id="crudResultContinue" class="btn btn-primary">Continue</button>
        </div>
    </div>

    <script>
        (() => {
            const MIN_LOADING_MS = 700;
            const modal = document.getElementById('crudModal');
            const modalBody = document.getElementById('crudModalBody');
            const modalTitle = document.getElementById('crudModalTitle');
            const loader = document.getElementById('crudLoader');
            const loaderTitle = document.getElementById('crudLoaderTitle');
            const toast = document.getElementById('crudToast');
            const resultModal = document.getElementById('crudResultModal');
            const resultIcon = document.getElementById('crudResultIcon');
            const resultTitle = document.getElementById('crudResultTitle');
            const resultText = document.getElementById('crudResultText');
            const resultContinue = document.getElementById('crudResultContinue');
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileSidebarBackdrop = document.getElementById('mobileSidebarBackdrop');
            @php
            $adminFlashPayload = null;

            if (session('success')) {
                $adminFlashPayload = [
                    'type' => 'success',
                    'message' => session('success'),
                ];
            }
            elseif(session('error')) {
                $adminFlashPayload = [
                    'type' => 'error',
                    'message' => session('error'),
                ];
            }
            @endphp

            const flashPayload = @json($adminFlashPayload);

            const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

            function showToast(type, message) {
                toast.className = `crud-toast ${type} show`;
                toast.textContent = message;
                setTimeout(() => {
                    toast.className = 'crud-toast';
                    toast.textContent = '';
                }, 3200);
            }

            function syncBodyScroll() {
                const sidebarOpen = window.innerWidth <= 768 && sidebar?.classList.contains('is-open');
                const overlayOpen = modal.classList.contains('is-open') || resultModal.classList.contains('is-open');
                document.body.style.overflow = sidebarOpen || overlayOpen ? 'hidden' : '';
            }

            function openSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('is-open');
                mobileSidebarBackdrop?.classList.add('is-open');
                mobileSidebarBackdrop?.setAttribute('aria-hidden', 'false');
                sidebarToggle?.setAttribute('aria-expanded', 'true');
                if (sidebarToggle) {
                    sidebarToggle.innerHTML = '<i class="fas fa-times"></i>';
                }
                syncBodyScroll();
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('is-open');
                mobileSidebarBackdrop?.classList.remove('is-open');
                mobileSidebarBackdrop?.setAttribute('aria-hidden', 'true');
                sidebarToggle?.setAttribute('aria-expanded', 'false');
                if (sidebarToggle) {
                    sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
                }
                syncBodyScroll();
            }

            function getResultConfig(type) {
                if (type === 'error') {
                    return {
                        title: 'Action Blocked',
                        icon: 'fa-circle-xmark',
                        background: 'rgba(178,34,34,0.14)',
                        color: 'var(--deep-red)',
                        buttonClass: 'btn btn-danger',
                        buttonLabel: 'Close',
                    };
                }

                return {
                    title: 'Success',
                    icon: 'fa-circle-check',
                    background: 'rgba(46,125,50,0.14)',
                    color: '#2E7D32',
                    buttonClass: 'btn btn-primary',
                    buttonLabel: 'Continue',
                };
            }

            function showResultModal(type, message, overrideTitle) {
                return new Promise((resolve) => {
                    const config = getResultConfig(type);
                    resultTitle.textContent = overrideTitle || config.title;
                    resultText.textContent = message || 'Action completed successfully.';
                    resultIcon.style.background = config.background;
                    resultIcon.style.color = config.color;
                    resultIcon.innerHTML = `<i class="fas ${config.icon}"></i>`;
                    resultContinue.className = config.buttonClass;
                    resultContinue.textContent = config.buttonLabel;
                    resultModal.classList.add('is-open');
                    resultModal.setAttribute('aria-hidden', 'false');
                    syncBodyScroll();

                    const close = () => {
                        resultModal.classList.remove('is-open');
                        resultModal.setAttribute('aria-hidden', 'true');
                        syncBodyScroll();
                        resolve();
                    };

                    const onBackdrop = (event) => {
                        if (event.target === resultModal) {
                            resultModal.removeEventListener('click', onBackdrop);
                            resultContinue.removeEventListener('click', onContinue);
                            close();
                        }
                    };

                    const onContinue = () => {
                        resultModal.removeEventListener('click', onBackdrop);
                        resultContinue.removeEventListener('click', onContinue);
                        close();
                    };

                    resultModal.addEventListener('click', onBackdrop);
                    resultContinue.addEventListener('click', onContinue);
                });
            }

            function showSuccessModal(message, title) {
                return showResultModal('success', message, title);
            }

            function openModal(title, html) {
                modalTitle.textContent = title || 'Manage Record';
                modalBody.innerHTML = html || '';
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                syncBodyScroll();
            }

            function closeModal() {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                modalBody.innerHTML = '';
                syncBodyScroll();
            }

            function showLoader(title) {
                loaderTitle.textContent = title || 'Saving changes...';
                loader.classList.add('is-open');
                loader.setAttribute('aria-hidden', 'false');
            }

            function hideLoader() {
                loader.classList.remove('is-open');
                loader.setAttribute('aria-hidden', 'true');
            }

            async function withMinLoader(task, title) {
                const started = Date.now();
                showLoader(title);
                try {
                    return await task();
                } finally {
                    const elapsed = Date.now() - started;
                    if (elapsed < MIN_LOADING_MS) {
                        await sleep(MIN_LOADING_MS - elapsed);
                    }
                    hideLoader();
                }
            }

            function clearValidationErrors(form) {
                form.querySelectorAll('.invalid-feedback.dynamic-error').forEach((el) => el.remove());
                form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
            }

            function renderValidationErrors(form, errors) {
                clearValidationErrors(form);
                Object.keys(errors || {}).forEach((field) => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (!input) return;
                    input.classList.add('is-invalid');
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback dynamic-error';
                    feedback.textContent = (errors[field] && errors[field][0]) ? errors[field][0] : 'Invalid value';
                    input.insertAdjacentElement('afterend', feedback);
                });
            }

            function extractModalContent(html) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const content = doc.querySelector('.page-content');
                if (!content) return html;
                return content.innerHTML;
            }

            async function loadUrlIntoModal(url, title) {
                openModal(title, '<div class="crud-modal-loading"><i class="fas fa-spinner fa-spin"></i> Loading form...</div>');
                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    });
                    if (!response.ok) throw new Error('Unable to load form');
                    const html = await response.text();
                    modalBody.innerHTML = extractModalContent(html);
                } catch (error) {
                    modalBody.innerHTML = '<div class="alert alert-error">Unable to load this form right now.</div>';
                }
            }

            async function submitCrudForm(form, successMessage, loadingTitle) {
                clearValidationErrors(form);
                const formData = new FormData(form);
                const response = await withMinLoader(async () => {
                    return fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                }, loadingTitle);

                if (response.status === 422) {
                    const payload = await response.json();
                    renderValidationErrors(form, payload.errors || {});
                    showToast('error', payload.message || 'Please fix the highlighted fields.');
                    return false;
                }

                if (!response.ok) {
                    showToast('error', 'Something went wrong. Please try again.');
                    return false;
                }

                return true;
            }

            function getActionLabel(form) {
                const method = (form.querySelector('input[name="_method"]')?.value || form.method || 'POST').toUpperCase();
                if (method === 'DELETE') return 'Deleting record...';
                if (method === 'PATCH') return 'Updating record...';
                if (method === 'PUT') return 'Updating record...';
                return 'Saving changes...';
            }

            function inferConfirmActionLabel(message) {
                const value = (message || '').toLowerCase();
                if (value.includes('cancel')) return 'Yes, Cancel';
                if (value.includes('remove')) return 'Yes, Remove';
                if (value.includes('logout')) return 'Yes, Logout';
                return 'Yes, Delete';
            }

            document.addEventListener('click', (event) => {
                const closeBtn = event.target.closest('[data-crud-modal-close]');
                if (closeBtn) {
                    closeModal();
                    return;
                }

                const trigger = event.target.closest('a.js-crud-modal');
                if (!trigger) return;
                event.preventDefault();
                const title = trigger.dataset.modalTitle || trigger.textContent.trim() || 'Manage Record';
                loadUrlIntoModal(trigger.href, title);
            });

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('submit', async (event) => {
                const form = event.target;

                if (form.matches('form.js-crud-delete')) {
                    event.preventDefault();
                    const message = form.dataset.confirm || 'Delete this record?';
                    const confirmTitle = form.dataset.confirmTitle || 'Confirm Action';
                    const confirmButton = form.dataset.confirmButton || inferConfirmActionLabel(message);
                    openModal(confirmTitle, `
                <div class="data-card">
                    <h3 style="margin-bottom:0.8rem; color:var(--deep-red);">${confirmTitle}</h3>
                    <p style="color:#555; margin-bottom:1.2rem;">${message}</p>
                    <div style="display:flex; gap:0.7rem;">
                        <button type="button" class="btn btn-outline" data-crud-modal-close>Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmCrudDelete">
                            <i class="fas fa-trash"></i> ${confirmButton}
                        </button>
                    </div>
                </div>
            `);

                    const confirmBtn = document.getElementById('confirmCrudDelete');
                    if (confirmBtn) {
                        confirmBtn.addEventListener('click', async () => {
                            closeModal();
                            const ok = await submitCrudForm(form, form.dataset.success || 'Deleted successfully.', 'Deleting record...');
                            if (ok) {
                                await showSuccessModal(form.dataset.success || 'Deleted successfully.');
                                window.location.reload();
                            }
                        }, {
                            once: true
                        });
                    }
                    return;
                }

                if (!form.matches('form.js-crud-ajax')) return;
                event.preventDefault();
                const ok = await submitCrudForm(
                    form,
                    form.dataset.success || 'Saved successfully.',
                    form.dataset.loading || getActionLabel(form)
                );
                if (ok) {
                    closeModal();
                    await showSuccessModal(form.dataset.success || 'Saved successfully.');
                    window.location.reload();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key !== 'Escape') return;
                closeSidebar();
                if (modal.classList.contains('is-open')) {
                    closeModal();
                }
                if (resultModal.classList.contains('is-open')) {
                    resultModal.classList.remove('is-open');
                    resultModal.setAttribute('aria-hidden', 'true');
                    syncBodyScroll();
                }
            });

            resultModal.addEventListener('click', (event) => {
                if (event.target === resultModal) {
                    resultModal.classList.remove('is-open');
                    resultModal.setAttribute('aria-hidden', 'true');
                    syncBodyScroll();
                }
            });

            sidebarToggle?.addEventListener('click', () => {
                if (sidebar?.classList.contains('is-open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            mobileSidebarBackdrop?.addEventListener('click', closeSidebar);

            document.querySelectorAll('.sidebar-menu a').forEach((link) => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });

            const adminLogoutTrigger = document.getElementById('adminLogoutTrigger');
            const adminLogoutForm = document.getElementById('logout-form');

            if (adminLogoutTrigger && adminLogoutForm) {
                adminLogoutTrigger.addEventListener('click', (event) => {
                    event.preventDefault();
                    openModal('Confirm Logout', `
                <div class="data-card">
                    <h3 style="margin-bottom:0.8rem; color:var(--dark);">Confirm Logout</h3>
                    <p style="color:#555; margin-bottom:1.2rem;">Do you want to end your admin session now?</p>
                    <div style="display:flex; gap:0.7rem;">
                        <button type="button" class="btn btn-outline" data-crud-modal-close>Stay Here</button>
                        <button type="button" class="btn btn-danger" id="confirmAdminLogout">
                            <i class="fas fa-right-from-bracket"></i> Logout
                        </button>
                    </div>
                </div>
            `);

                    const confirmLogoutBtn = document.getElementById('confirmAdminLogout');
                    if (confirmLogoutBtn) {
                        confirmLogoutBtn.addEventListener('click', () => {
                            adminLogoutForm.submit();
                        }, {
                            once: true
                        });
                    }
                });
            }

            if (flashPayload) {
                showResultModal(flashPayload.type, flashPayload.message, flashPayload.type === 'error' ? 'Unable to Complete Action' : 'Done');
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
