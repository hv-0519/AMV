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

    .status-live-card {
        background: linear-gradient(145deg, #fffaf5, #ffffff);
        border: 1px solid #f1dfd0;
        box-shadow: 0 14px 34px rgba(42, 16, 0, 0.07);
    }

    .status-live-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) auto;
        gap: 1rem;
        align-items: center;
    }

    .status-live-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #a97753;
        margin-bottom: 0.6rem;
    }

    .status-live-main {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
        margin-bottom: 0.65rem;
    }

    .status-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.58rem 0.95rem;
        border-radius: 999px;
        font-size: 0.86rem;
        font-weight: 700;
        border: 1px solid transparent;
    }

    .status-live-badge.badge-pending {
        background: #fff4db;
        color: #c87500;
        border-color: #ffe2a4;
    }

    .status-live-badge.badge-processing {
        background: #e8f2ff;
        color: #1559c0;
        border-color: #c9dcff;
    }

    .status-live-badge.badge-ready {
        background: #eaf8ea;
        color: #237b37;
        border-color: #cfead1;
    }

    .status-live-badge.badge-completed {
        background: #e9f8ef;
        color: #16683a;
        border-color: #c6e8d3;
    }

    .status-live-badge.badge-cancelled {
        background: #fdecec;
        color: #bb2f2f;
        border-color: #f7cccc;
    }

    .status-live-copy {
        font-size: 0.9rem;
        color: #7a6250;
        line-height: 1.7;
        margin: 0;
    }

    .status-live-tools {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        align-items: stretch;
        min-width: 210px;
    }

    .status-refresh-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #ff7a1a, #ff5e00);
        color: #fff;
        padding: 0.82rem 1rem;
        font-size: 0.88rem;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
        box-shadow: 0 14px 24px rgba(255, 107, 0, 0.18);
    }

    .status-refresh-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 28px rgba(255, 107, 0, 0.24);
    }

    .status-refresh-btn:disabled {
        opacity: 0.7;
        cursor: wait;
        transform: none;
    }

    .status-live-meta {
        font-size: 0.78rem;
        color: #a48770;
        text-align: center;
    }

    .status-live-meta strong {
        color: #7b583d;
    }

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
    .badge-processing { background: #E3F2FD; color: #1565C0; }
    .badge-ready { background: #E8F5E9; color: #2E7D32; }
    .badge-completed { background: #E8F5E9; color: #1B5E20; }
    .badge-cancelled { background: #FDECEC; color: #C62828; }
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
        .cta-row { flex-direction: column; }
        .btn-cta { justify-content: center; }
        .status-live-grid { grid-template-columns: 1fr; }
        .status-live-tools { min-width: 0; }
    }
</style>
@endpush

@section('content')
@php
    $subtotal = $order->total_amount - $order->tax_amount;
@endphp

<div class="confirmation-wrap">

    {{-- Success Banner --}}
    <div class="success-banner">
        <div class="success-checkmark">✅</div>
        <h1 id="orderStatusHeadline">Order <span>Confirmed!</span></h1>
        <p id="orderStatusMessage">Your food is being prepared with love 🧡 We'll have it ready soon.</p>
        <span class="order-id-pill">Order #{{ $order->id }}</span>
    </div>

    <div class="conf-card status-live-card">
        <div class="conf-card-header">
            <span class="header-icon">📡</span> Live Order Status
        </div>
        <div class="conf-card-body">
            <div class="status-live-grid">
                <div>
                    <div class="status-live-kicker">
                        <span id="statusPulseDot">●</span>
                        Real-time tracking
                    </div>
                    <div class="status-live-main">
                        <span class="status-live-badge badge-{{ $order->status }}" id="orderStatusBadge">
                            <span>Current Status</span>
                            <strong id="orderStatusLabel">{{ ucfirst($order->status) }}</strong>
                        </span>
                    </div>
                    <p class="status-live-copy" id="orderStatusSummary">We are watching for updates from the AMV team so you can track progress without refreshing the page.</p>
                </div>
                <div class="status-live-tools">
                    <button type="button" class="status-refresh-btn" id="refreshOrderStatusBtn">
                        <i class="fas fa-rotate-right"></i>
                        Check Latest Status
                    </button>
                    <div class="status-live-meta">
                        Auto-refresh every <strong>5 seconds</strong><br>
                        Last checked: <strong id="orderStatusCheckedAt">just now</strong>
                    </div>
                </div>
            </div>
        </div>
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
                        <span class="badge badge-{{ $order->status }}" id="orderStatusMetaBadge">{{ ucfirst($order->status) }}</span>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusUrl = @json(route('order.status', $order));
    const statusBadge = document.getElementById('orderStatusBadge');
    const statusMetaBadge = document.getElementById('orderStatusMetaBadge');
    const statusLabel = document.getElementById('orderStatusLabel');
    const statusHeadline = document.getElementById('orderStatusHeadline');
    const statusMessage = document.getElementById('orderStatusMessage');
    const statusSummary = document.getElementById('orderStatusSummary');
    const refreshButton = document.getElementById('refreshOrderStatusBtn');
    const checkedAt = document.getElementById('orderStatusCheckedAt');
    const knownStatusClasses = ['badge-pending', 'badge-processing', 'badge-ready', 'badge-completed', 'badge-cancelled'];

    const statusContentMap = {
        pending: {
            title: 'Order <span>Confirmed!</span>',
            message: 'Your order is waiting in our queue. We will start preparing it shortly.',
            summary: 'Your order is placed successfully and is waiting for the AMV team to begin preparation.',
        },
        processing: {
            title: 'Order <span>Processing</span>',
            message: 'Our kitchen is preparing your order right now.',
            summary: 'Your food is currently being prepared in the AMV kitchen.',
        },
        ready: {
            title: 'Order Is <span>Ready!</span>',
            message: 'Great news! Your order is ready for pickup or serving.',
            summary: 'Your order is ready. Please head to the counter or wait for final handoff.',
        },
        completed: {
            title: 'Order <span>Completed</span>',
            message: 'Your order has been completed. Thank you for ordering from AMV.',
            summary: 'This order has been completed successfully. Thank you for choosing AMV.',
        },
        cancelled: {
            title: 'Order <span>Cancelled</span>',
            message: 'This order has been cancelled. Please contact AMV if you need any help.',
            summary: 'This order is marked as cancelled. Contact AMV if you need support.',
        },
    };

    function markChecked() {
        if (!checkedAt) {
            return;
        }

        checkedAt.textContent = new Date().toLocaleTimeString([], {
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit',
        }).toLowerCase();
    }

    function applyStatus(status) {
        if (!statusBadge || !statusMetaBadge || !statusLabel || !statusHeadline || !statusMessage || !statusSummary || !statusContentMap[status]) {
            return;
        }

        statusBadge.classList.remove(...knownStatusClasses);
        statusMetaBadge.classList.remove(...knownStatusClasses);
        statusBadge.classList.add('badge-' + status);
        statusMetaBadge.classList.add('badge-' + status);
        statusLabel.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        statusMetaBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        statusHeadline.innerHTML = statusContentMap[status].title;
        statusMessage.textContent = statusContentMap[status].message;
        statusSummary.textContent = statusContentMap[status].summary;
    }

    async function refreshOrderStatus(triggeredByButton = false) {
        try {
            if (refreshButton && triggeredByButton) {
                refreshButton.disabled = true;
                refreshButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking...';
            }

            const response = await fetch(statusUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                cache: 'no-store',
            });

            if (!response.ok) {
                return;
            }

            const payload = await response.json();
            applyStatus(payload.data?.status);
            markChecked();
        } catch (error) {
            console.error('Order status refresh failed', error);
        } finally {
            if (refreshButton) {
                refreshButton.disabled = false;
                refreshButton.innerHTML = '<i class="fas fa-rotate-right"></i> Check Latest Status';
            }
        }
    }

    refreshButton?.addEventListener('click', function () {
        refreshOrderStatus(true);
    });

    refreshOrderStatus();
    window.setInterval(refreshOrderStatus, 5000);
});
</script>
@endpush
