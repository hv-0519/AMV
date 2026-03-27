@extends('layouts.app')
@section('title', 'Catering Services')

@push('styles')
<style>
    .catering-hero {
        background: linear-gradient(135deg, #1A0A00 0%, #3D1A00 100%);
        padding: 5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .catering-hero::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at 50% 50%, rgba(255,107,0,0.12), transparent 70%); }
    .catering-hero h1 { font-family:'Playfair Display',serif; font-size:clamp(2.5rem,5vw,4rem); font-weight:900; color:#fff; position:relative; z-index:1; }
    .catering-hero h1 span { color:var(--saffron); }
    .catering-hero p { color:#ccc; font-size:1.1rem; margin-top:1rem; position:relative; z-index:1; max-width:650px; margin-left:auto; margin-right:auto; line-height:1.7; }

    section { padding: 5rem 2rem; }
    .section-inner { max-width: 1200px; margin: 0 auto; }
    .section-tag { color:var(--saffron); font-weight:700; font-size:0.8rem; letter-spacing:3px; text-transform:uppercase; margin-bottom:0.5rem; display:block; }
    .section-title { font-family:'Playfair Display',serif; font-size:clamp(2rem,4vw,3rem); font-weight:900; color:var(--dark); margin-bottom:1rem; }
    .section-title span { color:var(--saffron); }

    /* What We Offer */
    .offers-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.5rem; margin-top:3rem; }
    .offer-card { background:#fff; border-radius:18px; padding:2rem; text-align:center; box-shadow:0 3px 15px rgba(0,0,0,0.06); transition:all 0.3s; border-bottom:3px solid transparent; }
    .offer-card:hover { border-bottom-color:var(--saffron); transform:translateY(-5px); }
    .offer-icon { font-size:3rem; margin-bottom:1rem; }
    .offer-card h3 { font-size:1rem; font-weight:700; color:var(--dark); margin-bottom:0.5rem; }
    .offer-card p { font-size:0.85rem; color:#777; line-height:1.6; }

    /* Why Choose Us */
    .why-section { background:#fff8ef; }
    .why-grid { display:grid; grid-template-columns:1fr 1fr; gap:5rem; align-items:center; }
    .why-list { list-style:none; margin-top:1.5rem; }
    .why-list li { display:flex; gap:1rem; align-items:flex-start; margin-bottom:1.2rem; }
    .why-icon { width:44px; height:44px; background:rgba(255,107,0,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
    .why-list h4 { font-size:0.95rem; font-weight:700; color:var(--dark); margin-bottom:0.2rem; }
    .why-list p { font-size:0.85rem; color:#888; }
    .why-img-box { background:linear-gradient(135deg,var(--dark),#3D1A00); border-radius:24px; padding:3rem; text-align:center; }
    .why-img-box .big-emoji { font-size:6rem; display:block; animation:float 3s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }

    /* Form */
    .form-section { background:#fff; }
    .form-grid { display:grid; grid-template-columns:1fr 1.5fr; gap:3rem; align-items:start; }
    .form-info h3 { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; color:var(--dark); margin-bottom:1rem; }
    .form-info p { color:#666; font-size:0.95rem; line-height:1.7; margin-bottom:1.5rem; }
    .quick-facts { background:#fff8ef; border-radius:16px; padding:1.5rem; }
    .quick-fact { display:flex; gap:0.8rem; align-items:center; margin-bottom:0.8rem; font-size:0.9rem; }
    .quick-fact:last-child { margin-bottom:0; }
    .quick-fact span:first-child { font-size:1.3rem; }
    .catering-form-box { background:#fff; border-radius:20px; padding:2.5rem; box-shadow:0 4px 25px rgba(0,0,0,0.07); }
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
        .why-grid, .form-grid { grid-template-columns:1fr; }
        .form-row { grid-template-columns:1fr; }
    }
</style>
@endpush

@section('content')

<div class="catering-hero">
    <h1>🎉 <span>Catering</span> Services</h1>
    <p>Bring bold street-food flavor to your next celebration. Whether it's a corporate event, wedding, or festival — AMV has you covered.</p>
</div>

<!-- What We Cater -->
<section style="background:#fff8ef;">
    <div class="section-inner" style="text-align:center;">
        <span class="section-tag">Events We Cover</span>
        <h2 class="section-title">Perfect for Every <span>Occasion</span></h2>
        <div class="offers-grid">
            <div class="offer-card"><div class="offer-icon">💍</div><h3>Weddings</h3><p>Make your special day even more memorable with authentic Maharashtrian flavors.</p></div>
            <div class="offer-card"><div class="offer-icon">🏢</div><h3>Corporate Events</h3><p>Impress your team and clients with a unique street food catering experience.</p></div>
            <div class="offer-card"><div class="offer-icon">🎊</div><h3>Birthday Parties</h3><p>Celebrate in style with live counters and unlimited servings of your favourites.</p></div>
            <div class="offer-card"><div class="offer-icon">🎆</div><h3>Festivals</h3><p>Make every festival more vibrant with the taste and aroma of AMV's dishes.</p></div>
            <div class="offer-card"><div class="offer-icon">🎓</div><h3>College Events</h3><p>Food that gets the crowd buzzing — ideal for fests, fairs and alumni gatherings.</p></div>
            <div class="offer-card"><div class="offer-icon">🤝</div><h3>Private Gatherings</h3><p>Intimate family get-togethers made special with home-style Maharashtrian cooking.</p></div>
        </div>
    </div>
</section>

<!-- Why Choose -->
<section class="why-section">
    <div class="section-inner">
        <div class="why-grid">
            <div>
                <span class="section-tag">Why AMV Catering</span>
                <h2 class="section-title">Why Choose <span>Us?</span></h2>
                <ul class="why-list">
                    <li><div class="why-icon">👨‍🍳</div><div><h4>Expert Culinary Team</h4><p>Our trained chefs bring authentic flavors to your event with precision and passion.</p></div></li>
                    <li><div class="why-icon">🌿</div><div><h4>100% Vegetarian Menu</h4><p>All dishes are pure vegetarian — inclusive for every guest at your event.</p></div></li>
                    <li><div class="why-icon">⏰</div><div><h4>On-Time Delivery</h4><p>We understand the importance of timing. Our team arrives well before your event starts.</p></div></li>
                    <li><div class="why-icon">🔧</div><div><h4>Complete Setup & Cleanup</h4><p>We handle everything — from live counters to cleanup — so you can enjoy your event.</p></div></li>
                    <li><div class="why-icon">📋</div><div><h4>Customizable Menus</h4><p>Mix and match from our wide menu to create the perfect catering spread for your guests.</p></div></li>
                </ul>
            </div>
            <div class="why-img-box">
                @php $cateringImgUrl = \App\Models\SiteImage::getImage('catering_section'); @endphp
                @if($cateringImgUrl)
                    <img src="{{ $cateringImgUrl }}" alt="Catering" style="max-height:200px; max-width:100%; object-fit:contain; filter:drop-shadow(0 6px 12px rgba(0,0,0,0.4)); display:block; margin:0 auto 1rem;">
                @else
                    <span class="big-emoji">🍲</span>
                @endif
                <p style="color:#fff; font-family:'Playfair Display',serif; font-size:1.3rem; margin-top:1rem;">Serving <span style="color:var(--saffron);">10+</span> guests to <span style="color:var(--saffron);">1000+</span> guests</p>
                <p style="color:#aaa; font-size:0.9rem; margin-top:0.5rem;">We scale with your needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Booking Form -->
<section class="form-section">
    <div class="section-inner">
        <div class="form-grid">
            <div class="form-info">
                <h3>Book Your Catering</h3>
                <p>Fill in the details below and our catering team will get in touch with you within 24 hours to discuss the menu, pricing and logistics.</p>
                <div class="quick-facts">
                    <div class="quick-fact"><span>⏱️</span><span>Response within 24 hours</span></div>
                    <div class="quick-fact"><span>📞</span><span>Free consultation call</span></div>
                    <div class="quick-fact"><span>🍽️</span><span>Custom menu planning</span></div>
                    <div class="quick-fact"><span>👥</span><span>Min. 20 guests</span></div>
                    <div class="quick-fact"><span>📅</span><span>Book at least 3 days in advance</span></div>
                </div>
            </div>

            <div class="catering-form-box">
                <form method="POST" action="{{ route('catering.submit') }}" data-public-submit data-loading-title="Submitting your catering request..." data-loading-text="We are sharing your event details with the AMV catering team.">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Your Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Full name" value="{{ old('name') }}" required>
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
                            <label>Event Type *</label>
                            <select name="event_type" class="form-control @error('event_type') is-invalid @enderror" required>
                                <option value="">Select event type</option>
                                @foreach(['Wedding','Corporate Event','Birthday Party','Festival','College Event','Private Gathering','Other'] as $type)
                                <option value="{{ $type }}" {{ old('event_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('event_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Event Date *</label>
                            <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
                                   value="{{ old('event_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Expected Number of Guests *</label>
                        <input type="number" name="guests_count" class="form-control @error('guests_count') is-invalid @enderror"
                               placeholder="e.g. 150" min="20" value="{{ old('guests_count') }}" required>
                        @error('guests_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Event Location / Venue *</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                               placeholder="Full address or venue name" value="{{ old('location') }}" required>
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Additional Requirements / Message</label>
                        <textarea name="message" class="form-control" rows="3"
                                  placeholder="Any special menu requirements, dietary needs, or specific requests...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-submit">🎉 Submit Catering Request</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
