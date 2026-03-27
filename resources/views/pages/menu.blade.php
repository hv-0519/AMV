@extends('layouts.app')
@section('title', 'Our Menu')

@push('styles')
<style>
    /* ===== MENU HERO ===== */
    .menu-hero {
        background: linear-gradient(135deg, #1A0A00 0%, #3D1A00 100%);
        padding: 4.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .menu-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 50% 60%, rgba(255, 107, 0, 0.18), transparent 65%);
        pointer-events: none;
    }

    .menu-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-weight: 900;
        color: #fff;
        position: relative;
        z-index: 1;
        margin: 0 0 0.6rem;
        line-height: 1.15;
    }

    .menu-hero h1 span {
        color: var(--saffron);
    }

    .menu-hero p {
        color: rgba(255, 255, 255, 0.75);
        font-size: 1rem;
        position: relative;
        z-index: 1;
        margin: 0;
        letter-spacing: 0.02em;
    }

    /* ===== PAGE WRAPPER ===== */
    .menu-page {
        max-width: 1300px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        display: grid;
        grid-template-columns: 230px 1fr;
        gap: 1.1rem;
        align-items: end;
        margin-bottom: 3rem;
        background: #fff;
        padding: 1.3rem 1.6rem;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0ebe3;
    }

    .filter-group {
        min-width: 0;
    }

    .filter-label {
        display: block;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 1.6px;
        text-transform: uppercase;
        color: #b08060;
        margin-bottom: 0.5rem;
    }

    /* ── Custom dropdown ── */
    .custom-select-wrapper {
        position: relative;
        width: 100%;
        user-select: none;
        -webkit-user-select: none;
    }

    .custom-select-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border: 2px solid #eee;
        border-radius: 12px;
        background: #fff;
        font-size: 0.9rem;
        font-weight: 600;
        color: #4e3b2d;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s;
        white-space: nowrap;
        overflow: hidden;
    }

    .custom-select-trigger .trigger-text {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .custom-select-trigger .trigger-arrow {
        flex-shrink: 0;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.25s ease;
        color: var(--saffron);
    }

    .custom-select-trigger .trigger-arrow svg {
        display: block;
    }

    .custom-select-wrapper.open .custom-select-trigger {
        border-color: var(--saffron);
        box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.11);
    }

    .custom-select-wrapper.open .trigger-arrow {
        transform: rotate(180deg);
    }

    .custom-select-panel {
        position: fixed;
        z-index: 9999;
        background: #fff;
        border: 1.5px solid #f0ebe3;
        border-radius: 14px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.13), 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow-y: auto;
        max-height: 260px;
        display: none;
        padding: 0.4rem;
    }

    .custom-select-wrapper.open .custom-select-panel {
        display: block;
    }

    .custom-select-option {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.62rem 0.9rem;
        border-radius: 9px;
        font-size: 0.88rem;
        font-weight: 500;
        color: #4e3b2d;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: background 0.15s;
    }

    .custom-select-option:hover {
        background: #FFF3E0;
    }

    .custom-select-option.selected {
        background: linear-gradient(135deg, #FF8C00, var(--saffron));
        color: #fff;
        font-weight: 700;
    }

    .custom-select-option .opt-emoji {
        font-size: 1rem;
        flex-shrink: 0;
    }

    .filter-select-hidden {
        position: absolute;
        opacity: 0;
        pointer-events: none;
        width: 0;
        height: 0;
    }

    /* search-box: input + button always side by side */
    .search-box {
        display: flex;
        flex-direction: row;
        gap: 0.6rem;
        align-items: flex-end;
        min-width: 0;
    }

    .search-field {
        flex: 1 1 auto;
        min-width: 0;
    }

    .search-box input[type="text"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #eee;
        border-radius: 12px;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        color: #4e3b2d;
        background: #fff;
        transition: border-color 0.25s, box-shadow 0.25s;
        box-sizing: border-box;
    }

    .search-box input[type="text"]:focus {
        outline: none;
        border-color: var(--saffron);
        box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.12);
    }

    .filter-submit {
        flex-shrink: 0;
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.75rem 1.4rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        white-space: nowrap;
        transition: background 0.25s, transform 0.2s;
        line-height: 1;
    }

    .filter-submit:hover {
        background: var(--deep-red);
        transform: translateY(-1px);
    }

    .filter-submit:focus-visible {
        outline: 3px solid rgba(255, 107, 0, 0.3);
        outline-offset: 3px;
    }

    /* ===== CATEGORY SECTION ===== */
    .category-section {
        margin-bottom: 3.5rem;
    }

    .category-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 4px solid var(--saffron);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        line-height: 1.2;
    }

    .category-title span {
        color: var(--saffron);
    }

    /* ===== MENU GRID ===== */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(265px, 1fr));
        gap: 1.5rem;
    }

    .menu-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        border: 1px solid #f0ebe3;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 36px rgba(255, 107, 0, 0.14);
    }

    /* Card Image */
    .menu-card-img {
        height: 190px;
        background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4.5rem;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .menu-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .unavailable-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 0.88rem;
        letter-spacing: 0.03em;
    }

    .bestseller-tag {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--saffron);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.22rem 0.6rem;
        border-radius: 6px;
        letter-spacing: 0.02em;
        z-index: 1;
    }

    /* Card Body */
    .menu-card-body {
        padding: 1.1rem 1.2rem 1.2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .dish-title {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.3rem;
    }

    .dish-title h3 {
        font-size: 0.97rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        line-height: 1.35;
    }

    .veg-dot {
        width: 16px;
        height: 16px;
        border: 2px solid #2E7D32;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .veg-dot::after {
        content: '';
        width: 8px;
        height: 8px;
        background: #2E7D32;
        border-radius: 50%;
    }

    .menu-card-desc {
        font-size: 0.8rem;
        color: #999;
        line-height: 1.55;
        margin: 0 0 0.75rem;
        flex: 1;
    }

    /* ── Pairing tag ── */
    .pairing-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.72rem;
        font-weight: 600;
        color: #7a6250;
        background: #FFF3E0;
        border: 1px solid rgba(255, 107, 0, 0.18);
        border-radius: 20px;
        padding: 0.22rem 0.65rem;
        margin-bottom: 0.75rem;
        width: fit-content;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pairing-tag .pair-emoji {
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .pairing-tag .pair-label {
        color: #b08060;
        font-weight: 500;
    }

    .spice-row {
        display: flex;
        gap: 2px;
        margin-bottom: 0.75rem;
    }

    .chilli {
        font-size: 0.72rem;
    }

    /* Card Footer */
    .menu-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        gap: 0.5rem;
    }

    .price {
        font-size: 1.12rem;
        font-weight: 800;
        color: var(--saffron);
        white-space: nowrap;
    }

    .btn-order {
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.45rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        white-space: nowrap;
        transition: background 0.25s, transform 0.2s;
        display: inline-block;
    }

    .btn-order:hover {
        background: var(--deep-red);
        transform: translateY(-1px);
    }

    .btn-order:disabled {
        background: #d9d0c8;
        color: #999;
        cursor: not-allowed;
        transform: none;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: #aaa;
    }

    .empty-state .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #777;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.9rem;
    }

    .empty-state a {
        color: var(--saffron);
        text-decoration: none;
        font-weight: 600;
    }

    .empty-state a:hover {
        text-decoration: underline;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .menu-grid {
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .menu-page {
            padding: 2rem 1.25rem;
        }

        .filter-bar {
            grid-template-columns: 1fr;
            gap: 0.85rem;
            padding: 1.1rem;
            border-radius: 14px;
            margin-bottom: 2.2rem;
        }

        .search-box {
            flex-direction: row;
        }

        .filter-submit {
            flex-shrink: 0;
            min-width: 90px;
        }

        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .category-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .menu-hero {
            padding: 3rem 1.25rem;
        }

        .menu-page {
            padding: 1.5rem 1rem;
        }

        .filter-bar {
            padding: 0.9rem;
        }

        .filter-label {
            font-size: 0.7rem;
            letter-spacing: 1.2px;
        }

        .search-box {
            flex-direction: row;
        }

        .filter-submit {
            min-width: 80px;
        }

        .menu-grid {
            grid-template-columns: 1fr;
        }

        .menu-card-img {
            height: 175px;
        }

        .category-title {
            font-size: 1.35rem;
        }
    }
</style>
@endpush

@section('content')

@php
$icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁'];
$selectedCat = request('category');
$triggerLabel = $selectedCat
? (($icons[$selectedCat] ?? '🍽️') . ' ' . $selectedCat)
: '🍽️ All Dishes';
$pairMap = $pairMap ?? [];
@endphp

<div class="menu-hero">
    <h1>Our <span>Menu</span></h1>
    <p>100% Vegetarian &bull; Preservative Free &bull; Fresh Every Day 🌿</p>
</div>

<div class="menu-page">

    {{-- Filter Bar --}}
    <form method="GET" action="{{ url('/menu') }}" id="menuFilterForm">
        <select name="category" id="categoryFilter" class="filter-select-hidden" aria-hidden="true" tabindex="-1">
            <option value="">All Dishes</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ $selectedCat == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <div class="filter-bar">
            <div class="filter-group">
                <span class="filter-label">Choose Category</span>
                <div class="custom-select-wrapper" id="customCatSelect" role="combobox"
                    aria-haspopup="listbox" aria-expanded="false" aria-controls="customCatPanel" tabindex="0">
                    <div class="custom-select-trigger" id="customCatTrigger">
                        <span class="trigger-text" id="customCatTriggerText">{{ $triggerLabel }}</span>
                        <span class="trigger-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    <div class="custom-select-panel" role="listbox" id="customCatPanel">
                        <div class="custom-select-option {{ !$selectedCat ? 'selected' : '' }}"
                            data-value="" data-label="🍽️ All Dishes" role="option">
                            <span class="opt-emoji">🍽️</span>All Dishes
                        </div>
                        @foreach($categories as $cat)
                        <div class="custom-select-option {{ $selectedCat == $cat ? 'selected' : '' }}"
                            data-value="{{ $cat }}" data-label="{{ ($icons[$cat] ?? '🍽️') . ' ' . $cat }}" role="option">
                            <span class="opt-emoji">{{ $icons[$cat] ?? '🍽️' }}</span>{{ $cat }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="search-box">
                <div class="search-field">
                    <label for="menuSearch" class="filter-label">Search Dishes</label>
                    <input
                        id="menuSearch"
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="🔍 Search dishes..."
                        autocomplete="off">
                </div>
                <button type="submit" class="filter-submit">Search</button>
            </div>
        </div>
    </form>

    {{-- Menu Categories --}}
    @forelse($menu_items as $category => $items)
    <div class="category-section" id="{{ Str::slug($category) }}">
        <h2 class="category-title">
            {{ $icons[$category] ?? '🍽️' }}
            <span>{{ $category }}</span>
        </h2>

        <div class="menu-grid">
            @foreach($items as $item)
            <div class="menu-card">
                <div class="menu-card-img">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    @else
                    {{ $icons[$item->category] ?? '🍽️' }}
                    @endif
                    @if($item->is_bestseller)
                    <span class="bestseller-tag">⭐ Best Seller</span>
                    @endif
                    @if(!$item->is_available)
                    <div class="unavailable-overlay">Currently Unavailable</div>
                    @endif
                </div>

                <div class="menu-card-body">
                    <div class="dish-title">
                        <span class="veg-dot" title="Vegetarian"></span>
                        <h3>{{ $item->name }}</h3>
                    </div>

                    <p class="menu-card-desc">{{ $item->description }}</p>

                    @if(!empty($pairMap[$item->id]))
                    <span class="pairing-tag" title="Pairs well with {{ $pairMap[$item->id]->name }}">
                        <span class="pair-emoji">{{ $icons[$pairMap[$item->id]->category] ?? '🍽️' }}</span>
                        <span class="pair-label">Pairs with</span>
                        {{ Str::limit($pairMap[$item->id]->name, 22) }}
                    </span>
                    @endif

                    @if($item->spice_level > 0)
                    <div class="spice-row" aria-label="Spice level {{ $item->spice_level }} of 5">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="chilli" style="opacity: {{ $i <= $item->spice_level ? '1' : '0.2' }}">🌶️</span>
                            @endfor
                    </div>
                    @endif

                    <div class="menu-card-footer">
                        <span class="price">₹{{ number_format($item->price, 2) }}</span>
                        @if($item->is_available)
                        @auth
                        <button
                            type="button"
                            class="btn-order"
                            onclick="addToCart({{ $item->id }}, this)">
                            Add to Cart
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="btn-order">Login to Order</a>
                        @endauth
                        @else
                        <button class="btn-order" disabled aria-disabled="true">Unavailable</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">🔍</div>
        <h3>No dishes found</h3>
        <p>Try a different search or <a href="{{ url('/menu') }}">view all items</a></p>
    </div>
    @endforelse

</div>

@endsection

@push('scripts')
<script>
    (function() {
        const wrapper = document.getElementById('customCatSelect');
        const panel = document.getElementById('customCatPanel');
        const trigText = document.getElementById('customCatTriggerText');
        const realSelect = document.getElementById('categoryFilter');
        const form = document.getElementById('menuFilterForm');

        if (!wrapper || !panel) return;

        function positionPanel() {
            const rect = wrapper.getBoundingClientRect();
            const spaceBelow = window.innerHeight - rect.bottom;
            const spaceAbove = rect.top;
            const panelH = 260;

            panel.style.width = rect.width + 'px';
            panel.style.left = rect.left + 'px';

            if (spaceBelow >= panelH + 8 || spaceBelow >= spaceAbove) {
                panel.style.top = (rect.bottom + 6) + 'px';
                panel.style.bottom = 'auto';
            } else {
                panel.style.top = 'auto';
                panel.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
            }
        }

        function openPanel() {
            positionPanel();
            wrapper.classList.add('open');
            wrapper.setAttribute('aria-expanded', 'true');
        }

        function closePanel() {
            wrapper.classList.remove('open');
            wrapper.setAttribute('aria-expanded', 'false');
        }

        wrapper.addEventListener('click', function(e) {
            e.stopPropagation();
            wrapper.classList.contains('open') ? closePanel() : openPanel();
        });

        wrapper.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                wrapper.classList.contains('open') ? closePanel() : openPanel();
            }
            if (e.key === 'Escape') closePanel();
        });

        panel.addEventListener('click', function(e) {
            const opt = e.target.closest('.custom-select-option');
            if (!opt) return;
            realSelect.value = opt.dataset.value;
            trigText.textContent = opt.dataset.label;
            panel.querySelectorAll('.custom-select-option').forEach(o => o.classList.remove('selected'));
            opt.classList.add('selected');
            closePanel();
            form.submit();
        });

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) closePanel();
        });
        window.addEventListener('scroll', function() {
            if (wrapper.classList.contains('open')) positionPanel();
        }, true);
        window.addEventListener('resize', function() {
            if (wrapper.classList.contains('open')) positionPanel();
        });
    })();
</script>
@endpush