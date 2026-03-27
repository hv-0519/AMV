@extends('layouts.app')
@section('title', 'Register')

@push('styles')
<style>
    .auth-page {
        min-height: 90vh;
        background: linear-gradient(135deg, #1A0A00 0%, #3D1A00 100%);
        display: flex; align-items: center; justify-content: center; padding: 2rem;
    }
    .auth-container {
        display: grid; grid-template-columns: 1fr 1fr;
        max-width: 900px; width: 100%;
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }
    .auth-left {
        background: linear-gradient(135deg, #B22222, #8B0000);
        padding: 3rem;
        display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;
        position: relative; overflow: hidden;
    }
    .auth-left::before { content:''; position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,0.08); border-radius:50%; }
    .auth-left-emoji { font-size: 5rem; margin-bottom: 1.5rem; }
    .auth-left h2 { font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:#fff; margin-bottom:0.5rem; }
    .auth-left p { color:rgba(255,255,255,0.85); font-size:0.9rem; line-height:1.6; }
    .auth-left .perks { margin-top:1.5rem; text-align:left; }
    .perk-item { display:flex; gap:0.5rem; align-items:center; color:#fff; font-size:0.85rem; margin-bottom:0.5rem; }
    .auth-right { background: #fff; padding: 3rem; overflow-y:auto; }
    .auth-right h1 { font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:var(--dark); margin-bottom:0.3rem; }
    .auth-right .subtitle { color:#888; font-size:0.9rem; margin-bottom:1.5rem; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-group { margin-bottom:1.2rem; }
    .form-group label { display:block; font-size:0.85rem; font-weight:600; color:#444; margin-bottom:0.4rem; }
    .form-control { width:100%; padding:0.8rem 1rem; border:2px solid #eee; border-radius:10px; font-size:0.9rem; font-family:'Poppins',sans-serif; transition:border-color 0.3s; }
    .form-control:focus { outline:none; border-color:var(--saffron); }
    .form-control.is-invalid { border-color:var(--deep-red); }
    .invalid-feedback { color:var(--deep-red); font-size:0.75rem; margin-top:0.2rem; }
    .btn-submit { width:100%; background:var(--saffron); color:#fff; border:none; padding:0.9rem; border-radius:10px; font-size:1rem; font-weight:700; cursor:pointer; font-family:'Poppins',sans-serif; transition:all 0.3s; }
    .btn-submit:hover { background:var(--deep-red); transform:translateY(-2px); }
    .auth-footer { text-align:center; margin-top:1rem; font-size:0.88rem; color:#888; }
    .auth-footer a { color:var(--saffron); font-weight:700; text-decoration:none; }
    @media (max-width:600px) { .auth-container{grid-template-columns:1fr;} .auth-left{display:none;} .form-row{grid-template-columns:1fr;} }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-left">
            <div class="auth-left-emoji">🌶️</div>
            <h2>Join MMV Family</h2>
            <p>Create your account to enjoy the best of Maharashtrian street food!</p>
            <div class="perks">
                <div class="perk-item">✅ Easy online ordering</div>
                <div class="perk-item">✅ Track your orders</div>
                <div class="perk-item">✅ Exclusive member offers</div>
                <div class="perk-item">✅ Save your favourites</div>
                <div class="perk-item">✅ Catering bookings</div>
            </div>
        </div>
        <div class="auth-right">
            <h1>Create Account</h1>
            <p class="subtitle">Sign up to start your MMV journey 🚀</p>

            <form method="POST" action="{{ route('register') }}" data-public-submit data-loading-title="Creating your account..." data-loading-text="We are setting up your MMV profile and getting things ready.">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                               placeholder="Ravi" value="{{ old('first_name') }}" required>
                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                               placeholder="Sharma" value="{{ old('last_name') }}" required>
                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="you@example.com" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           placeholder="+91 98765 43210" value="{{ old('phone') }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min 8 characters" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Repeat password" required>
                    </div>
                </div>
                <div style="font-size:0.82rem; color:#888; margin-bottom:1rem;">
                    By registering, you agree to MMV's <a href="#" style="color:var(--saffron);">Terms & Conditions</a> and <a href="#" style="color:var(--saffron);">Privacy Policy</a>.
                </div>
                <button type="submit" class="btn-submit">🎉 Create My Account</button>
            </form>
            <div class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in →</a>
            </div>
        </div>
    </div>
</div>
@endsection
