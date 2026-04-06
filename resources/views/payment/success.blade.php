{{-- resources/views/payment/success.blade.php --}}
@extends('layouts.app')
@section('title', 'Payment Successful — AMV')

@section('content')
<style>
.result-wrap {
    min-height: 100vh;
    background: #f0fff4;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 16px;
    font-family: 'Poppins', sans-serif;
}
.result-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 40px rgba(0,180,80,0.12);
    width: 100%;
    max-width: 440px;
    padding: 40px 32px;
    text-align: center;
}
.result-icon {
    width: 80px; height: 80px;
    background: #e6fff0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2.2rem;
    animation: popIn 0.4s ease;
}
@keyframes popIn {
    0%   { transform: scale(0); opacity: 0; }
    70%  { transform: scale(1.15); }
    100% { transform: scale(1);   opacity: 1; }
}
.result-title { font-size: 1.4rem; font-weight: 700; color: #1a7a3c; margin-bottom: 6px; }
.result-sub   { font-size: 0.85rem; color: #666; margin-bottom: 24px; }

.txn-box {
    background: #f6fff9;
    border: 1.5px solid #b2f0cb;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    text-align: left;
}
.txn-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.82rem;
    padding: 4px 0;
    color: #444;
}
.txn-row span:first-child { color: #888; }
.txn-row span:last-child  { font-weight: 600; }

.btn-home {
    display: inline-block;
    padding: 12px 32px;
    background: linear-gradient(135deg, #1a7a3c, #22c55e);
    color: #fff;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.92rem;
    text-decoration: none;
    transition: opacity 0.2s;
}
.btn-home:hover { opacity: 0.88; color: #fff; }
</style>

<div class="result-wrap">
    <div class="result-card">
        <div class="result-icon">✅</div>
        <div class="result-title">Payment Successful!</div>
        <div class="result-sub">Your order has been placed and is being prepared.</div>

        <div class="txn-box">
            <div class="txn-row">
                <span>Order ID</span>
                <span>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="txn-row">
                <span>Transaction ID</span>
                <span>{{ $order->transaction_id }}</span>
            </div>
            <div class="txn-row">
                <span>Amount Paid</span>
                <span>₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="txn-row">
                <span>Payment Method</span>
                <span>{{ strtoupper($order->payment_method) }}</span>
            </div>
            @if($order->upi_id)
            <div class="txn-row">
                <span>UPI ID</span>
                <span>{{ $order->upi_id }}</span>
            </div>
            @endif
            <div class="txn-row">
                <span>Status</span>
                <span style="color:#1a7a3c;">● Paid</span>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn-home">
            Back to Home
        </a>
    </div>
</div>
@endsection
