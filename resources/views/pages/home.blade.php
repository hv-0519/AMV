@extends('layouts.app')
@section('title', 'Home - Dil Bole Wow!!')

@push('styles')
<style>
    /* HERO */
    .hero {
        background: linear-gradient(135deg, #1A0A00 0%, #3D1A00 50%, #1A0A00 100%);
        min-height: 90vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding: 2rem;
    }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 70% 50%, rgba(255,107,0,0.15) 0%, transparent 60%);
    }
    .hero-content {
        max-width: 1300px;
        margin: 0 auto;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    .hero-tag {
        display: inline-block;
        background: rgba(255,107,0,0.2);
        color: var(--turmeric);
        border: 1px solid rgba(244,162,45,0.4);
        padding: 0.4rem 1.2rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        font-weight: 900;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 0.5rem;
    }
    .hero h1 span { color: var(--saffron); }
    .hero-sub {
        font-size: clamp(1.5rem, 3vw, 2.5rem);
        color: var(--turmeric);
        font-family: 'Playfair Display', serif;
        font-style: italic;
        margin-bottom: 1.5rem;
    }
    .hero p { color: #ccc; font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem; }
    .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }
    .btn-hero-primary {
        background: var(--saffron);
        color: #fff;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 4px 20px rgba(255,107,0,0.4);
    }
    .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255,107,0,0.5); background: #ff7c1a; }
    .btn-hero-outline {
        background: transparent;
        color: #fff;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        border: 2px solid rgba(255,255,255,0.4);
        transition: all 0.3s;
    }
    .btn-hero-outline:hover { border-color: var(--saffron); color: var(--saffron); }
    .hero-image-area {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .hero-food-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,107,0,0.3);
        border-radius: 24px;
        padding: 2rem;
        text-align: center;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        min-height: 480px;
        min-width: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .hero-food-emoji { font-size: 8rem; display: block; animation: float 3s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-15px)} }
    .hero-badge {
        position: absolute;
        background: var(--saffron);
        color: #fff;
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        font-weight: 700;
        z-index: 2;
    }
    .hero-badge.top-right {
        top: 0; right: 0;
        border-bottom-left-radius: 12px;
    }
    .hero-badge.bottom-left {
        bottom: 0; left: 0;
        background: var(--deep-red);
        border-top-right-radius: 12px;
    }
    .stats-row { display: flex; gap: 1.5rem; margin-top: 2rem; }
    .stat-item { text-align: center; }
    .stat-item .num { font-size: 1.8rem; font-weight: 800; color: var(--saffron); font-family: 'Playfair Display', serif; }
    .stat-item .lbl { font-size: 0.75rem; color: #aaa; }

    /* MARQUEE STRIP */
    .marquee-strip {
        background: var(--saffron);
        color: #fff;
        padding: 0.8rem 0;
        overflow: hidden;
        white-space: nowrap;
    }
    .marquee-inner { display: inline-block; animation: marquee 20s linear infinite; font-weight: 600; font-size: 0.9rem; letter-spacing: 1px; }
    @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }

    /* SECTION COMMONS */
    section { padding: 5rem 2rem; }
    .section-inner { max-width: 1300px; margin: 0 auto; }
    .section-tag {
        display: inline-block;
        color: var(--saffron);
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 900;
        color: var(--dark);
        line-height: 1.2;
        margin-bottom: 1rem;
    }
    .section-title span { color: var(--saffron); }
    .section-desc { color: #666; font-size: 1rem; line-height: 1.8; max-width: 600px; }

    /* MENU SECTION */
    .menu-section { background: #fff; }
    .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .menu-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border: 1px solid #f0ebe3;
    }
    .menu-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(255,107,0,0.15); }
    .menu-card-img {
        height: 200px;
        background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        position: relative;
    }
    .menu-card-body { padding: 1.2rem; }
    .menu-card-body h3 { font-size: 1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.3rem; }
    .menu-card-body p { font-size: 0.82rem; color: #888; margin-bottom: 0.8rem; }
    .menu-card-footer { display: flex; justify-content: space-between; align-items: center; }
    .price { font-size: 1.1rem; font-weight: 800; color: var(--saffron); }
    .btn-add-cart {
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-add-cart:hover { background: var(--deep-red); }
    .veg-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #2E7D32;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 5px;
    }

    /* ABOUT SECTION */
    .about-section { background: #fff8ef; }
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; margin-top: 3rem; }
    .about-img-box {
        background: linear-gradient(135deg, var(--dark), #3D1A00);
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        position: relative;
    }
    .about-img-box .big-emoji { font-size: 7rem; }
    .about-features { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem; }
    .feature-item {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        gap: 0.8rem;
        align-items: flex-start;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .feature-icon { font-size: 1.4rem; }
    .feature-item h4 { font-size: 0.85rem; font-weight: 700; color: var(--dark); }
    .feature-item p { font-size: 0.78rem; color: #888; }

    /* BEST SELLERS */
    .bestsellers-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-top: 3rem; }
    .bs-card {
        background: var(--dark);
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        gap: 1.5rem;
        align-items: center;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s;
    }
    .bs-card::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 120px; height: 120px;
        background: rgba(255,107,0,0.1);
        border-radius: 50%;
    }
    .bs-card:hover { transform: translateY(-5px); }
    .bs-emoji { font-size: 4rem; }
    .bs-card h3 { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #fff; font-weight: 700; margin-bottom: 0.5rem; }
    .bs-card p { color: #aaa; font-size: 0.85rem; }
    .bs-card .tag { color: var(--turmeric); font-weight: 700; font-size: 0.8rem; display: block; margin-bottom: 0.3rem; }

    /* CTA SECTION */
    .cta-section {
        background: linear-gradient(135deg, var(--deep-red), #8B0000);
        color: #fff;
        text-align: center;
    }
    .cta-section h2 { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3.5rem); font-weight: 900; margin-bottom: 1rem; }
    .cta-section p { font-size: 1.1rem; opacity: 0.9; margin-bottom: 2rem; }

    /* SERVICES */
    .services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; }
    .service-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s;
        border-bottom: 4px solid transparent;
    }
    .service-card:hover { border-bottom-color: var(--saffron); transform: translateY(-5px); }
    .service-icon { font-size: 3rem; margin-bottom: 1rem; }
    .service-card h3 { font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.7rem; }
    .service-card p { font-size: 0.88rem; color: #777; line-height: 1.7; margin-bottom: 1.2rem; }
    .btn-service {
        display: inline-block;
        color: var(--saffron);
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: gap 0.3s;
    }
    .btn-service:hover { text-decoration: underline; }

    @media (max-width: 768px) {
        .hero-content, .about-grid, .bestsellers-grid, .services-grid { grid-template-columns: 1fr; }
        .hero-image-area { display: none; }
        .about-features { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div>
            <div class="hero-tag">🌶️ 100% Vegetarian • Preservative Free</div>
            <h1>Dil Bole <span>Wow!!</span></h1>
            <div class="hero-sub">With Every Bite of Misal Pav</div>
            <p>From the streets of Maharashtra to your plate — authentic, bold, and crafted with love. Experience the real taste of Mumbai's iconic street food.</p>
            <div class="hero-btns">
                <a href="{{ url('/menu') }}" class="btn-hero-primary">🍽️ Explore Menu</a>
                <a href="{{ url('/order') }}" class="btn-hero-outline">Order Online →</a>
            </div>
            <div class="stats-row">
                <div class="stat-item"><div class="num">50+</div><div class="lbl">Menu Items</div></div>
                <div class="stat-item"><div class="num">10K+</div><div class="lbl">Happy Customers</div></div>
                <div class="stat-item"><div class="num">100%</div><div class="lbl">Vegetarian</div></div>
            </div>
        </div>
        <div class="hero-image-area">
            @php
                $showcaseItems    = \App\Models\BestSellerShowcase::active()->get();
                $carouselInterval = (int) \App\Models\SiteSetting::get('carousel_interval', 4);
            @endphp

            @if($showcaseItems->count())
                {{-- Auto-scrolling hero card --}}
                <div class="hero-food-card">
                    <div class="hero-badge top-right">⭐ <span id="hero-rating-text">{{ number_format($showcaseItems->first()->rating, 1) }}</span> Rating</div>
                    <div class="hero-badge bottom-left">🔥 Best Seller</div>

                    @foreach($showcaseItems as $i => $showcase)
                    <div class="hero-showcase-slide" id="hss-{{ $i }}" style="display:{{ $i === 0 ? 'block' : 'none' }};" data-rating="{{ number_format($showcase->rating, 1) }}">
                        @if($showcase->image)
                            <img src="{{ asset('storage/' . $showcase->image) }}"
                                 alt="{{ $showcase->name }}"
                                 class="hero-food-emoji"
                                 style="width:200px; height:200px; margin:0 auto; object-fit:contain; filter:drop-shadow(0 10px 15px rgba(0,0,0,0.5));">
                        @else
                            <span class="hero-food-emoji">🍛</span>
                        @endif
                        <p style="color:#fff; font-family:'Playfair Display',serif; font-size:1.3rem; margin-top:1rem;">{{ $showcase->name }}</p>
                        <p style="color:#aaa; font-size:0.85rem;">{{ $showcase->tag ?? 'Fan Favourite' }}</p>
                    </div>
                    @endforeach
                </div>
            @else
                {{-- Fallback static card --}}
                <div class="hero-food-card">
                    <div class="hero-badge top-right">⭐ 4.9 Rating</div>
                    <div class="hero-badge bottom-left">🔥 Best Seller</div>
                    @php $heroDishUrl = \App\Models\SiteImage::getImage('hero_dish'); @endphp
                    @if($heroDishUrl)
                        <img src="{{ $heroDishUrl }}" alt="Mumbaiya Misal Pav" class="hero-food-emoji" style="width:160px; height:160px; margin:0 auto; object-fit:contain; filter:drop-shadow(0 10px 15px rgba(0,0,0,0.5));">
                    @else
                        <span class="hero-food-emoji">🍛</span>
                    @endif
                    <p style="color:#fff; font-family:'Playfair Display',serif; font-size:1.3rem; margin-top:1rem;">Mumbaiya Misal Pav</p>
                    <p style="color:#aaa; font-size:0.85rem;">The Signature Dish</p>
                </div>
            @endif
        </div>
    </div>
</section>

@push('styles')
<style>
    .hero-showcase-slide { animation: fadeInSlide 0.5s ease; }
    @keyframes fadeInSlide {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    var slides   = document.querySelectorAll('.hero-showcase-slide');
    var total    = slides.length;
    var current  = 0;
    var ratingEl = document.getElementById('hero-rating-text');
    var interval = {{ isset($carouselInterval) ? $carouselInterval * 1000 : 4000 }};
    if (total < 2) { return; }
    setInterval(function () {
        slides[current].style.display = 'none';
        current = (current + 1) % total;
        slides[current].style.display = 'block';
        if (ratingEl) {
            ratingEl.innerText = slides[current].getAttribute('data-rating');
        }
    }, interval);
})();
</script>
@endpush

<!-- MARQUEE -->
<div class="marquee-strip">
    <span class="marquee-inner">
        🌶️ MUMBAIYA MISAL PAV &nbsp;|&nbsp; 🥙 VADAPAV &nbsp;|&nbsp; 🍲 POHA &nbsp;|&nbsp; 🥛 THANDI LASSI &nbsp;|&nbsp; 🍱 MISAL THALI &nbsp;|&nbsp; 🌮 BHAJI PAV &nbsp;|&nbsp; 🍚 TAVA PULAV &nbsp;|&nbsp; 🍮 SABUDANA KHEER &nbsp;|&nbsp;
        🌶️ MUMBAIYA MISAL PAV &nbsp;|&nbsp; 🥙 VADAPAV &nbsp;|&nbsp; 🍲 POHA &nbsp;|&nbsp; 🥛 THANDI LASSI &nbsp;|&nbsp; 🍱 MISAL THALI &nbsp;|&nbsp; 🌮 BHAJI PAV &nbsp;|&nbsp; 🍚 TAVA PULAV &nbsp;|&nbsp; 🍮 SABUDANA KHEER &nbsp;|&nbsp;
    </span>
</div>

<!-- MENU PREVIEW -->
<section class="menu-section">
    <div class="section-inner">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:1rem;">
            <div>
                <div class="section-tag">Our Menu</div>
                <div class="section-title">Popular <span>Dishes</span></div>
                <p class="section-desc">Every dish is a story of tradition, love, and authentic Maharashtrian flavors.</p>
            </div>
            <a href="{{ url('/menu') }}" style="color:var(--saffron); font-weight:700; text-decoration:none;">View Full Menu →</a>
        </div>
        <div class="menu-grid">
            @php
            $icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁'];
            @endphp
            @foreach($featured_items as $item)
            <div class="menu-card">
                <div class="menu-card-img">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        {{ $icons[$item->category] ?? '🍽️' }}
                    @endif
                    <span class="veg-badge">🟢 VEG</span>
                </div>
                <div class="menu-card-body">
                    <h3>{{ $item->name }} @if($item->spice_level > 0) 🌶️ @endif</h3>
                    <p>{{ Str::limit($item->description, 60) }}</p>
                    <div class="menu-card-footer">
                        <span class="price">₹{{ number_format($item->price, 2) }}</span>
                        <a href="{{ url('/order') }}?item={{ $item->id }}" class="btn-add-cart">Add to Cart</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="about-section">
    <div class="section-inner">
        <div class="about-grid">
            <div class="about-img-box">
                @php $aboutImgUrl = \App\Models\SiteImage::getImage('about_section'); @endphp
                @if($aboutImgUrl)
                    <img src="{{ $aboutImgUrl }}" alt="From the Streets of Maharashtra" style="max-height:220px; max-width:100%; object-fit:contain; filter:drop-shadow(0 8px 16px rgba(0,0,0,0.5)); display:block; margin:0 auto 1rem;">
                @else
                    <span class="big-emoji">🏙️</span>
                @endif
                <p style="color:#fff; font-family:'Playfair Display',serif; font-size:1.5rem; margin-top:1rem;">From the Streets of<br><span style="color:var(--saffron);">Maharashtra</span><br>to the World</p>
            </div>
            <div>
                <div class="section-tag">About MMV</div>
                <div class="section-title">More Than Just <span>Food</span></div>
                <p class="section-desc" style="margin-bottom:1.5rem;">Rooted in the bold and comforting flavors of authentic Maharashtrian Street food, our menu is 100% vegetarian, preservative-free, and crafted fresh with care. Every plate reflects our belief that great food does more than satisfy hunger — it sparks nostalgia, builds connections, and tells a story.</p>
                <p class="section-desc">Our journey began with a simple dream: to bring the real taste of Mumbai's streets to the world. Today, MMV is growing into a global movement.</p>
                <div class="about-features">
                    <div class="feature-item">
                        <span class="feature-icon">🌿</span>
                        <div><h4>100% Vegetarian</h4><p>Pure veg, always</p></div>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🚫</span>
                        <div><h4>Preservative Free</h4><p>Fresh every day</p></div>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">👩‍🍳</span>
                        <div><h4>Expert Chefs</h4><p>Authentic recipes</p></div>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🌍</span>
                        <div><h4>Global Expansion</h4><p>Growing worldwide</p></div>
                    </div>
                </div>
                <a href="{{ url('/about') }}" style="display:inline-block; margin-top:1.5rem; color:var(--saffron); font-weight:700; text-decoration:none;">More About Us →</a>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section style="background:#fff;">
    <div class="section-inner">
        <div style="text-align:center;">
            <div class="section-tag">What We Offer</div>
            <div class="section-title">Beyond the <span>Restaurant</span></div>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🎉</div>
                <h3>Catering Services</h3>
                <p>Bring authentic Maharashtrian flavors to your celebration. Corporate events, parties, festivals — we've got you covered.</p>
                <a href="{{ url('/catering') }}" class="btn-service">Book Catering →</a>
            </div>
            <div class="service-card">
                <div class="service-icon">🏪</div>
                <h3>Franchise Opportunity</h3>
                <p>Partner with MMV and bring our proven brand to your community. Benefit from training, support & a trusted name.</p>
                <a href="{{ url('/franchise') }}" class="btn-service">Know More →</a>
            </div>
            <div class="service-card">
                <div class="service-icon">📱</div>
                <h3>Online Ordering</h3>
                <p>Order your favourite MMV dishes online for pickup or delivery. Fresh food delivered to your doorstep.</p>
                <a href="{{ url('/order') }}" class="btn-service">Order Now →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="section-inner">
        <h2>🌶️ Ready for a Wow Experience?</h2>
        <p>Order now and taste the authentic flavors of Maharashtra's most beloved street food</p>
        <a href="{{ url('/order') }}" class="btn-hero-primary" style="color:#fff;">Order Online Now</a>
        &nbsp;&nbsp;
        <a href="{{ url('/contact') }}" class="btn-hero-outline">Get in Touch</a>
    </div>
</section>

@endsection
