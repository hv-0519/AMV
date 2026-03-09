@extends('layouts.app')

@section('title', 'Order Confirmation')

@push('styles')
<style>
    .confirmation-wrap {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem 2rem;
    }
    .confirmation-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .confirmation-head {
        background: #E8F5E9;
        color: #2E7D32;
        padding: 1rem 1.25rem;
        font-weight: 600;
        border-bottom: 1px solid #C8E6C9;
    }
    .confirmation-body {
        padding: 1.25rem;
    }
    .confirmation-grid {
        display: grid;
        grid-template-columns: 1fr auto auto auto;
        gap: 0.75rem;
        align-items: center;
        margin-top: 0.75rem;
    }
    .confirmation-grid.header {
        font-weight: 600;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.5rem;
    }
    .confirmation-grid.row {
        padding: 0.35rem 0;
        border-bottom: 1px dashed #f0f0f0;
    }
    .confirmation-total {
        margin-top: 1rem;
        text-align: right;
        font-size: 1.1rem;
        font-weight: 700;
    }
    .empty-items {
        margin-top: 0.75rem;
        color: #666;
    }
    @media (max-width: 640px) {
        .confirmation-grid {
            grid-template-columns: 1fr 1fr;
        }
        .confirmation-grid.header div:nth-child(3),
        .confirmation-grid.header div:nth-child(4),
        .confirmation-grid.row div:nth-child(3),
        .confirmation-grid.row div:nth-child(4) {
            text-align: left !important;
        }
    }
</style>
@endpush

@section('content')
    <section class="confirmation-wrap">
        <div class="confirmation-card">
            <div class="confirmation-head">
                Order placed successfully
            </div>

            <div class="confirmation-body">
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>

                <div class="confirmation-grid header">
                    <div>Item</div>
                    <div>Qty</div>
                    <div style="text-align:right;">Unit Price</div>
                    <div style="text-align:right;">Subtotal</div>
                </div>

                @forelse($order->orderItems as $item)
                    <div class="confirmation-grid row">
                        <div>{{ $item->menuItem->name ?? 'Item' }}</div>
                        <div>{{ $item->quantity }}</div>
                        <div style="text-align:right;">₹{{ number_format((float) $item->unit_price, 2) }}</div>
                        <div style="text-align:right;">₹{{ number_format((float) $item->subtotal, 2) }}</div>
                    </div>
                @empty
                    <p class="empty-items">No items found for this order.</p>
                @endforelse

                <div class="confirmation-total">
                    Total Amount: ₹{{ number_format((float) $order->total_amount, 2) }}
                </div>
            </div>
        </div>
    </section>
@endsection
