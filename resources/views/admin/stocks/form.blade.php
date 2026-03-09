@extends('layouts.admin')
@section('title', isset($stock) ? 'Edit Stock Item' : 'Add Stock Item')

@section('content')
<div class="data-card" style="max-width:750px;">
    <div class="data-card-header">
        <h3>{{ isset($stock) ? '✏️ Edit Stock Item' : '➕ Add New Stock Item' }}</h3>
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline btn-sm">← Back to Stocks</a>
    </div>

    <form method="POST" action="{{ isset($stock) ? route('admin.stocks.update', $stock->id) : route('admin.stocks.store') }}">
        @csrf
        @if(isset($stock)) @method('PUT') @endif

        <div class="form-grid">
            <div class="form-group">
                <label>Item Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $stock->name ?? '') }}"
                       placeholder="e.g. Sprouted Moth Beans" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Category *</label>
                <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach(['Raw Materials','Spices','Dairy','Beverages','Packaging','Other'] as $cat)
                    <option value="{{ $cat }}" {{ old('category', $stock->category ?? '') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                    @endforeach
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Current Quantity *</label>
                <input type="number" name="quantity" step="0.01" min="0"
                       class="form-control @error('quantity') is-invalid @enderror"
                       value="{{ old('quantity', $stock->quantity ?? '') }}"
                       placeholder="e.g. 25" required>
                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Unit *</label>
                <select name="unit" class="form-control @error('unit') is-invalid @enderror" required>
                    <option value="">Select Unit</option>
                    @foreach(['kg','g','litre','ml','pcs','dozen','box','bag','bottle','packet'] as $unit)
                    <option value="{{ $unit }}" {{ old('unit', $stock->unit ?? '') == $unit ? 'selected' : '' }}>
                        {{ $unit }}
                    </option>
                    @endforeach
                </select>
                @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Minimum Stock Level *
                    <small style="color:#aaa; font-weight:400;">(alert threshold)</small>
                </label>
                <input type="number" name="min_quantity" step="0.01" min="0"
                       class="form-control @error('min_quantity') is-invalid @enderror"
                       value="{{ old('min_quantity', $stock->min_quantity ?? '') }}"
                       placeholder="e.g. 5" required>
                @error('min_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Unit Cost (₹) *</label>
                <input type="number" name="unit_cost" step="0.01" min="0"
                       class="form-control @error('unit_cost') is-invalid @enderror"
                       value="{{ old('unit_cost', $stock->unit_cost ?? '') }}"
                       placeholder="e.g. 80.00" required>
                @error('unit_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Supplier / Vendor Name</label>
            <input type="text" name="supplier" class="form-control"
                   value="{{ old('supplier', $stock->supplier ?? '') }}"
                   placeholder="e.g. Mumbai Agro Suppliers">
        </div>

        <div class="form-group">
            <label>Notes / Description</label>
            <textarea name="notes" class="form-control" rows="3"
                      placeholder="Any notes about storage, handling, or specifications...">{{ old('notes', $stock->notes ?? '') }}</textarea>
        </div>

        <!-- Value Preview -->
        <div style="background:#fff8ef; border-radius:12px; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; gap:2rem; flex-wrap:wrap;">
            <div>
                <p style="font-size:0.75rem; color:#aaa; font-weight:700; text-transform:uppercase;">Total Value</p>
                <p style="font-size:1.2rem; font-weight:800; color:var(--saffron);" id="totalValue">₹0.00</p>
            </div>
            <div>
                <p style="font-size:0.75rem; color:#aaa; font-weight:700; text-transform:uppercase;">Stock Status</p>
                <p style="font-size:0.9rem; font-weight:600;" id="stockStatus">—</p>
            </div>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{ isset($stock) ? 'Update Stock Item' : 'Add to Inventory' }}
            </button>
            <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updatePreview() {
        const qty = parseFloat(document.querySelector('[name=quantity]').value) || 0;
        const cost = parseFloat(document.querySelector('[name=unit_cost]').value) || 0;
        const min = parseFloat(document.querySelector('[name=min_quantity]').value) || 0;
        const total = qty * cost;

        document.getElementById('totalValue').textContent = '₹' + total.toFixed(2);

        const statusEl = document.getElementById('stockStatus');
        if (qty <= 0) { statusEl.textContent = '❌ Out of Stock'; statusEl.style.color = 'var(--deep-red)'; }
        else if (qty <= min) { statusEl.textContent = '⚠️ Low Stock'; statusEl.style.color = '#F57F17'; }
        else { statusEl.textContent = '✅ In Stock'; statusEl.style.color = '#2E7D32'; }
    }

    document.querySelectorAll('[name=quantity],[name=unit_cost],[name=min_quantity]')
        .forEach(el => el.addEventListener('input', updatePreview));

    updatePreview();
</script>
@endpush
@endsection
