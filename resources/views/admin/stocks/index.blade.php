@extends('layouts.admin')
@section('title', 'Stock Management')

@section('content')
@push('styles')
<style>
    .stock-layout {
        display: grid;
        grid-template-columns: minmax(0, 3fr) minmax(280px, 1fr);
        gap: 1.5rem;
        min-width: 0;
        width: 100%;
    }
    .stock-layout > * {
        min-width: 0;
    }
    .stock-table-wrap {
        overflow-x: auto;
        max-width: 100%;
        width: 100%;
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
    @media (max-width: 768px) {
        .stock-layout {
            display: block;
        }
        .stock-layout .data-card {
            max-width: 100%;
            overflow-x: hidden;
            padding: 1rem;
        }
        .stock-table-wrap table {
            min-width: 0;
            table-layout: fixed;
        }
        .stock-table-wrap th:nth-child(2),
        .stock-table-wrap td:nth-child(2) {
            width: 44%;
        }
        .stock-table-wrap th:nth-child(3),
        .stock-table-wrap td:nth-child(3) {
            width: 31%;
        }
        .stock-table-wrap th:nth-child(8),
        .stock-table-wrap td:nth-child(8) {
            width: 25%;
            text-align: right;
        }
        .stock-table-wrap .badge {
            max-width: 100%;
            white-space: normal;
            line-height: 1.25;
            text-align: center;
        }
        .stock-action-group {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }
        .stock-action-group .btn {
            width: 74px;
            padding-left: 0.6rem;
            padding-right: 0.6rem;
        }
    }
    @media (max-width: 480px) {
        .stock-layout .data-card {
            padding: 0.85rem;
        }
        .stock-table-wrap th,
        .stock-table-wrap td {
            padding: 0.75rem 0.55rem;
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

        <div class="stock-table-wrap table-responsive">
            <table class="mobile-essential-table">
                <thead>
                    <tr>
                        <th class="hide-mobile">#</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th class="hide-mobile">Quantity</th>
                        <th class="hide-mobile">Min. Level</th>
                        <th class="hide-mobile">Unit Cost</th>
                        <th class="hide-mobile">Status</th>
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
                        <td class="hide-mobile">{{ $stock->id }}</td>
                        <td>
                            <strong>{{ $stock->name }}</strong>
                            @if($stock->supplier)<br><small class="hide-mobile" style="color:#aaa;">Supplier: {{ $stock->supplier }}</small>@endif
                        </td>
                        <td><span class="badge badge-info" style="font-size:0.72rem;">{{ $stock->category }}</span></td>
                        <td class="hide-mobile">
                            <strong style="{{ $status === 'out' ? 'color:var(--deep-red)' : ($status === 'low' ? 'color:#F57F17' : 'color:#2E7D32') }}">
                                {{ $stock->quantity }} {{ $stock->unit }}
                            </strong>
                        </td>
                        <td class="hide-mobile" style="color:#888;">{{ $stock->min_quantity }} {{ $stock->unit }}</td>
                        <td class="hide-mobile">₹{{ number_format($stock->unit_cost, 2) }}</td>
                        <td class="hide-mobile">
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
                                <button type="button" class="btn btn-outline btn-sm" onclick="openModal(@js([
                                    'title' => $stock->name,
                                    'details' => [
                                        'ID' => (string) $stock->id,
                                        'Name' => $stock->name,
                                        'Category' => $stock->category,
                                        'Quantity' => $stock->quantity . ' ' . $stock->unit,
                                        'Minimum Level' => $stock->min_quantity . ' ' . $stock->unit,
                                        'Unit Cost' => '₹' . number_format($stock->unit_cost, 2),
                                        'Status' => $status === 'out' ? 'Out of Stock' : ($status === 'low' ? 'Low Stock' : 'In Stock'),
                                        'Supplier' => $stock->supplier ?: '—',
                                    ],
                                    'editUrl' => route('admin.stocks.edit', $stock->id),
                                    'restockUrl' => route('admin.stocks.restock', $stock->id),
                                    'deleteUrl' => route('admin.stocks.destroy', $stock->id),
                                    'deleteConfirm' => 'Delete this stock item permanently?',
                                    'deleteSuccess' => 'Stock item deleted.',
                                ]))"><i class="fas fa-eye"></i> View</button>
                                <a href="{{ route('admin.stocks.edit', $stock->id) }}" class="btn btn-outline btn-sm js-crud-modal hide-mobile" data-modal-title="Edit Stock Item" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.stocks.restock', $stock->id) }}" class="btn btn-success btn-sm js-crud-modal hide-mobile" data-modal-title="Restock Item" title="Restock">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <form action="{{ route('admin.stocks.destroy', $stock->id) }}" method="POST" class="js-crud-delete hide-mobile" data-confirm="Delete this stock item permanently?" data-success="Stock item deleted.">
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
        <a href="${escapeRowModalHtml(data.editUrl)}" class="btn btn-outline js-crud-modal" data-modal-title="Edit Stock Item" onclick="closeModal()"><i class="fas fa-edit"></i> Edit</a>
        <a href="${escapeRowModalHtml(data.restockUrl)}" class="btn btn-success js-crud-modal" data-modal-title="Restock Item" onclick="closeModal()"><i class="fas fa-plus"></i> Restock</a>
        <form action="${escapeRowModalHtml(data.deleteUrl)}" method="POST" class="js-crud-delete" data-confirm="${escapeRowModalHtml(data.deleteConfirm)}" data-success="${escapeRowModalHtml(data.deleteSuccess)}" onsubmit="closeModal()">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
        </form>
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
</script>
@endpush
@endsection
