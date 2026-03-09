@extends('layouts.admin')
@section('title', 'Restock — ' . $stock->name)

@section('content')
<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; max-width:900px; align-items:start;">

    <!-- Current Stock Info -->
    <div class="data-card">
        <div class="data-card-header">
            <h3>📦 {{ $stock->name }}</h3>
            <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>

        <div style="display:flex; flex-direction:column; gap:1rem;">
            <div style="background:#fff8ef; border-radius:12px; padding:1.2rem; text-align:center;">
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Current Stock</p>
                <p style="font-size:2.5rem; font-weight:900;
                    color:{{ $stock->isOut() ? 'var(--deep-red)' : ($stock->isLow() ? '#F57F17' : '#2E7D32') }};">
                    {{ $stock->quantity }}
                </p>
                <p style="color:#888; font-size:0.9rem;">{{ $stock->unit }}</p>
                @if($stock->isOut())
                    <span class="badge badge-danger" style="margin-top:0.5rem;">❌ Out of Stock</span>
                @elseif($stock->isLow())
                    <span class="badge badge-warning" style="margin-top:0.5rem;">⚠️ Low Stock</span>
                @else
                    <span class="badge badge-success" style="margin-top:0.5rem;">✅ In Stock</span>
                @endif
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.8rem;">
                <div style="background:#fff; border:1px solid #f0ebe3; border-radius:10px; padding:1rem; text-align:center;">
                    <p style="font-size:0.7rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.2rem;">Min Level</p>
                    <p style="font-size:1.2rem; font-weight:800; color:var(--dark);">{{ $stock->min_quantity }} <small style="font-size:0.75rem;">{{ $stock->unit }}</small></p>
                </div>
                <div style="background:#fff; border:1px solid #f0ebe3; border-radius:10px; padding:1rem; text-align:center;">
                    <p style="font-size:0.7rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.2rem;">Unit Cost</p>
                    <p style="font-size:1.2rem; font-weight:800; color:var(--saffron);">₹{{ number_format($stock->unit_cost, 2) }}</p>
                </div>
                <div style="background:#fff; border:1px solid #f0ebe3; border-radius:10px; padding:1rem; text-align:center;">
                    <p style="font-size:0.7rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.2rem;">Category</p>
                    <span class="badge badge-info">{{ $stock->category }}</span>
                </div>
                <div style="background:#fff; border:1px solid #f0ebe3; border-radius:10px; padding:1rem; text-align:center;">
                    <p style="font-size:0.7rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.2rem;">Stock Value</p>
                    <p style="font-size:1rem; font-weight:800; color:#2E7D32;">₹{{ number_format($stock->quantity * $stock->unit_cost, 2) }}</p>
                </div>
            </div>

            @if($stock->supplier)
            <div style="padding:0.8rem 1rem; background:#f8f4ef; border-radius:10px; font-size:0.88rem;">
                <strong>Supplier:</strong> {{ $stock->supplier }}
            </div>
            @endif
        </div>

        <!-- Recent Movements -->
        <div style="margin-top:1.5rem; padding-top:1rem; border-top:1px solid #f0ebe3;">
            <h4 style="font-size:0.9rem; font-weight:700; margin-bottom:0.8rem; color:#555;">Recent Movements</h4>
            @forelse($stock->movements()->latest()->take(5)->get() as $movement)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0; border-bottom:1px solid #f9f5f0; font-size:0.82rem;">
                <div>
                    <span style="color:{{ $movement->type === 'in' ? '#2E7D32' : 'var(--deep-red)' }}; font-weight:700;">
                        {{ $movement->type === 'in' ? '▲ +' : '▼ -' }}{{ $movement->quantity }} {{ $stock->unit }}
                    </span>
                    @if($movement->notes) <br><small style="color:#aaa;">{{ $movement->notes }}</small> @endif
                </div>
                <small style="color:#aaa;">{{ \Carbon\Carbon::parse($movement->created_at)->diffForHumans() }}</small>
            </div>
            @empty
            <p style="color:#aaa; font-size:0.85rem;">No movement history yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Restock Form -->
    <div class="data-card">
        <div class="data-card-header">
            <h3>➕ Add Stock</h3>
        </div>

        <form method="POST" action="{{ route('admin.stocks.processRestock', $stock->id) }}">
            @csrf

            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:block; font-size:0.85rem; font-weight:600; color:#444; margin-bottom:0.4rem;">
                    Quantity to Add * ({{ $stock->unit }})
                </label>
                <input type="number" name="quantity" step="0.01" min="0.01"
                       class="form-control @error('quantity') is-invalid @enderror"
                       placeholder="e.g. 20" id="restockQty" required autofocus>
                @error('quantity')<div style="color:var(--deep-red); font-size:0.75rem; margin-top:0.2rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Preview -->
            <div style="background:#fff8ef; border-radius:12px; padding:1.2rem; margin-bottom:1.5rem;">
                <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem; font-size:0.88rem;">
                    <span style="color:#666;">Current Stock</span>
                    <span style="font-weight:700;">{{ $stock->quantity }} {{ $stock->unit }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem; font-size:0.88rem;">
                    <span style="color:#2E7D32; font-weight:600;">Adding</span>
                    <span style="font-weight:700; color:#2E7D32;" id="addingQtyDisplay">+ 0 {{ $stock->unit }}</span>
                </div>
                <div style="border-top:1px dashed #e0d8cf; padding-top:0.5rem; display:flex; justify-content:space-between; font-size:1rem;">
                    <span style="font-weight:800;">New Total</span>
                    <span style="font-weight:900; color:var(--saffron);" id="newTotalDisplay">{{ $stock->quantity }} {{ $stock->unit }}</span>
                </div>
                <div style="margin-top:0.5rem; font-size:0.82rem; color:#888; display:flex; justify-content:space-between;">
                    <span>Restock Cost</span>
                    <span id="restockCostDisplay">₹0.00</span>
                </div>
            </div>

            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:block; font-size:0.85rem; font-weight:600; color:#444; margin-bottom:0.4rem;">
                    Notes / Reference
                </label>
                <textarea name="notes" class="form-control" rows="3"
                          placeholder="Invoice number, supplier name, or any notes..."></textarea>
            </div>

            <div style="display:flex; gap:0.8rem;">
                <button type="submit" class="btn btn-success" style="flex:1;">
                    <i class="fas fa-plus"></i> Confirm Restock
                </button>
                <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const currentQty = {{ $stock->quantity }};
    const unitCost = {{ $stock->unit_cost }};
    const unit = '{{ $stock->unit }}';

    document.getElementById('restockQty').addEventListener('input', function() {
        const adding = parseFloat(this.value) || 0;
        const newTotal = currentQty + adding;
        const cost = adding * unitCost;

        document.getElementById('addingQtyDisplay').textContent = '+ ' + adding + ' ' + unit;
        document.getElementById('newTotalDisplay').textContent = newTotal.toFixed(2) + ' ' + unit;
        document.getElementById('restockCostDisplay').textContent = '₹' + cost.toFixed(2);
    });
</script>
@endpush
@endsection
