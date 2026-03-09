@extends('layouts.admin')
@section('title', 'User — ' . $user->name)

@section('content')
<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; align-items:start;">

    <!-- User Details & Orders -->
    <div>
        <div class="data-card" style="margin-bottom:1.5rem;">
            <div class="data-card-header">
                <h3>👤 {{ $user->name }}</h3>
                <div style="display:flex; gap:0.5rem;">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">← Back</a>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Email</p>
                    <p>{{ $user->email }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Phone</p>
                    <p>{{ $user->phone ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Role</p>
                    <p><span class="badge {{ $user->role === 'staff' ? 'badge-warning' : 'badge-info' }}">{{ ucfirst($user->role) }}</span></p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Joined</p>
                    <p style="font-size:0.9rem;">{{ $user->created_at->format('d M Y') }}</p>
                </div>
                @if($user->address)
                <div style="grid-column:1/-1;">
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Address</p>
                    <p>📍 {{ $user->address }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="data-card">
            <div class="data-card-header">
                <h3>📦 Recent Orders ({{ $user->orders_count }})</h3>
                <strong style="color:var(--saffron);">Total Spent: ₹{{ number_format($total_spent, 2) }}</strong>
            </div>
            @if($user->orders->count())
            <table>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Total</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->orders as $order)
                    <tr>
                        <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td style="color:var(--saffron); font-weight:700;">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="badge badge-info">{{ ucfirst($order->order_type) }}</span></td>
                        <td>
                            @php $badge = match($order->status) { 'completed'=>'badge-success', 'cancelled'=>'badge-danger', 'pending'=>'badge-warning', default=>'badge-info' }; @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td style="font-size:0.82rem; color:#888;">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align:center; color:#aaa; padding:2rem;">No orders yet.</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="data-card">
        <h3 style="font-size:1rem; margin-bottom:1.2rem;">⚡ Quick Actions</h3>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary" style="width:100%; margin-bottom:0.7rem; display:block; text-align:center;">
            <i class="fas fa-edit"></i> Edit User
        </a>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user permanently?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width:100%;">
                <i class="fas fa-trash"></i> Delete User
            </button>
        </form>
    </div>
</div>
@endsection
