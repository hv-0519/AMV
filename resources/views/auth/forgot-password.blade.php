@extends('layouts.app')
@section('title', 'Forgot Password')

@push('styles')
<style>
    .auth-page {
        min-height: 90vh;
        background: linear-gradient(135deg, #1A0A00 0%, #3D1A00 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .auth-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 900px;
        width: 100%;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }
    .auth-left {
        background: var(--saffron);
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .auth-left::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .auth-left::after {
        content: '';
        position: absolute;
        bottom: -30px; left: -30px;
        width: 150px; height: 150px;
        background: rgba(0,0,0,0.1);
        border-radius: 50%;
    }
    .auth-left-emoji { font-size: 5rem; margin-bottom: 1.5rem; position: relative; z-index: 1; }
    .auth-left h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 900;
        color: #fff;
        position: relative;
        z-index: 1;
        margin-bottom: 0.5rem;
    }
    .auth-left p { color: rgba(255,255,255,0.85); font-size: 0.95rem; line-height: 1.6; position: relative; z-index: 1; }
    .auth-right { background: #fff; padding: 3rem; }
    .auth-right h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 900;
        color: var(--dark);
        margin-bottom: 0.3rem;
    }
    .auth-right .subtitle { color: #888; font-size: 0.9rem; margin-bottom: 2rem; }
    .form-group { margin-bottom: 1.3rem; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #444; margin-bottom: 0.4rem; }
    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #eee;
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: 'Poppins', sans-serif;
        transition: border-color 0.3s;
    }
    .form-control:focus { outline: none; border-color: var(--saffron); }
    .form-control.is-invalid { border-color: var(--deep-red); }
    .invalid-feedback { color: var(--deep-red); font-size: 0.78rem; margin-top: 0.3rem; }
    .btn-submit {
        width: 100%;
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.9rem;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
        margin-top: 0.5rem;
    }
    .btn-submit:hover { background: var(--deep-red); transform: translateY(-2px); }
    .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #888; }
    .auth-footer a { color: var(--saffron); font-weight: 700; text-decoration: none; }
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #86efac;
        color: #166534;
        padding: 0.9rem 1rem;
        border-radius: 10px;
        font-size: 0.88rem;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }
    .reset-loader-overlay {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        background:
            radial-gradient(circle at top, rgba(255, 107, 0, 0.24), transparent 40%),
            rgba(26, 10, 0, 0.92);
        backdrop-filter: blur(6px);
        z-index: 2200;
    }
    .reset-loader-overlay.is-visible {
        display: flex;
    }
    .reset-loader-card {
        width: min(420px, 100%);
        background: linear-gradient(160deg, #2B1200 0%, #1A0A00 100%);
        border: 1px solid rgba(255, 107, 0, 0.24);
        border-radius: 22px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
        padding: 2rem 1.5rem;
        text-align: center;
        color: #fff5eb;
    }
    .reset-loader-spinner {
        width: 62px;
        height: 62px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.14);
        border-top-color: var(--saffron);
        animation: resetLoaderSpin 0.85s linear infinite;
    }
    .reset-loader-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.55rem;
        font-weight: 900;
        margin-bottom: 0.45rem;
        color: #fff;
    }
    .reset-loader-card p {
        font-size: 0.92rem;
        line-height: 1.7;
        color: rgba(255, 245, 235, 0.82);
        margin: 0;
    }
    @keyframes resetLoaderSpin {
        to {
            transform: rotate(360deg);
        }
    }
    @media (max-width: 600px) {
        .auth-container { grid-template-columns: 1fr; }
        .auth-left { display: none; }
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="reset-loader-overlay" id="forgotPasswordLoader" aria-hidden="true">
        <div class="reset-loader-card" role="status" aria-live="polite">
            <div class="reset-loader-spinner" aria-hidden="true"></div>
            <h2>Sending Reset Link</h2>
            <p>Sending reset link to your email. Please wait while we prepare your secure password reset instructions.</p>
        </div>
    </div>

    <div class="auth-container">
        <div class="auth-left">
            <div class="auth-left-emoji">🔑</div>
            <h2>Forgot Password?</h2>
            <p>No worries! Enter your registered email and we'll send you a reset link. Dil Bole Wow!</p>
        </div>
        <div class="auth-right">
            <h1>Reset Password</h1>
            <p class="subtitle">We'll email you a link to reset your password</p>

            @if (session('status'))
                <div class="alert-success">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="you@example.com"
                           value="{{ old('email') }}"
                           required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">📧 Send Reset Link</button>
            </form>

            <div class="auth-footer">
                Remembered it? <a href="{{ route('login') }}">Sign in →</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('forgotPasswordForm');
    const loader = document.getElementById('forgotPasswordLoader');
    const submitButton = form?.querySelector('button[type="submit"]');

    if (!form || !loader || !submitButton) {
        return;
    }

    loader.classList.remove('is-visible');
    loader.setAttribute('aria-hidden', 'true');

    form.addEventListener('submit', function () {
        if (typeof form.reportValidity === 'function' && !form.reportValidity()) {
            return;
        }

        submitButton.disabled = true;
        loader.classList.add('is-visible');
        loader.setAttribute('aria-hidden', 'false');
    });
});
</script>
@endpush
