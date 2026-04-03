@extends('layouts.app')
@section('title', 'Reset Password')

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
    @media (max-width: 600px) {
        .auth-container { grid-template-columns: 1fr; }
        .auth-left { display: none; }
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-left">
            <div class="auth-left-emoji">🔐</div>
            <h2>New Password</h2>
            <p>Choose a strong new password for your AMV account. Dil Bole Wow!</p>
        </div>
        <div class="auth-right">
            <h1>Set New Password</h1>
            <p class="subtitle">Enter and confirm your new password below</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token & email are hidden — required by Laravel's password broker -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="you@example.com"
                           value="{{ old('email', $request->email) }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Min 8 characters"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Repeat new password"
                           required>
                </div>

                <button type="submit" class="btn-submit">🔐 Reset My Password</button>
            </form>

            <div class="auth-footer">
                Remembered it? <a href="{{ route('login') }}">Sign in →</a>
            </div>
        </div>
    </div>
</div>
@endsection
