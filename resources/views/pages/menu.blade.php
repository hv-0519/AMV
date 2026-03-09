@extends('layouts.app')
@section('title', 'Our Menu')

@push('styles')
<style>
    .menu-hero {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        padding: 4rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .menu-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,107,0,0.15), transparent 70%);
    }
    .menu-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        color: #fff;
        position: relative;
        z-index: 1;
    }
    .menu-hero h1 span { color: var(--saffron); }
    .menu-hero p { color: #ccc; font-size: 1.05rem; margin-top: 0.8rem; position: relative; z-index: 1; }

    .menu-page { max-width: 1300px; margin: 0 auto; padding: 3rem 2rem; }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 3rem;
        background: #fff;
        padding: 1.2rem 1.5rem;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.06);
    }
    .filter-btn {
        padding: 0.5rem 1.2rem;
        border-radius: 25px;
        border: 2px solid #eee;
        background: #fff;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
        text-decoration: none;
        color: #555;
    }
    .filter-btn:hover, .filter-btn.active {
        background: var(--saffron);
        border-color: var(--saffron);
        color: #fff;
    }
    .search-box {
        margin-left: auto;
        display: flex;
        gap: 0.5rem;
    }
    .search-box input {
        padding: 0.5rem 1rem;
        border: 2px solid #eee;
        border-radius: 25px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        width: 220px;
        transition: border-color 0.3s;
    }
    .search-box input:focus { outline: none; border-color: var(--saffron); }

    /* Category Section */
    .category-section { margin-bottom: 3.5rem; }
    .category-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 3px solid var(--saffron);
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .category-title span { color: var(--saffron); }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 1.5rem;
    }
    .menu-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 3px 20px rgba(0,0,0,0.07);
        transition: all 0.3s;
        border: 1px solid #f0ebe3;
    }
    .menu-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(255,107,0,0.15); }
    .menu-card-img {
        height: 185px;
        background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        position: relative;
    }
    .unavailable-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .veg-dot {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 20px; height: 20px;
        border: 2px solid #2E7D32;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .veg-dot::after {
        content: '';
        width: 10px; height: 10px;
        background: #2E7D32;
        border-radius: 50%;
    }
    .bestseller-tag {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--saffron);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 5px;
    }
    .menu-card-body { padding: 1.2rem; }
    .menu-card-body h3 { font-size: 1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.3rem; }
    .menu-card-body p { font-size: 0.82rem; color: #888; margin-bottom: 0.8rem; line-height: 1.5; }
    .spice-row { display: flex; gap: 2px; margin-bottom: 0.8rem; }
    .chilli { font-size: 0.75rem; }
    .menu-card-footer { display: flex; justify-content: space-between; align-items: center; }
    .price { font-size: 1.15rem; font-weight: 800; color: var(--saffron); }
    .btn-order {
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.45rem 1.1rem;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }
    .btn-order:hover { background: var(--deep-red); }
    .btn-order:disabled { background: #ccc; cursor: not-allowed; }

    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; align-items: flex-start; }
        .search-box { margin-left: 0; width: 100%; }
        .search-box input { width: 100%; }
    }
</style>
@endpush

@section('content')

<div class="menu-hero">
    <h1>Our <span>Menu</span></h1>
    <p>100% Vegetarian • Preservative Free • Fresh Every Day 🌿</p>
</div>

<div class="menu-page">
    <!-- Filter Bar -->
    <form method="GET" action="{{ url('/menu') }}">
        <div class="filter-bar">
            <a href="{{ url('/menu') }}"
               class="filter-btn {{ !request('category') ? 'active' : '' }}">🍽️ All</a>
            @foreach($categories as $cat)
            <a href="{{ url('/menu') }}?category={{ $cat }}"
               class="filter-btn {{ request('category') == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
            <div class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search dishes...">
                <button type="submit" style="background:var(--saffron); color:#fff; border:none; padding:0.5rem 1.2rem; border-radius:25px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif;">Search</button>
            </div>
        </div>
    </form>

    <!-- Menu Categories -->
    @forelse($menu_items as $category => $items)
    <div class="category-section" id="{{ Str::slug($category) }}">
        <h2 class="category-title">
            @php
            $icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁'];
            @endphp
            {{ $icons[$category] ?? '🍽️' }} <span>{{ $category }}</span>
        </h2>
        <div class="menu-grid">
            @foreach($items as $item)
            <div class="menu-card">
                <div class="menu-card-img">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    @else
                        {{ $icons[$item->category] ?? '🍽️' }}
                    @endif
                    <div class="veg-dot"></div>
                    @if($item->is_bestseller)
                        <span class="bestseller-tag">⭐ Best Seller</span>
                    @endif
                    @if(!$item->is_available)
                        <div class="unavailable-overlay">Currently Unavailable</div>
                    @endif
                </div>
                <div class="menu-card-body">
                    <h3>{{ $item->name }}</h3>
                    <p>{{ $item->description }}</p>
                    @if($item->spice_level > 0)
                    <div class="spice-row">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="chilli" style="opacity: {{ $i <= $item->spice_level ? '1' : '0.25' }}">🌶️</span>
                        @endfor
                    </div>
                    @endif
                    <div class="menu-card-footer">
                        <span class="price">₹{{ number_format($item->price, 2) }}</span>
                        @if($item->is_available)
                            <a href="{{ url('/order') }}?item={{ $item->id }}" class="btn-order">Add to Order</a>
                        @else
                            <button class="btn-order" disabled>Unavailable</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div style="text-align:center; padding:4rem; color:#888;">
        <div style="font-size:4rem; margin-bottom:1rem;">🔍</div>
        <h3 style="font-size:1.3rem; margin-bottom:0.5rem;">No dishes found</h3>
        <p>Try a different search or <a href="{{ url('/menu') }}" style="color:var(--saffron);">view all items</a></p>
    </div>
    @endforelse
</div>

@endsection
