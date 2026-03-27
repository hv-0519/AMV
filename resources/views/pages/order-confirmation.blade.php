@extends('layouts.app')
@section('title', 'Order Confirmed')

@push('styles')
<style>
    /* ── Page ── */
    .confirmation-wrap {
        max-width: 860px;
        margin: 0 auto;
        padding: 2.5rem 1.25rem 3.5rem;
    }

    /* ── Success banner ── */
    .success-banner {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        border-radius: 20px;
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .success-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 50% 0%, rgba(255,107,0,0.22), transparent 65%);
        pointer-events: none;
    }
    .success-checkmark {
        width: 64px;
        height: 64px;
        background: rgba(46,125,50,0.18);
        border: 2px solid rgba(46,125,50,0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.6rem;
        position: relative;
        z-index: 1;
    }
    .success-banner h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 900;
        color: #fff;
        margin-bottom: 0.4rem;
        position: relative;
        z-index: 1;
    }
    .success-banner h1 span { color: var(--saffron); }
    .success-banner p {
        color: rgba(255,255,255,0.65);
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }
    .order-id-pill {
        display: inline-block;
        margin-top: 1rem;
        background: rgba(255,107,0,0.15);
        border: 1px solid rgba(255,107,0,0.3);
        color: var(--saffron);
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        letter-spacing: 0.05em;
        position: relative;
        z-index: 1;
    }

    /* ── Cards ── */
    .conf-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.07);
        border: 1px solid #f0ebe3;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .conf-card-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1rem 1.4rem;
        border-bottom: 1px solid #f5f0ea;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--dark);
        background: #fffaf5;
    }
    .conf-card-header .header-icon {
        font-size: 1.1rem;
    }
    .conf-card-body { padding: 1.25rem 1.4rem; }

    /* ── Order meta row ── */
    .order-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }
    .meta-item { }
    .meta-label {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #b08060;
        margin-bottom: 0.25rem;
    }
    .meta-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--dark);
    }
    .meta-value .badge {
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.2rem 0.7rem;
        border-radius: 20px;
    }
    .badge-pending  { background: #FFF8E1; color: #F57F17; }
    .badge-paid     { background: #E8F5E9; color: #2E7D32; }
    .badge-cash     { background: #E3F2FD; color: #1565C0; }
    .badge-upi      { background: #F3E5F5; color: #6A1B9A; }
    .badge-card     { background: #E8EAF6; color: #283593; }
    .badge-online   { background: #E0F7FA; color: #00695C; }
    .badge-dine-in  { background: #FFF3E0; color: #E65100; }
    .badge-pickup   { background: #E8F5E9; color: #2E7D32; }
    .badge-delivery { background: #E3F2FD; color: #1565C0; }

    /* ── Items table ── */
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table th {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #b08060;
        padding: 0 0 0.6rem;
        border-bottom: 2px solid #f0ebe3;
        text-align: left;
    }
    .items-table th:last-child,
    .items-table td:last-child { text-align: right; }
    .items-table td {
        padding: 0.75rem 0;
        font-size: 0.88rem;
        color: #444;
        border-bottom: 1px dashed #f5f0ea;
        vertical-align: middle;
    }
    .items-table tr:last-child td { border-bottom: none; }
    .item-name-cell { font-weight: 600; color: var(--dark); }
    .item-qty-badge {
        display: inline-block;
        background: #FFF3E0;
        color: var(--saffron);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.15rem 0.55rem;
        border-radius: 12px;
    }

    /* ── Totals ── */
    .totals-block {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #f0ebe3;
    }
    .totals-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        color: #777;
        margin-bottom: 0.4rem;
    }
    .totals-row.grand {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--dark);
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid #eee;
    }
    .totals-row.grand span:last-child { color: var(--saffron); }

    /* ── Recommendation widget ── */
    .rec-section {
        margin-top: 2rem;
    }
    .rec-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
    }
    .rec-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 900;
        color: var(--dark);
    }
    .rec-header h2 span { color: var(--saffron); }
    .rec-header p {
        font-size: 0.82rem;
        color: #aaa;
        margin-top: 0.15rem;
    }

    .rec-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1rem;
    }
    .rec-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0ebe3;
        box-shadow: 0 2px 14px rgba(0,0,0,0.06);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .rec-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(255,107,0,0.13);
    }
    .rec-card-img {
        height: 150px;
        background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    .rec-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .rec-tag {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(26,10,0,0.75);
        color: rgba(255,255,255,0.9);
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.18rem 0.55rem;
        border-radius: 6px;
        letter-spacing: 0.04em;
        backdrop-filter: blur(4px);
    }
    .rec-card-body {
        padding: 0.9rem 1rem 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .rec-card-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--dark);
        margin-bottom: 0.2rem;
    }
    .rec-card-desc {
        font-size: 0.77rem;
        color: #aaa;
        line-height: 1.5;
        flex: 1;
        margin-bottom: 0.75rem;
    }
    .rec-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-top: auto;
    }
    .rec-price {
        font-size: 1rem;
        font-weight: 800;
        color: var(--saffron);
    }
    .btn-rec-order {
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        white-space: nowrap;
        transition: background 0.2s, transform 0.15s;
        display: inline-block;
    }
    .btn-rec-order:hover { background: var(--deep-red); transform: translateY(-1px); }

    /* ── CTA row ── */
    .cta-row {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1.75rem;
    }
    .btn-cta {
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: none;
        transition: background 0.2s, transform 0.15s;
    }
    .btn-cta-primary {
        background: var(--saffron);
        color: #fff;
    }
    .btn-cta-primary:hover { background: var(--deep-red); transform: translateY(-1px); }
    .btn-cta-outline {
        background: transparent;
        border: 2px solid #e8dfd5;
        color: #7a6250;
    }
    .btn-cta-outline:hover { border-color: var(--saffron); color: var(--saffron); }

    /* ── Responsive ── */
    @media (max-width: 600px) {
        .confirmation-wrap { padding: 1.5rem 1rem 2.5rem; }
        .success-banner { padding: 2rem 1.25rem; border-radius: 16px; }
        .order-meta-grid { grid-template-columns: 1fr 1fr; }
        .rec-grid { grid-template-columns: 1fr; }
        .cta-row { flex-direction: column; }
        .btn-cta { justify-content: center; }
    }
</style>
@endpush

@section('content')
@php
    $icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁'];
    $subtotal = $order->total_amount - $order->tax_amount;
@endphp

<div class="confirmation-wrap">

    {{-- Success Banner --}}
    <div class="success-banner">
        <div class="success-checkmark">✅</div>
        <h1>Order <span>Confirmed!</span></h1>
        <p>Your food is being prepared with love 🧡 We'll have it ready soon.</p>
        <span class="order-id-pill">Order #{{ $order->id }}</span>
    </div>

    {{-- Order Meta --}}
    <div class="conf-card">
        <div class="conf-card-header">
            <span class="header-icon">📋</span> Order Details
        </div>
        <div class="conf-card-body">
            <div class="order-meta-grid">
                <div class="meta-item">
                    <div class="meta-label">Customer</div>
                    <div class="meta-value">{{ $order->customer_name }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Order Type</div>
                    <div class="meta-value">
                        <span class="badge badge-{{ $order->order_type }}">{{ ucfirst($order->order_type) }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Payment</div>
                    <div class="meta-value">
                        <span class="badge badge-{{ $order->payment_method }}">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Status</div>
                    <div class="meta-value">
                        <span class="badge badge-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                </div>
                @if($order->delivery_address)
                <div class="meta-item" style="grid-column: 1 / -1;">
                    <div class="meta-label">Delivery Address</div>
                    <div class="meta-value">{{ $order->delivery_address }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="conf-card">
        <div class="conf-card-header">
            <span class="header-icon">🍽️</span> Items Ordered
        </div>
        <div class="conf-card-body">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align:center;">Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderItems as $item)
                    <tr>
                        <td class="item-name-cell">{{ $item->menuItem->name ?? 'Item' }}</td>
                        <td style="text-align:center;">
                            <span class="item-qty-badge">× {{ $item->quantity }}</span>
                        </td>
                        <td>₹{{ number_format((float) $item->unit_price, 2) }}</td>
                        <td>₹{{ number_format((float) $item->subtotal, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="color:#aaa; padding:1rem 0;">No items found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="totals-block">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format((float) $subtotal, 2) }}</span>
                </div>
                <div class="totals-row">
                    <span>GST (5%)</span>
                    <span>₹{{ number_format((float) $order->tax_amount, 2) }}</span>
                </div>
                <div class="totals-row grand">
                    <span>Total Paid</span>
                    <span>₹{{ number_format((float) $order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Recommendation Widget --}}
    @if($recommended->isNotEmpty())
    <div class="rec-section">
        <div class="rec-header">
            <div>
                <h2>People Also <span>Love</span> 🤤</h2>
                <p>Others who ordered this also enjoyed these dishes</p>
            </div>
        </div>

        <div class="rec-grid">
            @foreach($recommended as $item)
            <div class="rec-card">
                <div class="rec-card-img">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    @else
                        {{ $icons[$item->category] ?? '🍽️' }}
                    @endif
                    <span class="rec-tag">{{ $item->category }}</span>
                </div>
                <div class="rec-card-body">
                    <div class="rec-card-name">{{ $item->name }}</div>
                    <p class="rec-card-desc">{{ Str::limit($item->description, 70) }}</p>
                    <div class="rec-card-footer">
                        <span class="rec-price">₹{{ number_format($item->price, 2) }}</span>
                        <a href="{{ url('/order') }}?item={{ $item->id }}" class="btn-rec-order">
                            Order Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- CTA row --}}
    <div class="cta-row">
        <a href="{{ url('/order') }}" class="btn-cta btn-cta-primary">
            🛍️ Order Again
        </a>
        <a href="{{ url('/menu') }}" class="btn-cta btn-cta-outline">
            🍽️ Browse Menu
        </a>
        <a href="{{ url('/') }}" class="btn-cta btn-cta-outline">
            🏠 Back to Home
        </a>
    </div>

</div>
@endsection
