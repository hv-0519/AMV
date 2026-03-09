@extends('layouts.app')
@section('title', 'About Us')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        padding: 5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,107,0,0.12), transparent 70%);
    }
    .about-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        color: #fff;
        position: relative;
        z-index: 1;
    }
    .about-hero h1 span { color: var(--saffron); }
    .about-hero p { color: #ccc; font-size: 1.1rem; margin-top: 1rem; position: relative; z-index: 1; max-width: 600px; margin-left: auto; margin-right: auto; }

    section { padding: 5rem 2rem; }
    .section-inner { max-width: 1200px; margin: 0 auto; }
    .section-tag { color: var(--saffron); font-weight: 700; font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: var(--dark); line-height: 1.2; margin-bottom: 1rem; }
    .section-title span { color: var(--saffron); }

    /* Story Section */
    .story-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
    .story-img {
        background: linear-gradient(135deg, var(--dark), #3D1A00);
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        position: relative;
    }
    .story-img .big-text {
        font-family: 'Playfair Display', serif;
        font-size: 5rem;
        font-weight: 900;
        color: var(--saffron);
        line-height: 1;
    }
    .story-img p { color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-top: 1rem; }
    .story-text p { color: #555; font-size: 1rem; line-height: 1.8; margin-bottom: 1.2rem; }

    /* Values */
    .values-section { background: #fff8ef; }
    .values-grid { display: inline-grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-top: 3rem; }
    .value-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 3px 15px rgba(0,0,0,0.06);
        transition: transform 0.3s;
    }
    .value-card:hover { transform: translateY(-5px); }
    .value-icon { font-size: 3rem; margin-bottom: 1rem; }
    .value-card h3 { font-size: 1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
    .value-card p { font-size: 0.85rem; color: #888; line-height: 1.6; }

    /* Milestones */
    .timeline { position: relative; margin-top: 3rem; }
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, var(--saffron), var(--deep-red));
        transform: translateX(-50%);
    }
    .timeline-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 3rem;
        position: relative;
    }
    .timeline-item:nth-child(even) { flex-direction: row-reverse; }
    .timeline-content {
        width: 45%;
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 3px 15px rgba(0,0,0,0.06);
        text-align: center;
    }
    .timeline-dot {
        width: 20px; height: 20px;
        background: var(--saffron);
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 0 0 3px var(--saffron);
        position: absolute;
        left: 50%;
        top: 1.5rem;
        transform: translateX(-50%);
        z-index: 1;
    }
    .timeline-year { color: var(--saffron); font-weight: 800; font-size: 1.1rem; margin-bottom: 0.3rem; }
    .timeline-content h3 { font-size: 1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.4rem; }
    .timeline-content p { font-size: 0.85rem; color: #888; }

    /* Team CTA */
    .team-cta { background: var(--dark); text-align: center; }
    .team-cta h2 { font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 900; color: #fff; margin-bottom: 1rem; }
    .team-cta h2 span { color: var(--saffron); }
    .team-cta p { color: #aaa; font-size: 1rem; margin-bottom: 2rem; }
    .btn-cta {
        display: inline-block;
        background: var(--saffron);
        color: #fff;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        margin: 0.3rem;
    }
    .btn-cta:hover { background: var(--deep-red); transform: translateY(-3px); }
    .btn-cta-outline {
        display: inline-block;
        color: #fff;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        border: 2px solid rgba(255,255,255,0.4);
        transition: all 0.3s;
        margin: 0.3rem;
    }
    .btn-cta-outline:hover { border-color: var(--saffron); color: var(--saffron); }

    @media (max-width: 768px) {
        .story-grid { grid-template-columns: 1fr; }
        .timeline::before { left: 20px; }
        .timeline-item, .timeline-item:nth-child(even) { 
            flex-direction: column; 
            align-items: flex-end; 
        }
        .timeline-content { 
            width: calc(100% - 50px);
            margin-bottom: 2rem;
        }
        .timeline-dot { left: 20px; transform: translateX(-50%); top: 1.5rem; }
        .timeline-item .timeline-content { text-align: left; }
    }
</style>
@endpush

@section('content')

<div class="about-hero">
    <h1>Our <span>Story</span></h1>
    <p>From a single stall on Mumbai's streets to a growing global food movement — this is MMV.</p>
</div>

<!-- Story Section -->
<section style="background:#fff;">
    <div class="section-inner">
        <div class="story-grid">
            <div class="story-img">
                <div class="big-text">MMV</div>
                <p>Mumbaiya Misal Vadapav<br>🌶️ Est. with love & spice</p>
            </div>
            <div class="story-text">
                <span class="section-tag">Our Story</span>
                <h2 class="section-title">More Than Just <span>Food</span></h2>
                <p>Rooted in the bold and comforting flavors of <strong>authentic Maharashtrian Street food</strong>, our menu is 100% vegetarian, preservative-free, and crafted fresh with care.</p>
                <p>Every plate reflects our belief that great food does more than satisfy hunger — it sparks nostalgia, builds connections, and tells a story.</p>
                <p>Our journey began with a simple dream: <strong>to bring the real taste of Mumbai's streets to the world</strong>. Today, MMV is growing into a global movement — expanding with every new outlet, fueled by the love of people who connect with our flavors.</p>
                <p>We're committed to offering more than just a meal — we deliver a <strong>vibrant, hygienic, and soul-satisfying experience</strong> that honors the legacy of Indian street food.</p>
                <p style="font-style:italic; color:var(--saffron); font-weight:600;">Welcome to MMV — where flavor meets purpose, and every bite feels like home. 🙏</p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="values-section">
    <div class="section-inner" style="text-align:center;">
        <span class="section-tag">What We Stand For</span>
        <h2 class="section-title">Our <span>Core Values</span></h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🌿</div>
                <h3>100% Vegetarian</h3>
                <p>Every single item on our menu is pure vegetarian — always has been, always will be.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🚫</div>
                <h3>No Preservatives</h3>
                <p>We cook fresh daily. No artificial preservatives or additives — just pure, natural ingredients.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🧑‍🍳</div>
                <h3>Authentic Recipes</h3>
                <p>Every recipe is rooted in traditional Maharashtrian cooking techniques passed down through generations.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🧼</div>
                <h3>Hygienic Kitchen</h3>
                <p>Our kitchens follow strict hygiene standards. Clean food, clean environment, clean conscience.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🌍</div>
                <h3>Global Vision</h3>
                <p>We're building a global movement to take the flavors of Maharashtra to every corner of the world.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">❤️</div>
                <h3>Made with Love</h3>
                <p>Every plate is prepared with passion and care, because food made with love always tastes better.</p>
            </div>
        </div>
    </div>
</section>

<!-- Timeline -->
<section style="background:#fff;">
    <div class="section-inner" style="text-align:center;">
        <span class="section-tag">Our Journey</span>
        <h2 class="section-title">MMV <span>Milestones</span></h2>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">The Beginning</div>
                    <h3>The Dream Takes Shape</h3>
                    <p>MMV was founded with a mission to bring authentic Maharashtrian street food to a wider audience.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">Growing Fast</div>
                    <h3>First Multiple Outlets</h3>
                    <p>Rapid expansion across cities, bringing the MMV experience to thousands of new customers.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">Going Global</div>
                    <h3>International Expansion</h3>
                    <p>MMV crosses borders — taking the flavors of Maharashtra to Canada and beyond.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">Today & Beyond</div>
                    <h3>A Global Movement</h3>
                    <p>MMV continues to grow — franchise partners, catering services, and a community that says "Dil Bole Wow!!"</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="team-cta">
    <div class="section-inner">
        <h2>Be Part of the <span>MMV Family</span></h2>
        <p>Whether you want to franchise, join our team, or just enjoy a great meal — we'd love to have you!</p>
        <a href="{{ url('/franchise') }}" class="btn-cta">🏪 Franchise with Us</a>
        <a href="{{ url('/careers') }}" class="btn-cta-outline">💼 Join Our Team</a>
    </div>
</section>

@endsection
