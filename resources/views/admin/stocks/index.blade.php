@extends('layouts.admin')
@section('title', 'Stock Management')

@section('content')
@push('styles')
<style>
    .stock-layout {
        display: grid;
        grid-template-columns: minmax(0, 3fr) minmax(280px, 1fr);
        gap: 1.5rem;
    }
    .stock-table-wrap {
        overflow-x: auto;
    }
    .stock-table-wrap table {
        min-width: 920px;
    }
    .stock-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .stock-action-group {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .stock-pagination {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f0ebe3;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
    }
    .stock-pagination-links {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-wrap: wrap;
    }
    .page-link {
        min-width: 2rem;
        height: 2rem;
        border-radius: 8px;
        border: 1px solid #e8ddd0;
        background: #fff;
        color: #5a4634;
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.65rem;
    }
    .page-link:hover {
        border-color: var(--saffron);
        color: var(--saffron);
    }
    .page-link.active {
        background: var(--saffron);
        border-color: var(--saffron);
        color: #fff;
    }
    .page-link.disabled {
        opacity: 0.45;
        pointer-events: none;
    }
    .stock-pagination-meta {
        color: #888;
        font-size: 0.82rem;
    }
    @media (max-width: 1200px) {
        .stock-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

<div class="stock-layout">

    <!-- Stock Table -->
    <div class="data-card">
        <div class="data-card-header">
            <h3>📦 Inventory Items</h3>
            <a href="{{ route('admin.stocks.create') }}" class="btn btn-primary js-crud-modal" data-modal-title="Add Stock Item"><i class="fas fa-plus"></i> Add Item</a>
        </div>

        <!-- Category Filter -->
        <div class="stock-filters">
            @foreach(['All','Raw Materials','Spices','Dairy','Beverages','Packaging','Other'] as $cat)
            <a href="{{ route('admin.stocks.index', $cat !== 'All' ? ['category' => $cat] : []) }}"
               class="btn btn-sm {{ (request('category') == $cat || ($cat === 'All' && !request('category'))) ? 'btn-primary' : 'btn-outline' }}">
               {{ $cat }}
            </a>
            @endforeach
        </div>

        <div class="stock-table-wrap">
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
                            <strong style="{{ $status === 'out' ? 'color:var(--deep-red)' : ($status === 'low' ? 'color:#F57F17' : 'color:#2E7D32') }}">
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
                            <div class="stock-action-group">
                                <a href="{{ route('admin.stocks.edit', $stock->id) }}" class="btn btn-outline btn-sm js-crud-modal" data-modal-title="Edit Stock Item" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.stocks.restock', $stock->id) }}" class="btn btn-success btn-sm js-crud-modal" data-modal-title="Restock Item" title="Restock">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <form action="{{ route('admin.stocks.destroy', $stock->id) }}" method="POST" class="js-crud-delete" data-confirm="Delete this stock item permanently?" data-success="Stock item deleted.">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center; color:#aaa; padding:2rem;">No stock items. <a href="{{ route('admin.stocks.create') }}" class="js-crud-modal" data-modal-title="Add Stock Item">Add one →</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(($stocks ?? null) && $stocks->hasPages())
            @php
                $startPage = max(1, $stocks->currentPage() - 2);
                $endPage = min($stocks->lastPage(), $stocks->currentPage() + 2);
            @endphp
            <nav class="stock-pagination" aria-label="Stock pagination">
                <div class="stock-pagination-links">
                    <a href="{{ $stocks->previousPageUrl() ?? '#' }}" class="page-link {{ $stocks->onFirstPage() ? 'disabled' : '' }}">
                        Prev
                    </a>
                    @foreach($stocks->getUrlRange($startPage, $endPage) as $page => $url)
                        <a href="{{ $url }}" class="page-link {{ $page === $stocks->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    <a href="{{ $stocks->nextPageUrl() ?? '#' }}" class="page-link {{ $stocks->hasMorePages() ? '' : 'disabled' }}">
                        Next
                    </a>
                </div>
                <div class="stock-pagination-meta">
                    Showing {{ $stocks->firstItem() ?? 0 }} to {{ $stocks->lastItem() ?? 0 }} of {{ $stocks->total() }} items
                </div>
            </nav>
        @endif
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
