@extends('layouts.app')
@section('title', 'Order Online')

@push('styles')
<style>
    .order-page {
        max-width: 1300px;
        margin: 0 auto;
        padding: 2.5rem 2rem;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        align-items: start;
    }
    .order-hero {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        padding: 2.5rem 2rem;
        text-align: center;
    }
    .order-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 900;
        color: #fff;
    }
    .order-hero h1 span { color: var(--saffron); }
    .order-hero p { color: #ccc; margin-top: 0.5rem; }

    /* Menu Side */
    .menu-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark);
        margin: 1.5rem 0 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0ebe3;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .order-item-card {
        background: #fff;
        border-radius: 14px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.8rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid #f0ebe3;
        transition: border-color 0.3s;
    }
    .order-item-card:hover { border-color: var(--saffron); }
    .item-emoji { font-size: 2.2rem; flex-shrink: 0; }
    .item-info { flex: 1; }
    .item-info h4 { font-size: 0.95rem; font-weight: 700; color: var(--dark); margin-bottom: 0.2rem; }
    .item-info p { font-size: 0.78rem; color: #888; }
    .item-price { font-size: 1rem; font-weight: 800; color: var(--saffron); margin-right: 0.8rem; white-space: nowrap; }
    .qty-control {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .qty-btn {
        width: 30px; height: 30px;
        border-radius: 50%;
        border: 2px solid var(--saffron);
        background: #fff;
        color: var(--saffron);
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        line-height: 1;
    }
    .qty-btn:hover { background: var(--saffron); color: #fff; }
    .qty-display {
        width: 28px;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
    }

    /* Cart Side */
    .cart-box {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.08);
        position: sticky;
        top: 90px;
        overflow: hidden;
    }
    .cart-header {
        background: var(--dark);
        padding: 1.2rem 1.5rem;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cart-header h3 { font-size: 1.1rem; font-weight: 700; }
    .cart-badge {
        background: var(--saffron);
        color: #fff;
        border-radius: 50%;
        width: 26px; height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .cart-items { padding: 1rem 1.5rem; max-height: 280px; overflow-y: auto; }
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f0ebe3;
        font-size: 0.88rem;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item-name { flex: 1; font-weight: 600; color: var(--dark); }
    .cart-item-qty { color: #888; margin: 0 0.8rem; }
    .cart-item-price { font-weight: 700; color: var(--saffron); }
    .cart-empty { text-align: center; padding: 2rem; color: #aaa; font-size: 0.9rem; }
    .cart-summary {
        background: #fff8ef;
        padding: 1rem 1.5rem;
        border-top: 1px solid #f0ebe3;
    }
    .summary-row { display: flex; justify-content: space-between; font-size: 0.88rem; margin-bottom: 0.4rem; color: #666; }
    .summary-row.total { font-weight: 800; font-size: 1.05rem; color: var(--dark); margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid #e0d8cf; }

    .cart-form { padding: 1.2rem 1.5rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: #555; margin-bottom: 0.3rem; }
    .form-control {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid #eee;
        border-radius: 8px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        transition: border-color 0.3s;
    }
    .form-control:focus { outline: none; border-color: var(--saffron); }
    .btn-place-order {
        width: 100%;
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 1rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
        margin-top: 0.5rem;
    }
    .btn-place-order:hover { background: var(--deep-red); }
    .btn-place-order:disabled { background: #ccc; cursor: not-allowed; }

    @media (max-width: 900px) {
        .order-page { grid-template-columns: 1fr; }
        .cart-box { position: static; }
    }
</style>
@endpush

@section('content')

<div class="order-hero">
    <h1>Order <span>Online</span> 🛵</h1>
    <p>Fresh, hot & delivered fast — just the way MMV makes it</p>
</div>

<div class="order-page">
    <!-- LEFT: Menu Items -->
    <div id="menuPanel">
        @php
        $icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁'];
        @endphp
        @foreach($menu_items as $category => $items)
        <h2 class="menu-section-title">{{ $icons[$category] ?? '🍽️' }} {{ $category }}</h2>
        @foreach($items as $item)
        <div class="order-item-card">
            <span class="item-emoji">{{ $icons[$item->category] ?? '🍽️' }}</span>
            <div class="item-info">
                <h4>{{ $item->name }} @if($item->is_bestseller) ⭐ @endif</h4>
                <p>{{ Str::limit($item->description, 60) }}</p>
            </div>
            <span class="item-price">₹{{ number_format($item->price, 2) }}</span>
            <div class="qty-control">
                <button class="qty-btn" onclick="changeQty({{ $item->id }}, -1)">−</button>
                <span class="qty-display" id="qty-{{ $item->id }}">0</span>
                <button class="qty-btn" onclick="changeQty({{ $item->id }}, 1, '{{ addslashes($item->name) }}', {{ $item->price }})">+</button>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>

    <!-- RIGHT: Cart & Checkout -->
    <div class="cart-box">
        <div class="cart-header">
            <h3>🛒 Your Order</h3>
            <span class="cart-badge" id="cartCount">0</span>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="cart-empty" id="cartEmpty">
                <div style="font-size:2.5rem;">🍽️</div>
                <p>Your cart is empty.<br>Add items from the menu!</p>
            </div>
        </div>

        <div class="cart-summary">
            <div class="summary-row"><span>Subtotal</span><span id="subtotalDisplay">₹0.00</span></div>
            <div class="summary-row"><span>Tax (5% GST)</span><span id="taxDisplay">₹0.00</span></div>
            <div class="summary-row total"><span>Total</span><span id="totalDisplay">₹0.00</span></div>
        </div>

        <form class="cart-form" method="POST" action="{{ route('order.store') }}" id="orderForm">
            @csrf
            <div id="cartInputs"></div>

            @guest
            <div class="form-group">
                <label>Your Name *</label>
                <input type="text" name="guest_name" class="form-control" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="guest_email" class="form-control" placeholder="you@email.com" required>
            </div>
            <div class="form-group">
                <label>Phone *</label>
                <input type="text" name="guest_phone" class="form-control" placeholder="+91 98765 43210" required>
            </div>
            @endguest

            <div class="form-group">
                <label>Order Type *</label>
                <select name="order_type" class="form-control" id="orderType" onchange="toggleDelivery()" required>
                    <option value="pickup">🏪 Pickup</option>
                    <option value="dine-in">🪑 Dine-In</option>
                    <option value="delivery">🚚 Delivery</option>
                </select>
            </div>

            <div class="form-group" id="deliveryAddressGroup" style="display:none;">
                <label>Delivery Address *</label>
                <textarea name="delivery_address" class="form-control" rows="2" placeholder="Full delivery address..."></textarea>
            </div>

            <div class="form-group">
                <label>Payment Method *</label>
                <select name="payment_method" class="form-control" required>
                    <option value="cash">💵 Cash on Delivery/Pickup</option>
                    <option value="upi">📱 UPI</option>
                    <option value="card">💳 Card</option>
                    <option value="online">🌐 Online Payment</option>
                </select>
            </div>

            <div class="form-group">
                <label>Special Instructions</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Any special requests..."></textarea>
            </div>

            <button type="submit" class="btn-place-order" id="placeOrderBtn" disabled>
                🎉 Place Order
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let cart = {};

    function changeQty(id, delta, name = '', price = 0) {
        if (!cart[id]) cart[id] = { qty: 0, name, price };
        cart[id].qty = Math.max(0, cart[id].qty + delta);
        if (cart[id].qty === 0) delete cart[id];
        document.getElementById('qty-' + id).textContent = cart[id] ? cart[id].qty : 0;
        updateCart();
    }

    function updateCart() {
        const items = Object.entries(cart);
        const cartItemsEl = document.getElementById('cartItems');
        const cartEmptyEl = document.getElementById('cartEmpty');
        const cartInputsEl = document.getElementById('cartInputs');
        const placeBtn = document.getElementById('placeOrderBtn');

        let subtotal = 0;
        let count = 0;
        let itemsHtml = '';
        let inputsHtml = '';

        items.forEach(([id, item], idx) => {
            const sub = item.qty * item.price;
            subtotal += sub;
            count += item.qty;
            itemsHtml += `
                <div class="cart-item">
                    <span class="cart-item-name">${item.name}</span>
                    <span class="cart-item-qty">x${item.qty}</span>
                    <span class="cart-item-price">₹${sub.toFixed(2)}</span>
                </div>`;
            inputsHtml += `<input type="hidden" name="items[${idx}][id]" value="${id}">`;
            inputsHtml += `<input type="hidden" name="items[${idx}][quantity]" value="${item.qty}">`;
        });

        const tax = subtotal * 0.05;
        const total = subtotal + tax;

        if (items.length === 0) {
            cartItemsEl.innerHTML = `<div class="cart-empty" id="cartEmpty"><div style="font-size:2.5rem;">🍽️</div><p>Your cart is empty.<br>Add items from the menu!</p></div>`;
        } else {
            cartItemsEl.innerHTML = itemsHtml;
        }

        cartInputsEl.innerHTML = inputsHtml;
        document.getElementById('cartCount').textContent = count;
        document.getElementById('subtotalDisplay').textContent = '₹' + subtotal.toFixed(2);
        document.getElementById('taxDisplay').textContent = '₹' + tax.toFixed(2);
        document.getElementById('totalDisplay').textContent = '₹' + total.toFixed(2);
        placeBtn.disabled = items.length === 0;
    }

    function toggleDelivery() {
        const type = document.getElementById('orderType').value;
        const group = document.getElementById('deliveryAddressGroup');
        const addr = group.querySelector('textarea');
        group.style.display = type === 'delivery' ? 'block' : 'none';
        addr.required = type === 'delivery';
    }

    // Pre-select item from menu page link
    const urlParams = new URLSearchParams(window.location.search);
    const preItem = urlParams.get('item');
    if (preItem) {
        const btn = document.querySelector(`[onclick*="changeQty(${preItem}, 1"]`);
        if (btn) btn.click();
    }
</script>
@endpush

@endsection
