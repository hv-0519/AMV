@extends('layouts.app')
@section('title', 'Franchise Opportunities')

@push('styles')
<style>
    .franchise-hero {
        background: linear-gradient(135deg, #1A0A00 0%, #3D1A00 100%);
        padding: 5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .franchise-hero::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at 50% 50%, rgba(255,107,0,0.12), transparent 70%); }
    .franchise-hero h1 { font-family:'Playfair Display',serif; font-size:clamp(2.5rem,5vw,4rem); font-weight:900; color:#fff; position:relative; z-index:1; }
    .franchise-hero h1 span { color:var(--saffron); }
    .franchise-hero p { color:#ccc; font-size:1.1rem; margin-top:1rem; position:relative; z-index:1; max-width:650px; margin-left:auto; margin-right:auto; line-height:1.7; }

    section { padding: 5rem 2rem; }
    .section-inner { max-width: 1200px; margin: 0 auto; }
    .section-tag { color:var(--saffron); font-weight:700; font-size:0.8rem; letter-spacing:3px; text-transform:uppercase; margin-bottom:0.5rem; display:block; }
    .section-title { font-family:'Playfair Display',serif; font-size:clamp(2rem,4vw,3rem); font-weight:900; color:var(--dark); margin-bottom:1rem; }
    .section-title span { color:var(--saffron); }

    /* Benefits */
    .benefits-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(250px,1fr)); gap:1.5rem; margin-top:3rem; }
    .benefit-card { background:#fff; border-radius:18px; padding:2rem; box-shadow:0 3px 15px rgba(0,0,0,0.06); transition:all 0.3s; position:relative; overflow:hidden; }
    .benefit-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:var(--saffron); }
    .benefit-card:hover { transform:translateY(-5px); box-shadow:0 12px 30px rgba(255,107,0,0.12); }
    .benefit-icon { font-size:2.5rem; margin-bottom:1rem; }
    .benefit-card h3 { font-size:1rem; font-weight:700; color:var(--dark); margin-bottom:0.5rem; }
    .benefit-card p { font-size:0.85rem; color:#777; line-height:1.6; }

    /* Steps */
    .steps-section { background:#fff8ef; }
    .steps-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:2rem; margin-top:3rem; position:relative; }
    .steps-grid::before { content:''; position:absolute; top:35px; left:10%; right:10%; height:2px; background:linear-gradient(to right, var(--saffron), var(--deep-red)); z-index:0; }
    .step-card { text-align:center; position:relative; z-index:1; }
    .step-number { width:70px; height:70px; background:var(--saffron); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem; font-weight:900; color:#fff; font-family:'Playfair Display',serif; border:4px solid #fff; box-shadow:0 4px 15px rgba(255,107,0,0.3); }
    .step-card h3 { font-size:0.95rem; font-weight:700; color:var(--dark); margin-bottom:0.4rem; }
    .step-card p { font-size:0.82rem; color:#888; }

    /* Investment */
    .investment-section { background:var(--dark); color:#fff; text-align:center; }
    .investment-section h2 { font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:900; margin-bottom:0.5rem; }
    .investment-section h2 span { color:var(--saffron); }
    .investment-section p { color:#aaa; margin-bottom:3rem; }
    .investment-cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:1.5rem; }
    .inv-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,107,0,0.3); border-radius:16px; padding:2rem; transition:all 0.3s; }
    .inv-card:hover { background:rgba(255,107,0,0.1); border-color:var(--saffron); }
    .inv-card h3 { font-size:1.1rem; font-weight:700; color:#fff; margin-bottom:0.5rem; }
    .inv-amount { font-size:1.8rem; font-weight:900; color:var(--saffron); font-family:'Playfair Display',serif; margin-bottom:0.5rem; }
    .inv-card p { color:#aaa; font-size:0.85rem; line-height:1.6; }

    /* Form */
    .form-grid { display:grid; grid-template-columns:1fr 1.5fr; gap:3rem; align-items:start; }
    .form-info h3 { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; color:var(--dark); margin-bottom:1rem; }
    .form-info p { color:#666; font-size:0.95rem; line-height:1.7; margin-bottom:1.5rem; }
    .checklist { list-style:none; }
    .checklist li { display:flex; gap:0.6rem; align-items:center; font-size:0.9rem; color:#555; margin-bottom:0.6rem; }
    .checklist li::before { content:'✅'; }
    .franchise-form-box { background:#fff; border-radius:20px; padding:2.5rem; box-shadow:0 4px 25px rgba(0,0,0,0.07); }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-group { margin-bottom:1.2rem; }
    .form-group label { display:block; font-size:0.85rem; font-weight:600; color:#444; margin-bottom:0.4rem; }
    .form-control { width:100%; padding:0.8rem 1rem; border:2px solid #eee; border-radius:10px; font-size:0.9rem; font-family:'Poppins',sans-serif; transition:border-color 0.3s; }
    .form-control:focus { outline:none; border-color:var(--saffron); }
    .form-control.is-invalid { border-color:var(--deep-red); }
    .invalid-feedback { color:var(--deep-red); font-size:0.75rem; margin-top:0.2rem; }
    .btn-submit { width:100%; background:var(--saffron); color:#fff; border:none; padding:1rem; border-radius:12px; font-size:1rem; font-weight:700; cursor:pointer; font-family:'Poppins',sans-serif; transition:all 0.3s; }
    .btn-submit:hover { background:var(--deep-red); transform:translateY(-2px); }

    @media (max-width:768px) {
        .form-grid { grid-template-columns:1fr; }
        .form-row { grid-template-columns:1fr; }
        .steps-grid::before { display:none; }
    }
</style>
@endpush

@section('content')

<div class="franchise-hero">
    <h1>🏪 Own an <span>MMV</span> Franchise</h1>
    <p>Be your own boss. Bring the taste of Maharashtra to your community. Join a proven brand that's growing globally.</p>
</div>

<!-- Benefits -->
<section style="background:#fff8ef;">
    <div class="section-inner" style="text-align:center;">
        <span class="section-tag">Why Partner With MMV</span>
        <h2 class="section-title">The MMV <span>Advantage</span></h2>
        <div class="benefits-grid">
            <div class="benefit-card"><div class="benefit-icon">🏆</div><h3>Trusted Brand</h3><p>A recognized and growing brand with a loyal customer base and strong reputation.</p></div>
            <div class="benefit-card"><div class="benefit-icon">📚</div><h3>Full Training</h3><p>Comprehensive training program for you and your staff — recipes, operations, and more.</p></div>
            <div class="benefit-card"><div class="benefit-icon">🤝</div><h3>Ongoing Support</h3><p>Dedicated franchise support team available to help you at every step of your journey.</p></div>
            <div class="benefit-card"><div class="benefit-icon">📣</div><h3>Marketing Support</h3><p>National and regional marketing campaigns to drive footfall to your outlet.</p></div>
            <div class="benefit-card"><div class="benefit-icon">🌿</div><h3>Proven Menu</h3><p>A tested, customer-loved menu that sells itself — no guesswork needed.</p></div>
            <div class="benefit-card"><div class="benefit-icon">📈</div><h3>High ROI</h3><p>A low-investment, high-return model with fast payback periods in most locations.</p></div>
        </div>
    </div>
</section>

<!-- Steps -->
<section class="steps-section">
    <div class="section-inner" style="text-align:center;">
        <span class="section-tag">The Process</span>
        <h2 class="section-title">How to <span>Get Started</span></h2>
        <div class="steps-grid">
            <div class="step-card"><div class="step-number">1</div><h3>Submit Enquiry</h3><p>Fill in the form below with your details and location.</p></div>
            <div class="step-card"><div class="step-number">2</div><h3>Discovery Call</h3><p>Our franchise team will call you for an initial consultation.</p></div>
            <div class="step-card"><div class="step-number">3</div><h3>Site Evaluation</h3><p>We evaluate your proposed location for feasibility.</p></div>
            <div class="step-card"><div class="step-number">4</div><h3>Agreement & Training</h3><p>Sign the franchise agreement and complete full training.</p></div>
            <div class="step-card"><div class="step-number">5</div><h3>Launch! 🎉</h3><p>Open your MMV outlet and start serving customers!</p></div>
        </div>
    </div>
</section>

<!-- Investment -->
<section class="investment-section">
    <div class="section-inner">
        <h2>Flexible <span>Investment Models</span></h2>
        <p>Choose the model that fits your budget and goals</p>
        <div class="investment-cards">
            <div class="inv-card">
                <h3>🥙 Kiosk Model</h3>
                <div class="inv-amount">₹5L – ₹10L</div>
                <p>Perfect for high-footfall spots — malls, food courts, colleges. Compact setup with quick ROI.</p>
            </div>
            <div class="inv-card">
                <h3>🍲 Express Outlet</h3>
                <div class="inv-amount">₹10L – ₹20L</div>
                <p>A full quick-service format with dine-in and takeaway. Ideal for commercial areas and streets.</p>
            </div>
            <div class="inv-card">
                <h3>🏪 Full Restaurant</h3>
                <div class="inv-amount">₹20L – ₹40L</div>
                <p>A premium sit-down MMV experience with the complete menu, ambiance and catering capability.</p>
            </div>
        </div>
    </div>
</section>

<!-- Enquiry Form -->
<section style="background:#fff;">
    <div class="section-inner">
        <div class="form-grid">
            <div class="form-info">
                <h3>Apply for Franchise</h3>
                <p>Ready to bring MMV to your city? Submit your enquiry and we'll get back to you within 48 hours.</p>
                <ul class="checklist">
                    <li>No prior food business experience needed</li>
                    <li>Full training & onboarding provided</li>
                    <li>Marketing & branding support included</li>
                    <li>Dedicated franchise manager assigned</li>
                    <li>Supply chain & procurement support</li>
                    <li>Transparent agreement with no hidden costs</li>
                </ul>
            </div>

            <div class="franchise-form-box">
                <form method="POST" action="{{ route('franchise.submit') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Your full name" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="+91 98765 43210" value="{{ old('phone') }}" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="you@example.com" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City *</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                   placeholder="e.g. Pune" value="{{ old('city') }}" required>
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>State *</label>
                            <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                   placeholder="e.g. Maharashtra" value="{{ old('state') }}" required>
                            @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Investment Capacity *</label>
                        <select name="investment_capacity" class="form-control @error('investment_capacity') is-invalid @enderror" required>
                            <option value="">Select investment range</option>
                            @foreach(['₹5L – ₹10L (Kiosk)','₹10L – ₹20L (Express Outlet)','₹20L – ₹40L (Full Restaurant)','₹40L+'] as $range)
                            <option value="{{ $range }}" {{ old('investment_capacity') == $range ? 'selected' : '' }}>{{ $range }}</option>
                            @endforeach
                        </select>
                        @error('investment_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Tell Us About Yourself</label>
                        <textarea name="message" class="form-control" rows="3"
                                  placeholder="Brief background, why you want to partner with MMV, any relevant experience...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-submit">🚀 Submit Franchise Enquiry</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
