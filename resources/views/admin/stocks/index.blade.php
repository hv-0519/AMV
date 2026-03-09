@extends('layouts.admin')
@section('title', 'Stock Management')

@section('content')
<div style="display:grid; grid-template-columns:3fr 1fr; gap:1.5rem;">

    <!-- Stock Table -->
    <div class="data-card">
        <div class="data-card-header">
            <h3>📦 Inventory Items</h3>
            <a href="{{ route('admin.stocks.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Item</a>
        </div>

        <!-- Category Filter -->
        <div style="display:flex; gap:0.5rem; margin-bottom:1rem; flex-wrap:wrap;">
            @foreach(['All','Raw Materials','Spices','Dairy','Beverages','Packaging','Other'] as $cat)
            <a href="{{ route('admin.stocks.index', $cat !== 'All' ? ['category' => $cat] : []) }}"
               class="btn btn-sm {{ (request('category') == $cat || ($cat === 'All' && !request('category'))) ? 'btn-primary' : 'btn-outline' }}">
               {{ $cat }}
            </a>
            @endforeach
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Min. Level</th>
                    <th>Unit Cost</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks ?? [] as $stock)
                @php
                $status = $stock->quantity <= 0 ? 'out'
                    : ($stock->quantity <= $stock->min_quantity ? 'low' : 'ok');
                @endphp
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>
                        <strong>{{ $stock->name }}</strong>
                        @if($stock->supplier)<br><small style="color:#aaa;">Supplier: {{ $stock->supplier }}</small>@endif
                    </td>
                    <td><span class="badge badge-info" style="font-size:0.72rem;">{{ $stock->category }}</span></td>
                    <td>
                        <strong class="{{ $status === 'out' ? 'text-danger' : ($status === 'low' ? '' : '') }}"
                                style="{{ $status === 'out' ? 'color:var(--deep-red)' : ($status === 'low' ? 'color:#F57F17' : 'color:#2E7D32') }}">
                            {{ $stock->quantity }} {{ $stock->unit }}
                        </strong>
                    </td>
                    <td style="color:#888;">{{ $stock->min_quantity }} {{ $stock->unit }}</td>
                    <td>₹{{ number_format($stock->unit_cost, 2) }}</td>
                    <td>
                        @if($status === 'out')
                            <span class="badge badge-danger">Out of Stock</span>
                        @elseif($status === 'low')
                            <span class="badge badge-warning">⚠️ Low Stock</span>
                        @else
                            <span class="badge badge-success">In Stock</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.stocks.edit', $stock->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.stocks.restock', $stock->id) }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a>
                        <form action="{{ route('admin.stocks.destroy', $stock->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center; color:#aaa; padding:2rem;">No stock items. <a href="{{ route('admin.stocks.create') }}">Add one →</a></td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $stocks->links() ?? '' }}</div>
    </div>

    <!-- Right Panel -->
    <div>
        <!-- Summary -->
        <div class="data-card" style="margin-bottom:1rem;">
            <h3 style="font-size:1rem; margin-bottom:1rem;">📊 Stock Summary</h3>
            <div style="display:flex; flex-direction:column; gap:0.8rem;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:0.88rem; color:#666;">Total Items</span>
                    <strong>{{ $summary['total'] ?? 0 }}</strong>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:0.88rem; color:#2E7D32;">In Stock</span>
                    <strong style="color:#2E7D32;">{{ $summary['in_stock'] ?? 0 }}</strong>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:0.88rem; color:#F57F17;">Low Stock</span>
                    <strong style="color:#F57F17;">{{ $summary['low_stock'] ?? 0 }}</strong>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:0.88rem; color:var(--deep-red);">Out of Stock</span>
                    <strong style="color:var(--deep-red);">{{ $summary['out_of_stock'] ?? 0 }}</strong>
                </div>
                <hr style="border-color:#f0ebe3;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:0.88rem; color:#666;">Total Value</span>
                    <strong style="color:var(--saffron);">₹{{ number_format($summary['total_value'] ?? 0) }}</strong>
                </div>
            </div>
        </div>

        <!-- Recent Stock Movements -->
        <div class="data-card">
            <h3 style="font-size:1rem; margin-bottom:1rem;">📋 Recent Movements</h3>
            @forelse($recent_movements ?? [] as $movement)
            <div style="padding:0.6rem 0; border-bottom:1px solid #f0ebe3; font-size:0.82rem;">
                <div style="display:flex; justify-content:space-between;">
                    <span><strong>{{ $movement->stock->name ?? '' }}</strong></span>
                    <span style="color:{{ $movement->type === 'in' ? '#2E7D32' : 'var(--deep-red)' }}; font-weight:700;">
                        {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                    </span>
                </div>
                <span style="color:#aaa;">{{ \Carbon\Carbon::parse($movement->created_at)->diffForHumans() }}</span>
            </div>
            @empty
            <p style="color:#aaa; font-size:0.85rem; text-align:center;">No recent activity</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
