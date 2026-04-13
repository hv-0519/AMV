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
    <div class="table-responsive">
    <table class="mobile-essential-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th class="hide-mobile">Items</th>
                <th class="hide-mobile">Total</th>
                <th class="hide-mobile">Type</th>
                <th class="hide-mobile">Status</th>
                <th class="hide-mobile">Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="ordersTable">
            @forelse($orders ?? [] as $order)
            <tr>
                <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                <td>
                    <div>{{ $order->user->name ?? $order->guest_name ?? 'Guest' }}</div>
                    <small class="hide-mobile" style="color:#aaa;">{{ $order->user->phone ?? $order->guest_phone ?? '' }}</small>
                </td>
                <td class="hide-mobile">{{ $order->order_items_count ?? $order->items->count() ?? 0 }} items</td>
                <td class="hide-mobile"><strong style="color:var(--saffron);">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                <td class="hide-mobile">
                    @if($order->order_type === 'delivery')
                        <span class="badge badge-info">🚚 Delivery</span>
                    @elseif($order->order_type === 'pickup')
                        <span class="badge badge-warning">🏪 Pickup</span>
                    @else
                        <span class="badge" style="background:#f3e5f5; color:#6a1b9a;">🪑 Dine-In</span>
                    @endif
                </td>
                <td class="hide-mobile">
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
                <td class="hide-mobile" style="font-size:0.82rem; color:#888;">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, h:i A') }}</td>
                <td>
                    <button type="button" class="btn btn-outline btn-sm" onclick="openModal(@js([
                        'title' => 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                        'details' => [
                            'Order #' => '#' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                            'Customer' => $order->user->name ?? $order->guest_name ?? 'Guest',
                            'Phone' => $order->user->phone ?? $order->guest_phone ?? '—',
                            'Items' => ($order->order_items_count ?? $order->items->count() ?? 0) . ' items',
                            'Total' => '₹' . number_format($order->total_amount, 2),
                            'Type' => ucfirst($order->order_type),
                            'Status' => ucfirst($order->status),
                            'Payment' => ucfirst($order->payment_status ?? 'pending'),
                            'Date' => \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A'),
                        ],
                        'showUrl' => route('admin.orders.show', $order->id),
                        'deleteUrl' => route('admin.orders.destroy', $order->id),
                        'canDelete' => $order->status === 'pending',
                        'deleteConfirm' => 'Cancel this order?',
                        'deleteSuccess' => 'Order cancelled successfully.',
                    ]))"><i class="fas fa-eye"></i> View</button>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline btn-sm js-crud-modal hide-mobile" data-modal-title="Order Details"><i class="fas fa-eye"></i></a>
                    @if($order->status === 'pending')
                    <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" style="display:inline;" class="js-crud-delete hide-mobile" data-confirm="Cancel this order?" data-success="Order cancelled successfully.">
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
    </div>
    <div style="margin-top:1rem;">{{ $orders->links() ?? '' }}</div>
</div>

<div id="rowModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; overflow-y:auto;">
    <div class="row-modal-panel" style="background:#fff; margin:20px; border-radius:16px; padding:24px; position:relative;">
        <button type="button" onclick="closeModal()" aria-label="Close details" style="position:absolute; top:12px; right:12px; width:36px; height:36px; border:1px solid #eaded2; border-radius:8px; background:#fff; cursor:pointer;">✕</button>
        <div id="modalContent"></div>
        <div id="modalActions" class="row-modal-actions"></div>
    </div>
</div>

@push('scripts')
<script>
function escapeRowModalHtml(value) {
    const element = document.createElement('div');
    element.textContent = value ?? '';
    return element.innerHTML;
}

function openModal(data) {
    const modal = document.getElementById('rowModal');
    const content = document.getElementById('modalContent');
    const actions = document.getElementById('modalActions');
    const deleteAction = data.canDelete ? `
        <form action="${escapeRowModalHtml(data.deleteUrl)}" method="POST" class="js-crud-delete" data-confirm="${escapeRowModalHtml(data.deleteConfirm)}" data-success="${escapeRowModalHtml(data.deleteSuccess)}" onsubmit="closeModal()">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Cancel Order</button>
        </form>
    ` : '';

    content.innerHTML = `
        <h3 style="margin:0 2.5rem 1rem 0; color:var(--dark);">${escapeRowModalHtml(data.title || 'Details')}</h3>
        <div class="row-modal-detail">
            ${Object.entries(data.details || {}).map(([label, value]) => `
                <div class="row-modal-detail-row">
                    <div class="row-modal-label">${escapeRowModalHtml(label)}</div>
                    <div class="row-modal-value">${escapeRowModalHtml(value)}</div>
                </div>
            `).join('')}
        </div>
    `;
    actions.innerHTML = `
        <a href="${escapeRowModalHtml(data.showUrl)}" class="btn btn-outline js-crud-modal" data-modal-title="Order Details" onclick="closeModal()"><i class="fas fa-edit"></i> Edit Status</a>
        ${deleteAction}
    `;
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('rowModal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('rowModal')?.addEventListener('click', (event) => {
    if (event.target.id === 'rowModal') {
        closeModal();
    }
});

document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#ordersTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush
@endsection
