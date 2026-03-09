<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MMV - Mumbaiya Misal Vadapav | @yield('title', 'Home')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --saffron: #FF6B00;
            --deep-red: #B22222;
            --turmeric: #F4A22D;
            --cream: #FFF8EF;
            --dark: #1A0A00;
            --green: #2E7D32;
            --light-orange: #FFF3E0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: var(--cream); color: var(--dark); }

        /* NAVBAR */
        .navbar {
            background: var(--dark);
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(255,107,0,0.3);
        }
        .navbar-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--saffron);
            text-decoration: none;
            letter-spacing: 2px;
        }
        .navbar-brand span { color: var(--turmeric); }
        .navbar-nav { display: flex; list-style: none; gap: 0.2rem; align-items: center; }
        .navbar-nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s;
        }
        .navbar-nav a:hover, .navbar-nav a.active { background: var(--saffron); color: #fff; }
        .btn-nav-order {
            background: var(--saffron) !important;
            color: #fff !important;
            border-radius: 25px !important;
            padding: 0.4rem 1.2rem !important;
            font-weight: 600 !important;
        }
        .btn-nav-order:hover { background: var(--deep-red) !important; }
        .hamburger { display: none; background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; }

        /* FLASH MESSAGES */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin: 1rem auto;
            max-width: 1300px;
            font-weight: 500;
        }
        .alert-success { background: #E8F5E9; color: #2E7D32; border-left: 4px solid #2E7D32; }
        .alert-error { background: #FFEBEE; color: #B22222; border-left: 4px solid #B22222; }

        /* FOOTER */
        footer {
            background: var(--dark);
            color: #ccc;
            padding: 3rem 2rem 1.5rem;
        }
        .footer-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 3rem;
        }
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--saffron);
            margin-bottom: 0.8rem;
        }
        .footer-brand span { color: var(--turmeric); }
        footer h4 { color: var(--turmeric); font-size: 1rem; margin-bottom: 1rem; font-weight: 600; }
        footer ul { list-style: none; }
        footer ul li { margin-bottom: 0.5rem; }
        footer ul li a { color: #aaa; text-decoration: none; font-size: 0.9rem; transition: color 0.3s; }
        footer ul li a:hover { color: var(--saffron); }
        .footer-contact p { font-size: 0.9rem; margin-bottom: 0.5rem; display: flex; gap: 0.5rem; align-items: flex-start; }
        .footer-contact i { color: var(--saffron); margin-top: 3px; }
        .social-links { display: flex; gap: 0.8rem; margin-top: 1rem; }
        .social-links a {
            width: 38px; height: 38px;
            background: rgba(255,107,0,0.2);
            color: var(--saffron);
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        .social-links a:hover { background: var(--saffron); color: #fff; }
        .footer-bottom {
            max-width: 1300px;
            margin: 2rem auto 0;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            font-size: 0.85rem;
            color: #666;
        }
        @media (max-width: 768px) {
            .footer-inner { grid-template-columns: 1fr; gap: 1.5rem; }
            .navbar-nav { display: none; }
            .hamburger { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="navbar-brand">MM<span>V</span></a>
        <button class="hamburger" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav" id="navMenu">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/menu') }}" class="{{ request()->is('menu') ? 'active' : '' }}">Menu</a></li>
            <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ url('/catering') }}" class="{{ request()->is('catering') ? 'active' : '' }}">Catering</a></li>
            <li><a href="{{ url('/franchise') }}" class="{{ request()->is('franchise') ? 'active' : '' }}">Franchise</a></li>
            <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                @elseif(auth()->user()->role === 'staff')
                    <li><a href="{{ route('admin.orders.index') }}" style="color:var(--turmeric);"><i class="fas fa-tools"></i> Staff Panel</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#fff;font-size:0.9rem;font-weight:500;padding:0.5rem 1rem;">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" class="btn-nav-order">Register</a></li>
            @endauth
            <li><a href="{{ url('/order') }}" class="btn-nav-order"><i class="fas fa-shopping-bag"></i> Order Now</a></li>
        </ul>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

@yield('content')

<footer>
    <div class="footer-inner">
        <div>
            <div class="footer-brand">MM<span>V</span></div>
            <p style="font-size:0.9rem; line-height:1.7; color:#aaa;">Mumbaiya Misal Vadapav — bringing the bold & authentic flavors of Maharashtra's streets to your plate. 100% Vegetarian. 100% Love.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <div>
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/menu') }}">Menu</a></li>
                <li><a href="{{ url('/about') }}">About Us</a></li>
                <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                <li><a href="{{ url('/careers') }}">Careers</a></li>
            </ul>
        </div>
        <div>
            <h4>Services</h4>
            <ul>
                <li><a href="{{ url('/catering') }}">Catering</a></li>
                <li><a href="{{ url('/franchise') }}">Franchise</a></li>
                <li><a href="{{ url('/order') }}">Order Online</a></li>
                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h4>Contact Us</h4>
            <p><i class="fas fa-map-marker-alt"></i> Titanium City Centre, Anandnagar Road, Satelite, Ahmedabad, Gujarat 380015</p>
            <p><i class="fas fa-envelope"></i> canada@mmvmumbaiya.com</p>
            <p><i class="fas fa-phone"></i> +1 (XXX) XXX-XXXX</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} MMV – Mumbaiya Misal Vadapav. All Rights Reserved. | Dil Bole Wow!!</p>
    </div>
</footer>

<script>
function toggleMenu() {
    const nav = document.getElementById('navMenu');
    nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
    nav.style.flexDirection = 'column';
    nav.style.position = 'absolute';
    nav.style.top = '70px';
    nav.style.left = '0';
    nav.style.right = '0';
    nav.style.background = '#1A0A00';
    nav.style.padding = '1rem';
}
</script>
@stack('scripts')
</body>
</html>
