@extends('layouts.app')
@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-wrap {
        max-width: 960px;
        margin: 0 auto;
        padding: 2.5rem 1.25rem 5rem; /* bottom padding for cart bar */
    }
    .checkout-hero {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .checkout-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 50% 0%, rgba(255,107,0,0.2), transparent 65%);
        pointer-events: none;
    }
    .checkout-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.6rem, 4vw, 2.2rem);
        font-weight: 900;
        color: #fff;
        position: relative;
        z-index: 1;
        margin: 0;
    }
    .checkout-hero h1 span { color: var(--saffron); }
    .checkout-hero p {
        color: rgba(255,255,255,0.6);
        font-size: 0.88rem;
        margin-top: 0.4rem;
        position: relative;
        z-index: 1;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
        align-items: start;
    }

    /* ── Card ── */
    .co-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0ebe3;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .co-card-header {
        padding: 1rem 1.4rem;
        border-bottom: 1px solid #f5f0ea;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--dark);
        background: #fffaf5;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .co-card-body { padding: 1.25rem 1.4rem; }

    /* ── Order type selector ── */
    .order-type-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }
    .order-type-option { display: none; }
    .order-type-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
        padding: 0.85rem 0.5rem;
        border: 2px solid #eee;
        border-radius: 14px;
        cursor: pointer;
        font-size: 0.82rem;
        font-weight: 600;
        color: #7a6250;
        transition: all 0.2s;
        text-align: center;
    }
    .order-type-label .type-icon { font-size: 1.5rem; }
    .order-type-option:checked + .order-type-label {
        border-color: var(--saffron);
        background: #FFF3E0;
        color: var(--saffron);
    }

    /* ── Payment selector ── */
    .payment-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    .payment-option { display: none; }
    .payment-label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1rem;
        border: 2px solid #eee;
        border-radius: 12px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        color: #7a6250;
        transition: all 0.2s;
    }
    .payment-label .pay-icon { font-size: 1.2rem; }
    .payment-option:checked + .payment-label {
        border-color: var(--saffron);
        background: #FFF3E0;
        color: var(--saffron);
    }

    /* ── Form fields ── */
    .field-group { margin-bottom: 1rem; }
    .field-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #b08060;
        margin-bottom: 0.4rem;
    }
    .field-input {
        width: 100%;
        padding: 0.72rem 1rem;
        border: 2px solid #eee;
        border-radius: 12px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        color: #4e3b2d;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .field-input:focus {
        outline: none;
        border-color: var(--saffron);
        box-shadow: 0 0 0 4px rgba(255,107,0,0.1);
    }

    /* ── Order summary (right col) ── */
    .summary-item-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0;
        border-bottom: 1px dashed #f0ebe3;
    }
    .summary-item-row:last-of-type { border-bottom: none; }
    .summary-item-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
        overflow: hidden;
    }
    .summary-item-img img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
    .summary-item-info { flex: 1; min-width: 0; }
    .summary-item-name {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .summary-item-qty { font-size: 0.75rem; color: #aaa; }
    .summary-item-price {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--saffron);
        flex-shrink: 0;
    }
    .summary-totals { margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #f0ebe3; }
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 0.4rem;
    }
    .summary-row.grand {
        font-size: 1rem;
        font-weight: 800;
        color: var(--dark);
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid #eee;
    }
    .summary-row.grand span:last-child { color: var(--saffron); }

    /* ── Place order btn ── */
    .btn-place-order {
        width: 100%;
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.9rem;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        margin-top: 1.25rem;
        transition: background 0.2s, transform 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-place-order:hover { background: var(--deep-red); transform: translateY(-1px); }
    .btn-place-order:disabled { background: #ccc; cursor: not-allowed; transform: none; }

    @media (max-width: 768px) {
        .checkout-grid { grid-template-columns: 1fr; }
        .checkout-wrap { padding: 1.5rem 1rem 5rem; }
        .order-type-grid { grid-template-columns: repeat(3, 1fr); }
        .payment-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
@php
    $icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁'];
@endphp

<div class="checkout-wrap">
    <div class="checkout-hero">
        <h1>Almost <span>There!</span> 🛍️</h1>
        <p>Review your order and confirm details below</p>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm"
          data-public-submit
          data-loading-title="Placing your order..."
          data-loading-text="Please wait while we prepare your confirmation.">
        @csrf
        <div class="checkout-grid">

            {{-- LEFT: Checkout form --}}
            <div>
                {{-- Order Type --}}
                <div class="co-card">
                    <div class="co-card-header">🚀 How would you like your order?</div>
                    <div class="co-card-body">
                        <div class="order-type-grid">
                            <div>
                                <input type="radio" name="order_type" id="type-dine" value="dine-in"
                                       class="order-type-option" {{ old('order_type') == 'dine-in' ? 'checked' : '' }}>
                                <label for="type-dine" class="order-type-label">
                                    <span class="type-icon">🍽️</span>Dine In
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="order_type" id="type-pickup" value="pickup"
                                       class="order-type-option" {{ old('order_type', 'pickup') == 'pickup' ? 'checked' : '' }}>
                                <label for="type-pickup" class="order-type-label">
                                    <span class="type-icon">🏃</span>Pickup
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="order_type" id="type-delivery" value="delivery"
                                       class="order-type-option" {{ old('order_type') == 'delivery' ? 'checked' : '' }}>
                                <label for="type-delivery" class="order-type-label">
                                    <span class="type-icon">🛵</span>Delivery
                                </label>
                            </div>
                        </div>

                        {{-- Delivery address (shown only for delivery) --}}
                        <div id="deliveryAddressWrap" style="{{ old('order_type') === 'delivery' ? 'display:block;' : 'display:none;' }}">
                            <div class="field-group">
                                <label class="field-label" for="delivery_address">Delivery Address</label>
                                <textarea id="delivery_address" name="delivery_address"
                                          class="field-input" rows="3"
                                          placeholder="Enter your full delivery address...">{{ old('delivery_address') }}</textarea>
                                @error('delivery_address')
                                    <p style="color:var(--deep-red); font-size:0.78rem; margin-top:0.25rem;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="co-card">
                    <div class="co-card-header">💳 Payment Method</div>
                    <div class="co-card-body">
                        <div class="payment-grid">
                            <div>
                                <input type="radio" name="payment_method" id="pay-cash" value="cash"
                                       class="payment-option" {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}>
                                <label for="pay-cash" class="payment-label">
                                    <span class="pay-icon">💵</span> Cash
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment_method" id="pay-upi" value="upi"
                                       class="payment-option" {{ old('payment_method') == 'upi' ? 'checked' : '' }}>
                                <label for="pay-upi" class="payment-label">
                                    <span class="pay-icon">📱</span> UPI
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment_method" id="pay-card" value="card"
                                       class="payment-option" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                <label for="pay-card" class="payment-label">
                                    <span class="pay-icon">💳</span> Card
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment_method" id="pay-online" value="online"
                                       class="payment-option" {{ old('payment_method') == 'online' ? 'checked' : '' }}>
                                <label for="pay-online" class="payment-label">
                                    <span class="pay-icon">🌐</span> Online
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="co-card">
                    <div class="co-card-header">📝 Special Instructions <span style="font-weight:400; color:#aaa; font-size:0.8rem;">(optional)</span></div>
                    <div class="co-card-body">
                        <textarea name="notes" class="field-input" rows="3"
                                  placeholder="Any special requests? Less spice, extra chutney...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Order summary --}}
            <div>
                <div class="co-card" style="position: sticky; top: 1.5rem;">
                    <div class="co-card-header">🧾 Order Summary</div>
                    <div class="co-card-body">
                        @foreach($cart_items as $item)
                        <div class="summary-item-row">
                            <div class="summary-item-img">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                @else
                                    {{ $icons[$item['category']] ?? '🍽️' }}
                                @endif
                            </div>
                            <div class="summary-item-info">
                                <div class="summary-item-name">{{ $item['name'] }}</div>
                                <div class="summary-item-qty">× {{ $item['quantity'] }}</div>
                            </div>
                            <div class="summary-item-price">₹{{ number_format($item['subtotal'], 2) }}</div>
                        </div>
                        @endforeach

                        <div class="summary-totals">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>GST (5%)</span>
                                <span>₹{{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="summary-row grand">
                                <span>Total</span>
                                <span>₹{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-place-order" id="placeOrderBtn">
                            🎉 Place Order — ₹{{ number_format($total, 2) }}
                        </button>

                        <a href="{{ route('menu') }}"
                           style="display:block; text-align:center; margin-top:0.75rem; font-size:0.8rem; color:#aaa; text-decoration:none;">
                            ← Add more items
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
const deliveryAddressWrap = document.getElementById('deliveryAddressWrap');
const deliveryAddressInput = document.getElementById('delivery_address');

function syncDeliveryAddressState() {
    const selectedOrderType = document.querySelector('input[name="order_type"]:checked')?.value;
    const isDelivery = selectedOrderType === 'delivery';

    deliveryAddressWrap.style.display = isDelivery ? 'block' : 'none';
    deliveryAddressInput.required = isDelivery;
}

document.querySelectorAll('input[name="order_type"]').forEach((radio) => {
    radio.addEventListener('change', syncDeliveryAddressState);
});

syncDeliveryAddressState();

document.getElementById('checkoutForm').addEventListener('submit', function () {
    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Placing Order...';
});
</script>
@endpush
