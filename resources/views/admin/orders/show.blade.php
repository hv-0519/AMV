@extends('layouts.admin')
@section('title', 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@section('content')
<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; align-items:start;">

    <!-- Order Items -->
    <div>
        <div class="data-card" style="margin-bottom:1.5rem;">
            <div class="data-card-header">
                <h3>📦 Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">← Back to Orders</a>
            </div>

            <table>
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
                            <strong>{{ $item->menuItem->name ?? 'Item Deleted' }}</strong>
                            @if($item->menuItem)
                                <br><small style="color:#aaa;">{{ $item->menuItem->category }}</small>
                            @endif
                        </td>
                        <td>₹{{ number_format($item->unit_price, 2) }}</td>
                        <td><strong>× {{ $item->quantity }}</strong></td>
                        <td><strong style="color:var(--saffron);">₹{{ number_format($item->subtotal, 2) }}</strong></td>
                        <td style="font-size:0.82rem; color:#888;">{{ $item->notes ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#fff8ef;">
                        <td colspan="3" style="text-align:right; font-weight:600; padding:0.8rem 1rem;">Subtotal</td>
                        <td style="font-weight:700;">₹{{ number_format($order->total_amount - $order->tax_amount, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr style="background:#fff8ef;">
                        <td colspan="3" style="text-align:right; font-weight:600; padding:0 1rem 0.8rem;">Tax (5% GST)</td>
                        <td style="font-weight:700;">₹{{ number_format($order->tax_amount, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr style="background:#fff3e0;">
                        <td colspan="3" style="text-align:right; font-weight:800; font-size:1rem; padding:0.8rem 1rem;">Grand Total</td>
                        <td style="font-weight:800; font-size:1.1rem; color:var(--saffron);">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Customer Details -->
        <div class="data-card">
            <div class="data-card-header"><h3>👤 Customer Details</h3></div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Name</p>
                    <p style="font-weight:600;">{{ $order->user->name ?? $order->guest_name ?? 'Guest' }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Email</p>
                    <p>{{ $order->user->email ?? $order->guest_email ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Phone</p>
                    <p>{{ $order->user->phone ?? $order->guest_phone ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Customer Type</p>
                    <p>{{ $order->user_id ? '🔐 Registered User' : '👤 Guest Order' }}</p>
                </div>
                @if($order->order_type === 'delivery' && $order->delivery_address)
                <div style="grid-column:1/-1;">
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Delivery Address</p>
                    <p>📍 {{ $order->delivery_address }}</p>
                </div>
                @endif
                @if($order->notes)
                <div style="grid-column:1/-1;">
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Special Instructions</p>
                    <div style="background:#fff8ef; border-radius:8px; padding:0.8rem; font-size:0.9rem;">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Panel: Status & Info -->
    <div>
        <!-- Order Info -->
        <div class="data-card" style="margin-bottom:1rem;">
            <h3 style="font-size:1rem; margin-bottom:1.2rem;">📋 Order Info</h3>
            <div style="display:flex; flex-direction:column; gap:0.8rem;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.85rem; color:#666;">Order Type</span>
                    @if($order->order_type === 'delivery')
                        <span class="badge badge-info">🚚 Delivery</span>
                    @elseif($order->order_type === 'pickup')
                        <span class="badge badge-warning">🏪 Pickup</span>
                    @else
                        <span class="badge" style="background:#f3e5f5; color:#6a1b9a;">🪑 Dine-In</span>
                    @endif
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.85rem; color:#666;">Payment</span>
                    <div style="text-align:right;">
                        <div style="font-size:0.85rem; font-weight:600; text-transform:capitalize;">{{ $order->payment_method }}</div>
                        @if($order->payment_status === 'paid')
                            <span class="badge badge-success" style="font-size:0.7rem;">Paid ✅</span>
                        @else
                            <span class="badge badge-warning" style="font-size:0.7rem;">Pending</span>
                        @endif
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:0.85rem; color:#666;">Placed At</span>
                    <span style="font-size:0.85rem; font-weight:600;">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:0.85rem; color:#666;">Last Updated</span>
                    <span style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="data-card">
            <h3 style="font-size:1rem; margin-bottom:1.2rem;">🔄 Update Status</h3>
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
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

            <div style="margin-top:1.2rem; padding-top:1rem; border-top:1px solid #f0ebe3;">
                <div style="font-size:0.8rem; line-height:2.2; color:#666;">
                    <div>⏳ <strong>Pending</strong> — Waiting to be confirmed</div>
                    <div>🔥 <strong>Processing</strong> — Being prepared in kitchen</div>
                    <div>✅ <strong>Ready</strong> — Ready for pickup/delivery</div>
                    <div>🎉 <strong>Completed</strong> — Delivered/Collected</div>
                    <div>❌ <strong>Cancelled</strong> — Order cancelled</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
