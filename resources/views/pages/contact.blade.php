@extends('layouts.app')
@section('title', 'Contact Us')

@push('styles')
<style>
    .contact-hero {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        padding: 4rem 2rem;
        text-align: center;
    }
    .contact-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; color: #fff; }
    .contact-hero h1 span { color: var(--saffron); }
    .contact-hero p { color: #ccc; margin-top: 0.8rem; font-size: 1.05rem; }

    .contact-page { max-width: 1100px; margin: 0 auto; padding: 4rem 2rem; display: grid; grid-template-columns: 1fr 1.5fr; gap: 3rem; align-items: start; }

    /* Info Cards */
    .info-cards { display: flex; flex-direction: column; gap: 1.2rem; }
    .info-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        box-shadow: 0 3px 15px rgba(0,0,0,0.06);
        border-left: 4px solid var(--saffron);
        transition: transform 0.3s;
    }
    .info-card:hover { transform: translateX(5px); }
    .info-icon { width: 46px; height: 46px; background: rgba(255,107,0,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .info-card h4 { font-size: 0.85rem; font-weight: 700; color: var(--dark); margin-bottom: 0.3rem; }
    .info-card p { font-size: 0.88rem; color: #666; line-height: 1.5; }
    .info-card a { color: var(--saffron); text-decoration: none; font-weight: 600; }

    /* Form */
    .contact-form-box {
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 25px rgba(0,0,0,0.07);
    }
    .contact-form-box h2 { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 900; color: var(--dark); margin-bottom: 0.3rem; }
    .contact-form-box p { color: #888; font-size: 0.9rem; margin-bottom: 2rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { margin-bottom: 1.2rem; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #444; margin-bottom: 0.4rem; }
    .form-control { width: 100%; padding: 0.8rem 1rem; border: 2px solid #eee; border-radius: 10px; font-size: 0.9rem; font-family: 'Poppins', sans-serif; transition: border-color 0.3s; }
    .form-control:focus { outline: none; border-color: var(--saffron); }
    .form-control.is-invalid { border-color: var(--deep-red); }
    .invalid-feedback { color: var(--deep-red); font-size: 0.75rem; margin-top: 0.2rem; }
    .btn-submit { width: 100%; background: var(--saffron); color: #fff; border: none; padding: 1rem; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; font-family: 'Poppins', sans-serif; transition: all 0.3s; }
    .btn-submit:hover { background: var(--deep-red); transform: translateY(-2px); }

    @media (max-width: 768px) {
        .contact-page { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="contact-hero">
    <h1>Get in <span>Touch</span></h1>
    <p>We'd love to hear from you. Reach out for orders, catering, franchise, or just to say hi! 🌶️</p>
</div>

<div class="contact-page">
    <!-- Left: Contact Info -->
    <div class="info-cards">
        <div class="info-card">
            <div class="info-icon">📍</div>
            <div>
                <h4>Visit Us</h4>
                <p>Titanium City Centre, 100 Feet Anandnagar Road, Near Sachin Towers, Satelite, Prahaladnagar, Ahmedabad, Gujarat 380015</p>
            </div>
        </div>
        <div class="info-card">
            <div class="info-icon">✉️</div>
            <div>
                <h4>Email Us</h4>
                <p><a href="mailto:canada@mmvmumbaiya.com">canada@mmvmumbaiya.com</a></p>
                <p style="margin-top:0.3rem; font-size:0.8rem; color:#aaa;">We reply within 24 hours</p>
            </div>
        </div>
        <div class="info-card">
            <div class="info-icon">📞</div>
            <div>
                <h4>Call Us</h4>
                <p><a href="tel:+1XXXXXXXXXX">+1 (XXX) XXX-XXXX</a></p>
                <p style="margin-top:0.3rem; font-size:0.8rem; color:#aaa;">Mon–Sat, 9am – 8pm</p>
            </div>
        </div>
        <div class="info-card">
            <div class="info-icon">📱</div>
            <div>
                <h4>Follow Us</h4>
                <p>Stay updated with our latest dishes, offers, and news on social media.</p>
                <div style="display:flex; gap:0.8rem; margin-top:0.6rem;">
                    <a href="#" style="color:var(--saffron);"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" style="color:var(--saffron);"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" style="color:var(--saffron);"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
        </div>
        <div class="info-card" style="border-left-color:var(--deep-red);">
            <div class="info-icon" style="background:rgba(178,34,34,0.1);">🕐</div>
            <div>
                <h4>Opening Hours</h4>
                <p>Monday – Friday: 8:00 AM – 9:00 PM</p>
                <p>Saturday – Sunday: 8:00 AM – 10:00 PM</p>
            </div>
        </div>
    </div>

    <!-- Right: Contact Form -->
    <div class="contact-form-box">
        <h2>Send a Message</h2>
        <p>Fill in the form and we'll get back to you soon.</p>

        <form method="POST" action="{{ route('contact.send') }}" data-public-submit data-loading-title="Sending your message..." data-loading-text="We are delivering your enquiry to the MMV team.">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Your Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Ravi Sharma" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           placeholder="+91 98765 43210" value="{{ old('phone') }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       placeholder="you@example.com" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Subject</label>
                <select name="subject" class="form-control">
                    <option value="">Select a topic</option>
                    <option value="General Enquiry">General Enquiry</option>
                    <option value="Order Issue">Order Issue</option>
                    <option value="Catering">Catering Enquiry</option>
                    <option value="Franchise">Franchise Enquiry</option>
                    <option value="Feedback">Feedback</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Message *</label>
                <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                          rows="5" placeholder="Tell us how we can help you..." required>{{ old('message') }}</textarea>
                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn-submit">
                📨 Send Message
            </button>
        </form>
    </div>
</div>

@endsection
