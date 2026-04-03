{{-- resources/views/components/cart-bar.blade.php --}}
{{-- Include this in layouts/app.blade.php just before </body> --}}

@php $cart = app(\App\Services\Cart::class); @endphp
<style>
    /* ── Cart Bar ── */
    .cart-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 500;
        padding: 0 0 env(safe-area-inset-bottom);
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        pointer-events: none;
    }
    .cart-bar.has-items {
        transform: translateY(0);
        pointer-events: auto;
    }
    .cart-bar-inner {
        max-width: 900px;
        margin: 0 auto 1rem;
        background: #1A0A00;
        border-radius: 18px;
        box-shadow: 0 -4px 32px rgba(0,0,0,0.25), 0 8px 32px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,107,0,0.2);
        overflow: hidden;
        margin-left: 1rem;
        margin-right: 1rem;
    }

    /* ── Bar row ── */
    .cart-bar-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.9rem 1.25rem;
        gap: 1rem;
        cursor: pointer;
    }
    .cart-bar-left {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }
    .cart-count-bubble {
        background: var(--saffron);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 800;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cart-bar-label {
        color: #fff;
        font-size: 0.88rem;
        font-weight: 600;
    }
    .cart-bar-label span {
        color: rgba(255,255,255,0.5);
        font-size: 0.78rem;
        font-weight: 400;
        margin-left: 0.3rem;
    }
    .cart-bar-total {
        color: var(--saffron);
        font-size: 1rem;
        font-weight: 800;
    }
    .cart-bar-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .cart-chevron {
        color: rgba(255,255,255,0.4);
        font-size: 0.75rem;
        transition: transform 0.25s;
    }
    .cart-bar.drawer-open .cart-chevron { transform: rotate(180deg); }

    /* ── Drawer ── */
    .cart-drawer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .cart-bar.drawer-open .cart-drawer {
        max-height: 420px;
    }
    .cart-drawer-inner {
        padding: 0.75rem 1.25rem 1rem;
        overflow-y: auto;
        max-height: 420px;
    }

    /* ── Cart item row ── */
    .cart-item-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .cart-item-row:last-child { border-bottom: none; }
    .cart-item-img {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3D1A00, #2a1000);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        overflow: hidden;
    }
    .cart-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }
    .cart-item-info { flex: 1; min-width: 0; }
    .cart-item-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-item-price {
        font-size: 0.78rem;
        color: var(--saffron);
        font-weight: 700;
    }
    .qty-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }
    .qty-btn {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        border: 1.5px solid rgba(255,107,0,0.4);
        background: transparent;
        color: var(--saffron);
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, border-color 0.15s;
        line-height: 1;
    }
    .qty-btn:hover { background: rgba(255,107,0,0.15); border-color: var(--saffron); }
    .qty-num {
        font-size: 0.88rem;
        font-weight: 700;
        color: #fff;
        min-width: 18px;
        text-align: center;
    }
    .cart-item-subtotal {
        font-size: 0.82rem;
        font-weight: 700;
        color: rgba(255,255,255,0.7);
        min-width: 52px;
        text-align: right;
        flex-shrink: 0;
    }

    /* ── Drawer footer ── */
    .cart-drawer-footer {
        margin-top: 0.85rem;
        padding-top: 0.85rem;
        border-top: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .cart-total-block { color: rgba(255,255,255,0.6); font-size: 0.82rem; }
    .cart-total-block strong { display: block; color: #fff; font-size: 1rem; }
    .btn-checkout {
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.65rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: background 0.2s, transform 0.15s;
        white-space: nowrap;
    }
    .btn-checkout:hover { background: #e55a00; transform: translateY(-1px); }

    /* ── Navbar badge ── */
    .cart-nav-badge {
        position: absolute;
        top: -6px;
        right: -8px;
        background: var(--saffron);
        color: #fff;
        font-size: 0.6rem;
        font-weight: 800;
        min-width: 17px;
        height: 17px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        line-height: 1;
        display: none;
    }
    .cart-nav-badge.visible { display: flex; }
</style>

<div class="cart-bar {{ $cart->isNotEmpty() ? 'has-items' : '' }}" id="cartBar">
    <div class="cart-bar-inner">

        {{-- Bar row (click to toggle drawer) --}}
        <div class="cart-bar-row" onclick="toggleCartDrawer()">
            <div class="cart-bar-left">
                <div class="cart-count-bubble" id="cartCountBubble">{{ $cart->count() }}</div>
                <div class="cart-bar-label">
                    Your Cart
                    <span id="cartItemLabel">{{ $cart->count() }} {{ Str::plural('item', $cart->count()) }}</span>
                </div>
            </div>
            <div class="cart-bar-right">
                <span class="cart-bar-total" id="cartBarTotal">₹{{ number_format($cart->total(), 2) }}</span>
                <i class="fas fa-chevron-up cart-chevron" id="cartChevron"></i>
            </div>
        </div>

        {{-- Drawer --}}
        <div class="cart-drawer" id="cartDrawer">
            <div class="cart-drawer-inner">
                <div id="cartItemsList">
                    @foreach($cart->items() as $item)
                    @php $icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁']; @endphp
                    <div class="cart-item-row" id="cart-item-{{ $item['id'] }}">
                        <div class="cart-item-img">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                            @else
                                {{ $icons[$item['category']] ?? '🍽️' }}
                            @endif
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item['name'] }}</div>
                            <div class="cart-item-price">₹{{ number_format($item['price'], 2) }}</div>
                        </div>
                        <div class="qty-control">
                            <button class="qty-btn" onclick="updateQty({{ $item['id'] }}, -1, event)">−</button>
                            <span class="qty-num" id="qty-{{ $item['id'] }}">{{ $item['quantity'] }}</span>
                            <button class="qty-btn" onclick="updateQty({{ $item['id'] }}, 1, event)">+</button>
                        </div>
                        <div class="cart-item-subtotal" id="subtotal-{{ $item['id'] }}">
                            ₹{{ number_format($item['subtotal'], 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="cart-drawer-footer">
                    <div class="cart-total-block">
                        Total (incl. GST)
                        <strong id="cartDrawerTotal">₹{{ number_format($cart->total(), 2) }}</strong>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn-checkout">
                        Checkout <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;
const CART_CATEGORY_ICONS = {
    Misal: '🍲',
    Vadapav: '🥙',
    Poha: '🌾',
    Beverages: '🥛',
    Thali: '🍱',
    Snacks: '🌮',
    Desserts: '🍮',
    Combos: '🎁',
};

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function renderCartItems(items) {
    const cartItemsList = document.getElementById('cartItemsList');

    if (!cartItemsList) {
        return;
    }

    if (!items.length) {
        cartItemsList.innerHTML = '<div class="cart-item-row"><div class="cart-item-info"><div class="cart-item-name">Your cart is empty.</div><div class="cart-item-price">Add something delicious to get started.</div></div></div>';
        return;
    }

    cartItemsList.innerHTML = items.map((item) => {
        const imageHtml = item.image
            ? `<img src="/storage/${encodeURI(item.image)}" alt="${escapeHtml(item.name)}">`
            : escapeHtml(CART_CATEGORY_ICONS[item.category] ?? '🍽️');

        return `
            <div class="cart-item-row" id="cart-item-${item.id}">
                <div class="cart-item-img">
                    ${imageHtml}
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-name">${escapeHtml(item.name)}</div>
                    <div class="cart-item-price">₹${Number(item.price).toFixed(2)}</div>
                </div>
                <div class="qty-control">
                    <button class="qty-btn" onclick="updateQty(${item.id}, -1, event)">−</button>
                    <span class="qty-num" id="qty-${item.id}">${item.quantity}</span>
                    <button class="qty-btn" onclick="updateQty(${item.id}, 1, event)">+</button>
                </div>
                <div class="cart-item-subtotal" id="subtotal-${item.id}">
                    ₹${Number(item.subtotal).toFixed(2)}
                </div>
            </div>
        `;
    }).join('');
}

// ── Toggle drawer ─────────────────────────────────────────────
function toggleCartDrawer() {
    document.getElementById('cartBar').classList.toggle('drawer-open');
}

// ── Update quantity ───────────────────────────────────────────
async function updateQty(itemId, delta, e) {
    e.stopPropagation();
    const qtyEl = document.getElementById('qty-' + itemId);
    const current = parseInt(qtyEl?.textContent || '0');
    const newQty  = current + delta;

    try {
        const res = await fetch('/cart/update', {
            method: 'PATCH',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ menu_item_id: itemId, quantity: newQty }),
        });
        const data = await res.json();
        if (!res.ok) {
            console.error('Cart update failed', data);
            return;
        }

        refreshCartUI(data.cart, itemId, newQty);
    } catch (err) {
        console.error(err);
    }
}

// ── Add to cart (called from menu page) ──────────────────────
async function addToCart(itemId, btn) {
    const original = btn.textContent;
    btn.disabled = true;
    btn.textContent = '✓ Added';

    try {
        const res = await fetch('/cart/add', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ menu_item_id: itemId, quantity: 1 }),
        });
        const data = await res.json();
        if (!res.ok) {
            console.error('Add to cart failed', data);
            btn.textContent = original;
            btn.disabled = false;
            return;
        }

        refreshCartUI(data.cart, null, null);
        refreshCartItem(data.cart, itemId);

        // Show cart bar
        document.getElementById('cartBar').classList.add('has-items');

        setTimeout(() => { btn.textContent = original; btn.disabled = false; }, 1200);
    } catch (err) {
        console.error('Add to cart request failed', err);
        btn.textContent = original;
        btn.disabled = false;
    }
}

// ── Refresh cart bar UI from summary ─────────────────────────
function refreshCartUI(cart, changedItemId, newQty) {
    // Update count bubble
    document.getElementById('cartCountBubble').textContent = cart.count;
    document.getElementById('cartItemLabel').textContent   = cart.count + (cart.count === 1 ? ' item' : ' items');
    document.getElementById('cartBarTotal').textContent    = '₹' + cart.total.toFixed(2);
    document.getElementById('cartDrawerTotal').textContent = '₹' + cart.total.toFixed(2);
    renderCartItems(cart.items);

    // Update navbar badge
    const badge = document.getElementById('cartNavBadge');
    if (badge) {
        badge.textContent = cart.count;
        badge.classList.toggle('visible', cart.count > 0);
    }

    // Hide bar if empty
    document.getElementById('cartBar').classList.toggle('has-items', cart.count > 0);

    if (changedItemId !== null && newQty <= 0 && !cart.count) {
        document.getElementById('cartBar').classList.remove('drawer-open');
    }
}

// ── Refresh a single item's qty control on menu page ─────────
function refreshCartItem(cart, itemId) {
    const item = cart.items.find(i => i.id === itemId);
    const qtyDisplay = document.getElementById('menu-qty-' + itemId);
    if (qtyDisplay) qtyDisplay.textContent = item ? item.quantity : 0;
}
</script>
