{{-- resources/views/payment/failed.blade.php --}}
@extends('layouts.app')
@section('title', 'Payment Failed — AMV')

@section('content')
<style>
.result-wrap {
    min-height: 100vh;
    background: #fff5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 16px;
    font-family: 'Poppins', sans-serif;
}
.result-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 40px rgba(220,40,40,0.10);
    width: 100%;
    max-width: 440px;
    padding: 40px 32px;
    text-align: center;
}
.result-icon {
    width: 80px; height: 80px;
    background: #fff0f0;
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
.result-title { font-size: 1.4rem; font-weight: 700; color: #c0392b; margin-bottom: 6px; }
.result-sub   { font-size: 0.85rem; color: #666; margin-bottom: 24px; }

.reason-box {
    background: #fff8f8;
    border: 1.5px solid #ffc5c5;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 24px;
    font-size: 0.82rem;
    color: #888;
    text-align: left;
}
.reason-box ul { margin: 8px 0 0 16px; padding: 0; }
.reason-box ul li { margin-bottom: 4px; }

.btn-row { display: flex; gap: 12px; justify-content: center; }

.btn-retry {
    padding: 12px 28px;
    background: linear-gradient(135deg, #c0392b, #e74c3c);
    color: #fff;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.88rem;
    text-decoration: none;
    transition: opacity 0.2s;
}
.btn-retry:hover { opacity: 0.88; color: #fff; }

.btn-home {
    padding: 12px 28px;
    background: #f0f0f0;
    color: #444;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.88rem;
    text-decoration: none;
    transition: background 0.2s;
}
.btn-home:hover { background: #e0e0e0; color: #333; }
</style>

<div class="result-wrap">
    <div class="result-card">
        <div class="result-icon">❌</div>
        <div class="result-title">Payment Failed</div>
        <div class="result-sub">We could not process your payment. No amount has been deducted.</div>

        <div class="reason-box">
            <strong>Possible reasons:</strong>
            <ul>
                <li>Incorrect UPI ID or card details</li>
                <li>Insufficient balance</li>
                <li>Transaction declined by bank</li>
                <li>Network timeout</li>
            </ul>
        </div>

        <div class="btn-row">
            <a href="{{ route('payment.retry', $order->id) }}" class="btn-retry">
                🔄 Retry Payment
            </a>
            <a href="{{ route('home') }}" class="btn-home">
                Home
            </a>
        </div>
    </div>
</div>
@endsection
