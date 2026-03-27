@extends('layouts.admin')
@section('title', 'Orders Management')

@section('content')
<!-- Status Summary -->
<div class="stats-grid" style="margin-bottom:1.5rem;">
    @php
    $statuses = [
        'all' => ['label' => 'All Orders', 'icon' => 'fas fa-list', 'color' => ''],
        'pending' => ['label' => 'Pending', 'icon' => 'fas fa-clock', 'color' => 'red'],
        'processing' => ['label' => 'Processing', 'icon' => 'fas fa-fire', 'color' => 'blue'],
        'completed' => ['label' => 'Completed', 'icon' => 'fas fa-check', 'color' => 'green'],
        'cancelled' => ['label' => 'Cancelled', 'icon' => 'fas fa-times', 'color' => 'red'],
    ];
    @endphp
    @foreach($statuses as $key => $s)
    <a href="{{ route('admin.orders.index', $key !== 'all' ? ['status' => $key] : []) }}" style="text-decoration:none;">
        <div class="stat-card {{ $s['color'] }}" style="{{ request('status') == $key || ($key === 'all' && !request('status')) ? 'border:2px solid var(--saffron);' : '' }}">
            <div class="stat-icon"><i class="{{ $s['icon'] }}"></i></div>
            <div>
                <div class="stat-number" style="font-size:1.4rem;">{{ $order_counts[$key] ?? 0 }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        </div>
    </a>
    @endforeach
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>📦 Orders</h3>
        <div class="inline-tools">
            <input type="text" placeholder="Search order # or customer..." class="form-control" style="width:250px;" id="searchInput">
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="ordersTable">
            @forelse($orders ?? [] as $order)
            <tr>
                <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                <td>
                    <div>{{ $order->user->name ?? $order->guest_name ?? 'Guest' }}</div>
                    <small style="color:#aaa;">{{ $order->user->phone ?? $order->guest_phone ?? '' }}</small>
                </td>
                <td>{{ $order->order_items_count ?? $order->items->count() ?? 0 }} items</td>
                <td><strong style="color:var(--saffron);">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                <td>
                    @if($order->order_type === 'delivery')
                        <span class="badge badge-info">🚚 Delivery</span>
                    @elseif($order->order_type === 'pickup')
                        <span class="badge badge-warning">🏪 Pickup</span>
                    @else
                        <span class="badge" style="background:#f3e5f5; color:#6a1b9a;">🪑 Dine-In</span>
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display:inline;" class="js-crud-ajax" data-loading="Updating order status..." data-success="Order status updated.">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="form-control" style="padding:0.3rem; font-size:0.8rem; width:130px; border-radius:6px;">
                            @foreach(['pending','processing','ready','completed','cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td style="font-size:0.82rem; color:#888;">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, h:i A') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline btn-sm js-crud-modal" data-modal-title="Order Details"><i class="fas fa-eye"></i></a>
                    @if($order->status === 'pending')
                    <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" style="display:inline;" class="js-crud-delete" data-confirm="Cancel this order?" data-success="Order cancelled successfully.">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#aaa; padding:2rem;">No orders found 📭</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $orders->links() ?? '' }}</div>
</div>

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#ordersTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush
@endsection
