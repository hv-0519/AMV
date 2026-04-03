<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AMV - Amdavadi Misal and Vadapav | @yield('title', 'Home')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        html, body { max-width: 100%; overflow-x: hidden; }
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
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: #fff;
            text-decoration: none;
        }
        .brand-logo-mark {
            width: 44px;
            height: 44px;
            object-fit: contain;
            flex-shrink: 0;
        }
        .brand-wordmark {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }
        .brand-wordmark strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.08rem;
            font-weight: 900;
            letter-spacing: 0.4px;
            color: var(--saffron);
        }
        .brand-wordmark small {
            font-size: 0.58rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.6);
            margin-top: 0.18rem;
        }
        .navbar-nav { display: flex; list-style: none; gap: 0.2rem; align-items: center; }
        .navbar-nav li { list-style: none; }
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

        /* Cart nav icon */
        .cart-nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            transition: background 0.2s, border-color 0.2s;
            flex-shrink: 0;
        }
        .cart-nav-link:hover { background: rgba(255,107,0,0.2); border-color: rgba(255,107,0,0.4); color: #fff; }
        .cart-nav-badge {
            position: absolute;
            top: -5px;
            right: -6px;
            background: var(--saffron);
            color: #fff;
            font-size: 0.6rem;
            font-weight: 800;
            min-width: 17px;
            height: 17px;
            border-radius: 9px;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            line-height: 1;
        }
        .cart-nav-badge.visible { display: flex; }

        .hamburger {
            display: none;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            color: white;
            font-size: 1.1rem;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }
        .nav-backdrop {
            position: fixed;
            inset: 70px 0 0;
            background: rgba(10, 4, 0, 0.55);
            backdrop-filter: blur(2px);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            z-index: 998;
        }
        .nav-backdrop.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* SHARED MODALS */
        .auth-modal-backdrop {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 20% 15%, rgba(255,107,0,0.2), rgba(12,4,0,0.88) 65%);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 1600;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.28s ease, visibility 0.28s ease;
        }
        .auth-modal-backdrop.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }
        .auth-modal-panel {
            width: min(480px, 100%);
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.16);
            background: linear-gradient(165deg, #fffaf4, #fff 35%);
            box-shadow: 0 28px 60px rgba(0,0,0,0.4);
            padding: 1.35rem;
            transform: translateY(14px) scale(0.98);
            opacity: 0;
            transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.25s ease;
        }
        .auth-modal-backdrop.is-open .auth-modal-panel {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        .auth-modal-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: rgba(255,107,0,0.14);
            color: var(--saffron);
            font-size: 1.5rem;
            margin: 0 auto 0.9rem;
        }
        .auth-modal-icon.is-success { background: rgba(46,125,50,0.14); color: var(--green); }
        .auth-modal-icon.is-error   { background: rgba(178,34,34,0.14); color: var(--deep-red); }
        .auth-modal-icon.is-warning { background: rgba(244,162,45,0.18); color: #a55400; }
        .auth-modal-title {
            text-align: center;
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.35rem;
        }
        .auth-modal-text {
            text-align: center;
            font-size: 0.93rem;
            color: #6e5642;
            line-height: 1.7;
            margin-bottom: 1.15rem;
        }
        .auth-modal-actions {
            display: flex;
            gap: 0.65rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .auth-btn {
            border: none;
            border-radius: 10px;
            padding: 0.58rem 1.1rem;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        .auth-btn-primary { background: var(--saffron); color: #fff; }
        .auth-btn-primary:hover { background: #e85f00; }
        .auth-btn-outline { background: #fff; color: #6f5845; border: 1px solid #e7d9c8; }
        .auth-btn-outline:hover { border-color: var(--saffron); color: var(--saffron); }
        .auth-btn-danger { background: var(--deep-red); color: #fff; }
        .auth-btn-danger:hover { background: #8f1919; }
        .modal-loader-ring {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 0.95rem;
            border: 4px solid rgba(255,255,255,0.16);
            border-top-color: var(--saffron);
            animation: publicSpin 0.85s linear infinite;
        }
        .modal-loader-text {
            text-align: center;
            color: #f4d9c1;
            font-size: 0.92rem;
            line-height: 1.6;
        }
        .modal-loader-text strong {
            display: block;
            color: #fff;
            font-size: 1.02rem;
            margin-bottom: 0.25rem;
        }
        @keyframes publicSpin { to { transform: rotate(360deg); } }
        @media (prefers-reduced-motion: reduce) {
            .auth-modal-backdrop, .auth-modal-panel { transition: none !important; }
            .modal-loader-ring { animation: none !important; }
        }

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
        .footer-brand { display: inline-flex; align-items: center; gap: 0.9rem; margin-bottom: 0.8rem; }
        .footer-brand .brand-logo-mark { width: 52px; height: 52px; }
        .footer-brand .brand-wordmark strong { font-size: 1.22rem; }
        .footer-brand .brand-wordmark small { color: rgba(255,255,255,0.55); }
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
        .scroll-top-btn {
            position: fixed;
            right: 1.15rem;
            bottom: 1.15rem;
            width: 46px;
            height: 46px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(180deg, #ff7b1f, #ff5f00);
            color: #fff;
            box-shadow: 0 14px 28px rgba(255,107,0,0.28);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 490; /* below cart bar z-index 500 */
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(10px);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s ease;
        }
        .scroll-top-btn.is-visible { opacity: 1; visibility: visible; pointer-events: auto; transform: translateY(0); }
        .scroll-top-btn:hover { background: linear-gradient(180deg, #ff8c36, #e95a00); transform: translateY(-2px); }
        .scroll-top-btn:focus-visible { outline: 3px solid rgba(255,107,0,0.18); outline-offset: 3px; }

        @media (max-width: 1024px) {
            .navbar { padding: 0 1.25rem; }
            .navbar-nav a { padding: 0.45rem 0.7rem; font-size: 0.84rem; }
            footer { padding-inline: 1.5rem; }
            .footer-inner { gap: 2rem; grid-template-columns: 1.7fr 1fr 1fr; }
            .footer-contact { grid-column: 1 / -1; }
        }
        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .navbar-inner { height: 70px; gap: 0.75rem; }
            .navbar-brand { gap: 0.55rem; }
            .brand-logo-mark { width: 40px; height: 40px; }
            .brand-wordmark strong { font-size: 0.98rem; }
            .brand-wordmark small { letter-spacing: 0.85px; }
            .navbar-nav {
                position: fixed;
                top: 70px; left: 0; right: 0;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
                padding: 1rem;
                background: linear-gradient(180deg, rgba(26,10,0,0.98), rgba(38,16,0,0.96));
                border-top: 1px solid rgba(255,255,255,0.08);
                box-shadow: 0 22px 40px rgba(0,0,0,0.28);
                transform: translateY(-12px);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: transform 0.25s ease, opacity 0.25s ease, visibility 0.25s ease;
                max-height: calc(100vh - 70px);
                overflow-y: auto;
                z-index: 999;
            }
            .navbar-nav.is-open { transform: translateY(0); opacity: 1; visibility: visible; pointer-events: auto; }
            .navbar-nav a { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0.8rem 0.95rem; border-radius: 12px; background: rgba(255,255,255,0.04); }
            .navbar-nav .btn-nav-order { justify-content: center; margin-top: 0.35rem; width: 100%; padding: 0.8rem 1rem !important; }
            .hamburger { display: inline-flex; }
            footer { padding: 2.5rem 1rem 1.25rem; }
            .footer-inner { grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        }
        @media (max-width: 480px) {
            .navbar-brand { gap: 0.45rem; }
            .brand-logo-mark { width: 36px; height: 36px; }
            .brand-wordmark strong { font-size: 0.86rem; }
            .brand-wordmark small { font-size: 0.46rem; }
            .footer-inner { grid-template-columns: 1fr; }
            .social-links { flex-wrap: wrap; }
            .scroll-top-btn { right: 0.85rem; bottom: 0.85rem; width: 42px; height: 42px; border-radius: 12px; }
        }
    </style>
    @stack('styles')
</head>
<body>
@php
    $showTrackOrderLink = (auth()->check() && auth()->user()->role === 'customer')
        || session()->has('last_tracked_order_id');
@endphp

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="navbar-brand" aria-label="AMV Home">
            <img src="{{ asset('images/mmv-logo.svg') }}" alt="AMV Logo" class="brand-logo-mark">
            <span class="brand-wordmark">
                <strong>Amdavadi Misal</strong>
                <small>Vadapav</small>
            </span>
        </a>
        <button class="hamburger" type="button" id="navToggle" aria-expanded="false" aria-controls="navMenu" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="navbar-nav" id="navMenu">
            <li><a href="{{ url('/') }}"         class="{{ request()->is('/')         ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/menu') }}"      class="{{ request()->is('menu')      ? 'active' : '' }}">Menu</a></li>
            <li><a href="{{ url('/about') }}"     class="{{ request()->is('about')     ? 'active' : '' }}">About</a></li>
            <li><a href="{{ url('/catering') }}"  class="{{ request()->is('catering')  ? 'active' : '' }}">Catering</a></li>
            <li><a href="{{ url('/franchise') }}" class="{{ request()->is('franchise') ? 'active' : '' }}">Franchise</a></li>
            <li><a href="{{ url('/contact') }}"   class="{{ request()->is('contact')   ? 'active' : '' }}">Contact</a></li>
            @if($showTrackOrderLink)
                <li><a href="{{ route('order.latest') }}" class="{{ request()->routeIs('order.confirmation') || request()->routeIs('order.latest') ? 'active' : '' }}">Track Order</a></li>
            @endif
            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                @elseif(auth()->user()->role === 'staff')
                    <li><a href="{{ route('admin.orders.index') }}" style="color:var(--turmeric);"><i class="fas fa-tools"></i> Staff Panel</a></li>
                @endif
                <li>
                    <a href="{{ route('logout') }}" id="logoutTrigger">Logout</a>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" class="btn-nav-order">Register</a></li>
            @endauth
            <li><a href="{{ route('checkout') }}" class="btn-nav-order"><i class="fas fa-shopping-bag"></i>&nbsp;Order Now</a></li>
        </ul>

        <a href="{{ route('checkout') }}" class="cart-nav-link" aria-label="Your cart" title="View Cart">
            <i class="fas fa-shopping-cart" style="font-size:0.95rem;"></i>
            <span id="cartNavBadge" class="cart-nav-badge {{ app(\App\Services\Cart::class)->count() > 0 ? 'visible' : '' }}">
                {{ app(\App\Services\Cart::class)->count() ?: '' }}
            </span>
        </a>

        @auth
            <form id="navbar-logout-form" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
        @endauth
    </div>
</nav>
<div class="nav-backdrop" id="navBackdrop" aria-hidden="true"></div>

{{-- Flash Message Modal --}}
<div id="flashMessageModal" class="auth-modal-backdrop" aria-hidden="true">
    <div class="auth-modal-panel" role="dialog" aria-modal="true" aria-labelledby="flashModalTitle">
        <div id="flashModalIcon" class="auth-modal-icon is-success"><i class="fas fa-circle-check"></i></div>
        <h2 id="flashModalTitle" class="auth-modal-title">Success</h2>
        <p id="flashModalText" class="auth-modal-text"></p>
        <div class="auth-modal-actions">
            <button type="button" class="auth-btn auth-btn-primary" id="flashModalClose">Continue</button>
        </div>
    </div>
</div>

{{-- Logout Confirm Modal --}}
<div id="logoutConfirmModal" class="auth-modal-backdrop" aria-hidden="true">
    <div class="auth-modal-panel" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
        <div class="auth-modal-icon is-warning"><i class="fas fa-right-from-bracket"></i></div>
        <h2 id="logoutModalTitle" class="auth-modal-title">Confirm Logout</h2>
        <p class="auth-modal-text">Do you want to logout now? You can login again anytime.</p>
        <div class="auth-modal-actions">
            <button type="button" class="auth-btn auth-btn-outline" id="logoutCancelBtn">Cancel</button>
            <button type="button" class="auth-btn auth-btn-danger"  id="logoutConfirmBtn">Yes, Logout</button>
        </div>
    </div>
</div>

{{-- Public Loader Modal --}}
<div id="publicLoaderModal" class="auth-modal-backdrop" aria-hidden="true">
    <div class="auth-modal-panel" role="dialog" aria-modal="true" aria-labelledby="publicLoaderTitle">
        <div class="modal-loader-ring"></div>
        <div class="modal-loader-text">
            <strong id="publicLoaderTitle">Processing your request...</strong>
            <span id="publicLoaderText">Please wait while we complete this step.</span>
        </div>
    </div>
</div>

@yield('content')

<button type="button" class="scroll-top-btn" id="scrollTopBtn" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

<footer>
    <div class="footer-inner">
        <div>
            <div class="footer-brand">
                <img src="{{ asset('images/mmv-logo.svg') }}" alt="AMV Logo" class="brand-logo-mark">
                <span class="brand-wordmark">
                    <strong>Amdavadi Misal</strong>
                    <small>Vadapav</small>
                </span>
            </div>
            <p style="font-size:0.9rem; line-height:1.7; color:#aaa;">Amdavadi Misal and Vadapav — bringing bold, authentic street-food flavor to your plate. 100% Vegetarian. 100% Love.</p>
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
                <li><a href="{{ route('checkout') }}">Order Online</a></li>
                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h4>Contact Us</h4>
            <p><i class="fas fa-map-marker-alt"></i> Titanium City Centre, Anandnagar Road, Satelite, Ahmedabad, Gujarat 380015</p>
            <p><i class="fas fa-envelope"></i> contact@theAmdavadimisalvadapav.com</p>
            <p><i class="fas fa-phone"></i> +1 (XXX) XXX-XXXX</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} AMV – Amdavadi Misal and Vadapav. All Rights Reserved. | Dil Bole Wow!!</p>
    </div>
</footer>

{{-- Cart bottom bar (hide on checkout flow pages to avoid duplicate UI) --}}
@unless(request()->routeIs('checkout') || request()->routeIs('order.confirmation'))
    @include('components.cart-bar')
@endunless

<script>
function toggleMenu() {
    const nav = document.getElementById('navMenu');
    const navBackdrop = document.getElementById('navBackdrop');
    const navToggle = document.getElementById('navToggle');
    const isOpen = nav.classList.toggle('is-open');
    if (navBackdrop) { navBackdrop.classList.toggle('is-open', isOpen); navBackdrop.setAttribute('aria-hidden', String(!isOpen)); }
    if (navToggle)   { navToggle.setAttribute('aria-expanded', String(isOpen)); navToggle.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>'; }
    document.body.style.overflow = isOpen ? 'hidden' : '';
}

function closeMenu() {
    const nav = document.getElementById('navMenu');
    const navBackdrop = document.getElementById('navBackdrop');
    const navToggle = document.getElementById('navToggle');
    if (!nav) return;
    nav.classList.remove('is-open');
    if (navBackdrop) { navBackdrop.classList.remove('is-open'); navBackdrop.setAttribute('aria-hidden', 'true'); }
    if (navToggle)   { navToggle.setAttribute('aria-expanded', 'false'); navToggle.innerHTML = '<i class="fas fa-bars"></i>'; }
    document.body.style.overflow = '';
}

function openAuthModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    const firstFocusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    if (firstFocusable) setTimeout(() => firstFocusable.focus(), 60);
    document.body.style.overflow = 'hidden';
}

function closeAuthModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}

@php
    $publicFlashPayload = null;
    if (session('success')) {
        $publicFlashPayload = [
            'kind'    => session('flash_modal', session('auth_modal') === 'welcome' ? 'welcome-back' : 'success'),
            'message' => session('success'),
            'type'    => 'success',
        ];
    } elseif (session('error')) {
        $publicFlashPayload = [
            'kind'    => session('flash_modal', 'error'),
            'message' => session('error'),
            'type'    => 'error',
        ];
    }
@endphp

document.addEventListener('DOMContentLoaded', function () {
    const navToggle     = document.getElementById('navToggle');
    const navBackdrop   = document.getElementById('navBackdrop');
    const scrollTopBtn  = document.getElementById('scrollTopBtn');

    if (navToggle)   navToggle.addEventListener('click', toggleMenu);
    if (navBackdrop) navBackdrop.addEventListener('click', closeMenu);

    document.querySelectorAll('#navMenu a').forEach(function (link) {
        link.addEventListener('click', function () { if (window.innerWidth <= 768) closeMenu(); });
    });

    function syncScrollTopButton() {
        if (!scrollTopBtn) return;
        scrollTopBtn.classList.toggle('is-visible', window.scrollY > 280);
    }
    if (scrollTopBtn) scrollTopBtn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    window.addEventListener('scroll', syncScrollTopButton, { passive: true });
    syncScrollTopButton();

    const flashPayload      = @json($publicFlashPayload);
    const flashModal        = document.getElementById('flashMessageModal');
    const flashModalIcon    = document.getElementById('flashModalIcon');
    const flashModalTitle   = document.getElementById('flashModalTitle');
    const flashModalText    = document.getElementById('flashModalText');
    const flashModalClose   = document.getElementById('flashModalClose');
    const publicLoaderModal = document.getElementById('publicLoaderModal');
    const publicLoaderTitle = document.getElementById('publicLoaderTitle');
    const publicLoaderText  = document.getElementById('publicLoaderText');
    const orderTrackingUrl  = @json(route('order.latest'));

    const flashModalMap = {
        'welcome-back':      { title: 'Welcome Back!',               icon: 'fa-hand-sparkles',      iconClass: '',           button: "Let's Go" },
        'welcome-family':    { title: 'Welcome to AMV!',             icon: 'fa-party-horn',          iconClass: '',           button: 'Start Exploring' },
        'logged-out':        { title: 'Logged Out',                  icon: 'fa-circle-check',        iconClass: 'is-success', button: 'See You Soon' },
        'contact-success':   { title: 'Message Sent',                icon: 'fa-paper-plane',         iconClass: 'is-success', button: 'Perfect' },
        'catering-success':  { title: 'Catering Request Sent',       icon: 'fa-champagne-glasses',   iconClass: 'is-success', button: 'Great' },
        'franchise-success': { title: 'Enquiry Received',            icon: 'fa-store',               iconClass: 'is-success', button: 'Continue' },
        'order-success':     { title: 'Order Confirmed',             icon: 'fa-bag-shopping',        iconClass: 'is-success', button: 'Track Order' },
        'order-error':       { title: 'Order Could Not Be Placed',   icon: 'fa-circle-exclamation',  iconClass: 'is-error',   button: 'Try Again' },
        'empty-cart':        { title: 'Oops!!!',                     icon: 'fa-cart-shopping',       iconClass: 'is-warning', button: 'Continue' },
        'error':             { title: 'Something Went Wrong',        icon: 'fa-circle-exclamation',  iconClass: 'is-error',   button: 'Close' },
        'success':           { title: 'Success',                     icon: 'fa-circle-check',        iconClass: 'is-success', button: 'Continue' },
    };

    function configureFlashModal(payload) {
        if (!payload || !flashModal) return;
        const config = flashModalMap[payload.kind] || flashModalMap[payload.type] || flashModalMap.success;
        flashModalTitle.textContent   = config.title;
        flashModalText.textContent    = payload.message || '';
        flashModalClose.textContent   = config.button || 'Continue';
        flashModalIcon.className      = 'auth-modal-icon ' + (config.iconClass || '');
        flashModalIcon.innerHTML      = '<i class="fas ' + config.icon + '"></i>';
    }

    function showPublicLoader(title, text) {
        if (!publicLoaderModal) return;
        publicLoaderTitle.textContent = title || 'Processing your request...';
        publicLoaderText.textContent  = text  || 'Please wait while we complete this step.';
        openAuthModal('publicLoaderModal');
    }

    if (flashPayload) { configureFlashModal(flashPayload); openAuthModal('flashMessageModal'); }
    if (flashModalClose) {
        flashModalClose.addEventListener('click', function () {
            if (flashPayload?.kind === 'order-success') {
                window.location.href = orderTrackingUrl;
                return;
            }

            closeAuthModal('flashMessageModal');
        });
    }

    const logoutTrigger    = document.getElementById('logoutTrigger');
    const logoutConfirmBtn = document.getElementById('logoutConfirmBtn');
    const logoutCancelBtn  = document.getElementById('logoutCancelBtn');
    const logoutForm       = document.getElementById('navbar-logout-form');

    if (logoutTrigger && logoutForm) {
        logoutTrigger.addEventListener('click', function (e) { e.preventDefault(); openAuthModal('logoutConfirmModal'); });
    }
    if (logoutCancelBtn)             logoutCancelBtn.addEventListener('click', function () { closeAuthModal('logoutConfirmModal'); });
    if (logoutConfirmBtn && logoutForm) logoutConfirmBtn.addEventListener('click', function () { logoutForm.submit(); });

    document.querySelectorAll('form[data-public-submit]').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (typeof form.reportValidity === 'function' && !form.reportValidity()) return;
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitButton) submitButton.disabled = true;
            showPublicLoader(form.dataset.loadingTitle || 'Processing your request...', form.dataset.loadingText || 'Please wait while we complete this step.');
        });
    });

    document.querySelectorAll('.auth-modal-backdrop').forEach(function (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (backdrop.id === 'publicLoaderModal') return;
            if (e.target === backdrop) {
                backdrop.classList.remove('is-open');
                backdrop.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        closeMenu();
        document.querySelectorAll('.auth-modal-backdrop.is-open').forEach(function (openModal) {
            if (openModal.id === 'publicLoaderModal') return;
            openModal.classList.remove('is-open');
            openModal.setAttribute('aria-hidden', 'true');
        });
        document.body.style.overflow = '';
    });
});
</script>

@stack('scripts')
</body>
</html>
