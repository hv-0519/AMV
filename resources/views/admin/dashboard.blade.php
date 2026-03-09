@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
        <div>
            <div class="stat-number">{{ $stats['total_orders'] ?? 0 }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon"><i class="fas fa-fire"></i></div>
        <div>
            <div class="stat-number">{{ $stats['pending_orders'] ?? 0 }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-rupee-sign"></i></div>
        <div>
            <div class="stat-number">₹{{ number_format($stats['today_revenue'] ?? 0) }}</div>
            <div class="stat-label">Today's Revenue</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-number">{{ $stats['total_customers'] ?? 0 }}</div>
            <div class="stat-label">Customers</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-utensils"></i></div>
        <div>
            <div class="stat-number">{{ $stats['menu_items'] ?? 0 }}</div>
            <div class="stat-label">Menu Items</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div>
            <div class="stat-number">{{ $stats['low_stock'] ?? 0 }}</div>
            <div class="stat-label">Low Stock Items</div>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem;">
    <!-- Recent Orders -->
    <div class="data-card">
        <div class="data-card-header">
            <h3>📦 Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders ?? [] as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>{{ $order->items_count ?? 1 }} items</td>
                    <td>₹{{ number_format($order->total_amount) }}</td>
                    <td>
                        @if($order->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($order->status === 'processing')
                            <span class="badge badge-info">Processing</span>
                        @elseif($order->status === 'completed')
                            <span class="badge badge-success">Completed</span>
                        @else
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; color:#aaa; padding:2rem;">No orders yet. 🍲</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Quick Stats Panel -->
    <div>
        <div class="data-card" style="margin-bottom:1.5rem;">
            <div class="data-card-header"><h3>⚡ Quick Actions</h3></div>
            <div style="display:flex; flex-direction:column; gap:0.8rem;">
                <a href="{{ route('admin.menu.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Menu Item</a>
                <a href="{{ route('admin.stocks.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add Stock Item</a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline"><i class="fas fa-list"></i> View All Orders</a>
            </div>
        </div>

        <div class="data-card">
            <div class="data-card-header"><h3>⚠️ Low Stock Alerts</h3></div>
            @forelse($low_stock_items ?? [] as $item)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:0.6rem 0; border-bottom:1px solid #f0ebe3;">
                <span style="font-size:0.88rem;">{{ $item->name }}</span>
                <span class="badge badge-danger">{{ $item->quantity }} {{ $item->unit }}</span>
            </div>
            @empty
            <p style="color:#aaa; font-size:0.88rem; text-align:center; padding:1rem;">✅ All stocks are healthy!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
