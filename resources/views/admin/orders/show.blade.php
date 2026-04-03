@extends('layouts.admin')
@section('title', 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<style>
    .order-show-page {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(300px, 0.95fr);
        gap: 1.5rem;
        align-items: start;
    }

    .order-show-card {
        border-radius: 20px;
        border: 1px solid #f0e1d3;
        background: linear-gradient(180deg, #ffffff, #fffaf5);
        box-shadow: 0 14px 36px rgba(32, 12, 0, 0.08);
        overflow: hidden;
    }

    .order-show-card + .order-show-card {
        margin-top: 1.25rem;
    }

    .order-show-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.25rem 1.35rem;
        background: linear-gradient(135deg, rgba(255, 107, 0, 0.12), rgba(244, 162, 45, 0.08));
        border-bottom: 1px solid #f2e3d6;
    }

    .order-show-header h3 {
        margin: 0;
        font-size: 1.18rem;
        font-weight: 700;
        color: var(--dark);
    }

    .order-show-header p {
        margin: 0.25rem 0 0;
        color: #8a6a50;
        font-size: 0.84rem;
    }

    .order-show-body {
        padding: 1.35rem;
    }

    .order-items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 0;
    }

    .order-items-table thead th {
        background: #f8f1ea;
        color: #7f5c42;
        font-size: 0.75rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #f0e1d3;
    }

    .order-items-table thead th:first-child {
        border-top-left-radius: 14px;
    }

    .order-items-table thead th:last-child {
        border-top-right-radius: 14px;
    }

    .order-items-table tbody td,
    .order-items-table tfoot td {
        padding: 1rem;
        border-bottom: 1px solid #f5eadf;
        vertical-align: top;
    }

    .order-items-table tbody tr:last-child td {
        border-bottom: 1px solid #f0e1d3;
    }

    .order-item-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .order-item-category {
        color: #b38f72;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .order-qty-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 54px;
        padding: 0.34rem 0.7rem;
        border-radius: 999px;
        background: #fff2e4;
        color: var(--saffron);
        font-weight: 700;
    }

    .order-price-strong {
        color: var(--saffron);
        font-weight: 800;
    }

    .order-notes-empty {
        color: #b7a493;
    }

    .order-total-label {
        text-align: right;
        font-weight: 700;
        color: #6d513d;
    }

    .order-total-row {
        background: #fff9f3;
    }

    .order-grand-row {
        background: linear-gradient(135deg, #fff3e0, #fff8ef);
    }

    .order-grand-row td {
        font-size: 1.05rem;
        font-weight: 800;
    }

    .order-info-stack {
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
    }

    .order-info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .order-info-label {
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #a58469;
    }

    .order-info-value {
        text-align: right;
        color: var(--dark);
        font-weight: 600;
    }

    .status-guide {
        display: grid;
        gap: 0.7rem;
        margin-top: 1.1rem;
        padding-top: 1.1rem;
        border-top: 1px solid #f0e1d3;
    }

    .status-guide-item {
        display: flex;
        gap: 0.7rem;
        align-items: flex-start;
        padding: 0.75rem 0.85rem;
        background: #fff9f3;
        border: 1px solid #f4e4d6;
        border-radius: 14px;
    }

    .status-guide-icon {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 107, 0, 0.12);
        color: var(--saffron);
        flex-shrink: 0;
    }

    .status-guide-item strong {
        display: block;
        color: var(--dark);
        margin-bottom: 0.15rem;
    }

    .status-guide-item span {
        color: #7c634f;
        font-size: 0.83rem;
        line-height: 1.5;
    }

    .customer-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.1rem 1.5rem;
    }

    .customer-grid-full {
        grid-column: 1 / -1;
    }

    .customer-label {
        font-size: 0.76rem;
        color: #aa8a6f;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .customer-value {
        font-size: 1rem;
        color: var(--dark);
        font-weight: 600;
    }

    .customer-note-box {
        background: #fff8ef;
        border: 1px solid #f2e1d2;
        border-radius: 14px;
        padding: 0.95rem 1rem;
        color: #6d513d;
        line-height: 1.6;
    }

    @media (max-width: 980px) {
        .order-show-page {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .order-show-header,
        .order-show-body {
            padding: 1rem;
        }

        .order-show-header {
            flex-direction: column;
            align-items: stretch;
        }

        .customer-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="order-show-page">

    <!-- Order Items -->
    <div>
        <div class="order-show-card">
            <div class="order-show-header">
                <div>
                    <h3>📦 Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
                    <p>Review items, totals, and customer details in one clean view.</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">← Back to Orders</a>
            </div>
            <div class="order-show-body">

            <table class="order-items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>
                            <div class="order-item-name">{{ $item->menuItem->name ?? 'Item Deleted' }}</div>
                            @if($item->menuItem)
                                <div class="order-item-category">{{ $item->menuItem->category }}</div>
                            @endif
                        </td>
                        <td>₹{{ number_format($item->unit_price, 2) }}</td>
                        <td><span class="order-qty-pill">× {{ $item->quantity }}</span></td>
                        <td><strong class="order-price-strong">₹{{ number_format($item->subtotal, 2) }}</strong></td>
                        <td class="{{ $item->notes ? '' : 'order-notes-empty' }}">{{ $item->notes ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="order-total-row">
                        <td colspan="3" class="order-total-label">Subtotal</td>
                        <td style="font-weight:700;">₹{{ number_format($order->total_amount - $order->tax_amount, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr class="order-total-row">
                        <td colspan="3" class="order-total-label">Tax (5% GST)</td>
                        <td style="font-weight:700;">₹{{ number_format($order->tax_amount, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr class="order-grand-row">
                        <td colspan="3" class="order-total-label">Grand Total</td>
                        <td class="order-price-strong">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="order-show-card">
            <div class="order-show-header">
                <div>
                    <h3>👤 Customer Details</h3>
                    <p>Everything the kitchen or counter team needs for this order.</p>
                </div>
            </div>
            <div class="order-show-body customer-grid">
                <div>
                    <p class="customer-label">Name</p>
                    <p class="customer-value">{{ $order->user->name ?? $order->guest_name ?? 'Guest' }}</p>
                </div>
                <div>
                    <p class="customer-label">Email</p>
                    <p class="customer-value">{{ $order->user->email ?? $order->guest_email ?? '—' }}</p>
                </div>
                <div>
                    <p class="customer-label">Phone</p>
                    <p class="customer-value">{{ $order->user->phone ?? $order->guest_phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="customer-label">Customer Type</p>
                    <p class="customer-value">{{ $order->user_id ? '🔐 Registered User' : '👤 Guest Order' }}</p>
                </div>
                @if($order->order_type === 'delivery' && $order->delivery_address)
                <div class="customer-grid-full">
                    <p class="customer-label">Delivery Address</p>
                    <p class="customer-value">📍 {{ $order->delivery_address }}</p>
                </div>
                @endif
                @if($order->notes)
                <div class="customer-grid-full">
                    <p class="customer-label">Special Instructions</p>
                    <div class="customer-note-box">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Panel: Status & Info -->
    <div style="display:flex; flex-direction:column; gap:1.25rem;">
        <!-- Order Info -->
        <div class="order-show-card">
            <div class="order-show-header">
                <div>
                    <h3>📋 Order Info</h3>
                    <p>Quick operational snapshot for this order.</p>
                </div>
            </div>
            <div class="order-show-body order-info-stack">
                <div class="order-info-row">
                    <span class="order-info-label">Order Type</span>
                    @if($order->order_type === 'delivery')
                        <span class="badge badge-info">🚚 Delivery</span>
                    @elseif($order->order_type === 'pickup')
                        <span class="badge badge-warning">🏪 Pickup</span>
                    @else
                        <span class="badge" style="background:#f3e5f5; color:#6a1b9a;">🪑 Dine-In</span>
                    @endif
                </div>
                <div class="order-info-row">
                    <span class="order-info-label">Payment</span>
                    <div class="order-info-value">
                        <div style="text-transform:capitalize;">{{ $order->payment_method }}</div>
                        @if($order->payment_status === 'paid')
                            <span class="badge badge-success" style="font-size:0.7rem;">Paid ✅</span>
                        @else
                            <span class="badge badge-warning" style="font-size:0.7rem;">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="order-info-row">
                    <span class="order-info-label">Placed At</span>
                    <span class="order-info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</span>
                </div>
                <div class="order-info-row">
                    <span class="order-info-label">Last Updated</span>
                    <span class="order-info-value">{{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="order-show-card">
            <div class="order-show-header">
                <div>
                    <h3>🔄 Update Status</h3>
                    <p>Keep the customer tracking page aligned with the kitchen workflow.</p>
                </div>
            </div>
            <div class="order-show-body">
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="js-crud-ajax" data-loading="Updating order status..." data-success="Order status updated.">
                @csrf @method('PATCH')
                <div class="form-group" style="margin-bottom:1rem;">
                    <label style="font-size:0.85rem; font-weight:600; color:#444; display:block; margin-bottom:0.4rem;">Order Status</label>
                    <select name="status" class="form-control" required>
                        @foreach(['pending','processing','ready','completed','cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">
                    <i class="fas fa-save"></i> Update Status
                </button>
            </form>

            <div class="status-guide">
                <div class="status-guide-item">
                    <span class="status-guide-icon">⏳</span>
                    <div><strong>Pending</strong><span>Waiting to be accepted and started.</span></div>
                </div>
                <div class="status-guide-item">
                    <span class="status-guide-icon">🔥</span>
                    <div><strong>Processing</strong><span>The kitchen is actively preparing the order.</span></div>
                </div>
                <div class="status-guide-item">
                    <span class="status-guide-icon">✅</span>
                    <div><strong>Ready</strong><span>Ready for pickup, serving, or handoff.</span></div>
                </div>
                <div class="status-guide-item">
                    <span class="status-guide-icon">🎉</span>
                    <div><strong>Completed</strong><span>The order has been collected or fulfilled.</span></div>
                </div>
                <div class="status-guide-item">
                    <span class="status-guide-icon">❌</span>
                    <div><strong>Cancelled</strong><span>The order was cancelled and should no longer progress.</span></div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
