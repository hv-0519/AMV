{{-- resources/views/payment/payment.blade.php --}}
@extends('layouts.app')
@section('title', 'Secure Payment — AMV')

@section('content')
<style>
* { box-sizing: border-box; }

.pay-wrap {
    min-height: 100vh;
    background: #f5f0e8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 16px;
    font-family: 'Poppins', sans-serif;
}

/* ── Main card ─────────────────────────────────────────────────────────────── */
.pay-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 50px rgba(60,20,0,0.13);
    width: 100%;
    max-width: 460px;
    overflow: hidden;
}

/* ── Header ────────────────────────────────────────────────────────────────── */
.pay-header {
    background: linear-gradient(135deg, #2c1200 0%, #5c2800 100%);
    padding: 22px 26px 18px;
    color: #fff;
}
.pay-header .brand {
    display: flex;
    align-items: center;
    gap: 11px;
    margin-bottom: 16px;
}
.pay-header .brand-icon {
    width: 38px; height: 38px;
    background: #fff;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
}
.pay-header .brand-name  { font-size: 1.05rem; font-weight: 700; }
.pay-header .brand-sub   { font-size: 0.7rem; opacity: 0.75; margin-top: 1px; }

.pay-header .amount-row  {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}
.pay-header .amount-label { font-size: 0.75rem; opacity: 0.75; }
.pay-header .amount-val   { font-size: 1.9rem; font-weight: 700; letter-spacing: -0.5px; }
.pay-header .order-ref    { font-size: 0.7rem; opacity: 0.65; margin-top: 2px; }

.pay-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-top: 12px;
    letter-spacing: 0.5px;
}

/* ── Tabs ──────────────────────────────────────────────────────────────────── */
.pay-tabs {
    display: flex;
    background: #faf7f3;
    border-bottom: 2px solid #ede8e0;
}
.pay-tab {
    flex: 1;
    padding: 13px 0;
    text-align: center;
    font-size: 0.8rem;
    font-weight: 600;
    color: #999;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s;
    user-select: none;
}
.pay-tab.active {
    color: #c45c00;
    border-bottom-color: #c45c00;
    background: #fff;
}
.pay-tab i { margin-right: 5px; }

/* ── Body ──────────────────────────────────────────────────────────────────── */
.pay-body  { padding: 22px 26px 26px; }
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* ── QR section ────────────────────────────────────────────────────────────── */
.qr-hint {
    background: #fffbf5;
    border: 1px solid #ede0cc;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 0.78rem;
    color: #7a5c3a;
    margin-bottom: 18px;
    line-height: 1.5;
}

.qr-box {
    background: linear-gradient(135deg, #2c1200, #5c2800);
    border-radius: 16px;
    padding: 22px 16px 18px;
    text-align: center;
    margin-bottom: 18px;
}
.qr-box .qr-title   { font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
.qr-box .qr-sub     { font-size: 0.7rem; color: rgba(255,255,255,0.65); margin-bottom: 16px; }

.qr-img-wrap {
    background: #fff;
    border-radius: 12px;
    padding: 12px;
    display: inline-block;
    margin-bottom: 14px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}
.qr-img-wrap img {
    width: 180px;
    height: 180px;
    display: block;
}

.qr-timer {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.12);
    border-radius: 20px;
    padding: 5px 14px;
    font-size: 0.78rem;
    color: #fff;
    margin-bottom: 12px;
}
.qr-timer #countdown {
    font-weight: 700;
    font-size: 0.95rem;
    min-width: 20px;
    display: inline-block;
    text-align: center;
}

.qr-meta {
    display: flex;
    justify-content: center;
    gap: 10px;
}
.qr-chip {
    background: rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 0.7rem;
    color: #fff;
    font-weight: 600;
}

/* ── Divider ───────────────────────────────────────────────────────────────── */
.divider {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #bbb;
    font-size: 0.73rem;
    margin: 14px 0;
}
.divider::before, .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #ece8e0;
}

/* ── Input ─────────────────────────────────────────────────────────────────── */
.pay-input-wrap       { margin-bottom: 14px; }
.pay-input-wrap label { display: block; font-size: 0.73rem; font-weight: 600; color: #666; margin-bottom: 5px; }
.pay-input {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #ddd;
    border-radius: 10px;
    font-size: 0.88rem;
    font-family: 'Poppins', sans-serif;
    outline: none;
    transition: border 0.2s;
}
.pay-input:focus { border-color: #c45c00; }
.input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

/* ── Card networks ─────────────────────────────────────────────────────────── */
.card-networks { display: flex; gap: 8px; margin-bottom: 14px; }
.net-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 10px;
    border: 1.5px solid #ddd;
    border-radius: 6px;
}
.net-badge svg {
    display: block;
}

/* ── Pay button ────────────────────────────────────────────────────────────── */
.btn-pay {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #c45c00, #e07020);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 700;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    margin-top: 4px;
    transition: opacity 0.2s, transform 0.1s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-pay:hover  { opacity: 0.9; }
.btn-pay:active { transform: scale(0.98); }
.btn-pay:disabled {
    background: #ccc;
    cursor: not-allowed;
    opacity: 0.7;
}

.btn-pay-note {
    text-align: center;
    font-size: 0.68rem;
    color: #aaa;
    margin-top: 7px;
}

/* ── Security strip ────────────────────────────────────────────────────────── */
.security-strip {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 14px;
    font-size: 0.68rem;
    color: #bbb;
}
.security-strip i { color: #4caf50; }

/* ── Processing overlay ────────────────────────────────────────────────────── */
.processing-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.processing-overlay.show { display: flex; }
.proc-box {
    background: #fff;
    border-radius: 18px;
    padding: 36px 44px;
    text-align: center;
    min-width: 260px;
}
.proc-spinner {
    width: 52px; height: 52px;
    border: 5px solid #f0f0f0;
    border-top-color: #c45c00;
    border-radius: 50%;
    animation: spin 0.85s linear infinite;
    margin: 0 auto 16px;
}
@keyframes spin { to { transform: rotate(360deg); } }
.proc-title { font-weight: 700; font-size: 1rem; color: #333; margin-bottom: 4px; }
.proc-sub   { font-size: 0.78rem; color: #888; }
</style>

{{-- Processing overlay --}}
<div class="processing-overlay" id="processingOverlay">
    <div class="proc-box">
        <div class="proc-spinner"></div>
        <div class="proc-title">Processing Payment</div>
        <div class="proc-sub">Please do not close this window...</div>
    </div>
</div>

<div class="pay-wrap">
    <div class="pay-card">

        {{-- Header --}}
        <div class="pay-header">
            <div class="brand">
                <div class="brand-icon">🍛</div>
                <div>
                    <div class="brand-name">AMV Pay</div>
                    <div class="brand-sub">Secure Payment Gateway</div>
                </div>
            </div>
            <div class="amount-row">
                <div>
                    <div class="amount-label">Total Payable</div>
                    <div class="order-ref">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="amount-val">₹{{ number_format($order->total_amount, 2) }}</div>
            </div>
            <div class="pay-badge">
                <i class="fas fa-mobile-alt"></i> UPI PAYMENT SELECTED
            </div>
        </div>

        {{-- Tabs --}}
        <div class="pay-tabs">
            <div class="pay-tab active" id="tab-btn-upi" onclick="switchTab('upi', this)">
                <i class="fas fa-mobile-alt"></i> UPI
            </div>
            <div class="pay-tab" id="tab-btn-card" onclick="switchTab('card', this)">
                <i class="fas fa-credit-card"></i> Card
            </div>
        </div>

        <div class="pay-body">

            {{-- ── UPI Tab ────────────────────────────────────────────────── --}}
            <div class="tab-panel active" id="tab-upi">

                <div class="qr-hint">
                    Scan the AMV UPI QR with any UPI app. Keep this screen open for
                    <strong>25 seconds</strong>, then confirm the payment to finish your order.
                </div>

                <div class="qr-box">
                    <div class="qr-title">Scan to Pay with UPI</div>
                    <div class="qr-sub">PhonePe, GPay, Paytm, BHIM and other UPI apps supported</div>

                    <div class="qr-img-wrap">
                        <img src="{{ asset('images/amv_qr.png') }}" alt="AMV UPI QR Code">
                    </div>

                    <div class="qr-timer">
                        🕐 QR visible for &nbsp;<span id="countdown">25</span>&nbsp; s
                    </div>

                    <div class="qr-meta">
                        <span class="qr-chip">₹{{ number_format($order->total_amount, 2) }}</span>
                        <span class="qr-chip"># Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                <div class="divider">or enter UPI ID manually</div>

                <form id="upiForm"
                      action="{{ route('payment.process', $order->id) }}"
                      method="POST"
                      onsubmit="showProcessing()">
                    @csrf
                    <input type="hidden" name="payment_method" value="upi">

                    <div class="pay-input-wrap">
                        <label>UPI ID</label>
                        <input type="text" name="upi_id" class="pay-input"
                               placeholder="yourname@paytm / @okaxis"
                               pattern="[a-zA-Z0-9.\-_]{2,256}@[a-zA-Z]{2,64}"
                               title="Enter a valid UPI ID like name@paytm">
                    </div>

                    <button type="submit" id="upiPayBtn" class="btn-pay" disabled>
                        <i class="fas fa-lock"></i>
                        Confirm UPI Payment — ₹{{ number_format($order->total_amount, 2) }}
                    </button>
                    <div class="btn-pay-note" id="upiNote">
                        The confirm button unlocks after the 25-second scan window ends.
                    </div>
                </form>

            </div>

            {{-- ── Card Tab ───────────────────────────────────────────────── --}}
            <div class="tab-panel" id="tab-card">

                <div class="card-networks">
                    <span class="net-badge" aria-label="Visa">
                        <svg height="22px" viewBox="0 0 64 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <path fill="#1A1F71" d="M24.11 16.63h-3.08l1.93-11.25h3.08l-1.93 11.25Zm11.17-10.98a7.6 7.6 0 0 0-2.76-.48c-3.04 0-5.18 1.53-5.2 3.72-.02 1.62 1.54 2.52 2.72 3.06 1.22.56 1.63.92 1.63 1.42-.01.77-.97 1.12-1.87 1.12-1.25 0-1.91-.17-2.94-.6l-.4-.18-.44 2.54c.73.32 2.08.59 3.47.6 3.23 0 5.34-1.51 5.36-3.85.01-1.28-.81-2.26-2.59-3.06-1.08-.52-1.74-.86-1.74-1.38.01-.46.55-.95 1.75-.95.99-.02 1.71.2 2.27.43l.27.12.47-2.47Zm7.94-.27h-2.38c-.74 0-1.29.2-1.61.93l-4.56 10.32h3.22s.53-1.39.65-1.7h3.93c.09.4.37 1.7.37 1.7h2.84l-2.46-11.25Zm-3.1 7.13c.25-.63 1.2-3.11 1.2-3.11-.02.04.25-.64.4-1.05l.2.95s.58 2.67.7 3.21h-2.5Zm-20.57-7.13-3.01 7.67-.32-1.56c-.56-1.82-2.31-3.8-4.26-4.78l2.75 9.89h3.24L22.77 5.38h-3.22Z"/>
                            <path fill="#F7A600" d="M13.77 5.38H8.86L8.8 5.61c3.82.93 6.35 3.17 7.4 5.88l-1.07-5.32c-.18-.71-.72-.76-1.36-.79Z"/>
                        </svg>
                    </span>
                    <span class="net-badge" aria-label="Mastercard">
                        <svg height="22px" viewBox="0 0 48 32" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <circle cx="18" cy="16" r="10" fill="#EB001B"/>
                            <circle cx="30" cy="16" r="10" fill="#F79E1B"/>
                            <path fill="#FF5F00" d="M24 8.2A12.3 12.3 0 0 0 24 23.8A12.3 12.3 0 0 0 24 8.2Z"/>
                        </svg>
                    </span>
                    <span class="net-badge" aria-label="RuPay">
                        <svg height="22px" viewBox="0 0 96 32" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                            <defs>
                                <linearGradient id="rupay-green" x1="0%" y1="50%" x2="100%" y2="50%">
                                    <stop offset="0%" stop-color="#2BB673"/>
                                    <stop offset="100%" stop-color="#008C44"/>
                                </linearGradient>
                                <linearGradient id="rupay-blue" x1="0%" y1="50%" x2="100%" y2="50%">
                                    <stop offset="0%" stop-color="#00AEEF"/>
                                    <stop offset="100%" stop-color="#1D4F91"/>
                                </linearGradient>
                            </defs>
                            <path fill="url(#rupay-green)" d="M14.2 8.1h7.1c3.95 0 6.6 2.04 6.6 5.43c0 2.6-1.48 4.38-3.9 5.08L28 24.1h-5.4l-3.3-4.75h-.85v4.75h-4.25V8.1Zm6.68 7.95c1.59 0 2.63-.85 2.63-2.28c0-1.4-1.01-2.18-2.63-2.18h-2.43v4.46h2.43Z"/>
                            <path fill="url(#rupay-blue)" d="M31.08 8.1h4.3v9.1c0 2.18 1.14 3.46 3.08 3.46c1.92 0 3.06-1.28 3.06-3.46V8.1h4.3v9.36c0 4.67-2.72 7.08-7.4 7.08c-4.65 0-7.34-2.4-7.34-7.08V8.1Zm17.52 0h7.06c4.22 0 6.98 2.22 6.98 5.95c0 3.78-2.8 6.1-7.04 6.1h-2.7v3.95H48.6V8.1Zm6.45 8.4c1.97 0 3.1-.92 3.1-2.43c0-1.55-1.1-2.4-3.1-2.4H52.9v4.83h2.15Z"/>
                            <path fill="#F58220" d="M69.2 8.1h12.6l-2.45 3.72h-6.52l-.5 1.65h6.08l-2.3 3.48h-4.83l-.55 1.8h7.45l-2.42 3.72H64.22L69.2 8.1Zm13.56 0h4.31l3.5 6.55L95.3 8.1H96l-6.95 10.12l3.48 5.88H88.2l-3.62-6.04L80.5 24.1h-4.4l6.96-9.93L79.7 8.1Z"/>
                        </svg>
                    </span>
                </div>

                <form id="cardForm"
                      action="{{ route('payment.process', $order->id) }}"
                      method="POST"
                      onsubmit="showProcessing()">
                    @csrf
                    <input type="hidden" name="payment_method" value="card">

                    <div class="pay-input-wrap">
                        <label>Card Number</label>
                        <input type="text" name="card_number" class="pay-input"
                               placeholder="0000  0000  0000  0000"
                               maxlength="19"
                               oninput="formatCard(this)"
                               required>
                    </div>

                    <div class="pay-input-wrap">
                        <label>Cardholder Name</label>
                        <input type="text" name="card_name" class="pay-input"
                               placeholder="Name on card" required>
                    </div>

                    <div class="input-row">
                        <div class="pay-input-wrap">
                            <label>Expiry</label>
                            <input type="text" name="card_expiry" class="pay-input"
                                   placeholder="MM / YY" maxlength="7"
                                   oninput="formatExpiry(this)" required>
                        </div>
                        <div class="pay-input-wrap">
                            <label>CVV</label>
                            <input type="password" name="card_cvv" class="pay-input"
                                   placeholder="•••" maxlength="4" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-pay">
                        <i class="fas fa-lock"></i>
                        Pay ₹{{ number_format($order->total_amount, 2) }} Securely
                    </button>
                </form>

            </div>

            {{-- Security strip --}}
            <div class="security-strip">
                <i class="fas fa-shield-alt"></i>
                256-bit SSL encrypted &nbsp;·&nbsp; PCI DSS Compliant &nbsp;·&nbsp; Safe &amp; Secure
            </div>

        </div>
    </div>
</div>

<script>
// ── Tab switcher ──────────────────────────────────────────────────────────────
function switchTab(tab, el) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.pay-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    el.classList.add('active');
}

// ── Processing overlay ────────────────────────────────────────────────────────
function showProcessing() {
    document.getElementById('processingOverlay').classList.add('show');
}

// ── Card formatters ───────────────────────────────────────────────────────────
function formatCard(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = v.replace(/(.{4})/g, '$1  ').trim();
}
function formatExpiry(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 4);
    if (v.length >= 2) v = v.substring(0, 2) + ' / ' + v.substring(2);
    input.value = v;
}

// ── QR countdown — unlocks UPI confirm button after 25s ──────────────────────
(function() {
    let seconds = 25;
    const display  = document.getElementById('countdown');
    const btn      = document.getElementById('upiPayBtn');
    const note     = document.getElementById('upiNote');

    const timer = setInterval(function () {
        seconds--;
        if (display) display.textContent = seconds;

        if (seconds <= 0) {
            clearInterval(timer);
            if (btn)  { btn.disabled = false; }
            if (note) { note.textContent = 'Scanned? Enter your UPI ID above and confirm payment.'; }
            if (display) {
                display.closest('.qr-timer').innerHTML =
                    '✅ &nbsp; Scan window complete — confirm below';
            }
        }
    }, 1000);
})();
</script>
@endsection
