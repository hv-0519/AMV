@extends('layouts.admin')
@section('title', isset($menu_item) ? 'Edit Menu Item' : 'Add Menu Item')

@section('content')
<div class="data-card" style="max-width:800px;">
    <div class="data-card-header">
        <h3>{{ isset($menu_item) ? '✏️ Edit Menu Item' : '➕ Add New Menu Item' }}</h3>
        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline btn-sm">← Back to Menu</a>
    </div>

    <form method="POST" action="{{ isset($menu_item) ? route('admin.menu.update', $menu_item->id) : route('admin.menu.store') }}" enctype="multipart/form-data" class="js-crud-ajax" data-loading="{{ isset($menu_item) ? 'Updating menu item...' : 'Adding menu item...' }}" data-success="{{ isset($menu_item) ? 'Menu item updated.' : 'Menu item added.' }}">
        @csrf
        @if(isset($menu_item)) @method('PUT') @endif

        <div class="form-grid">
            <div class="form-group">
                <label>Item Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $menu_item->name ?? '') }}" placeholder="e.g., Amdavadi Misal Pav" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Category *</label>
                <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach(['Misal','Vadapav','Poha','Beverages','Thali','Snacks','Desserts','Combos'] as $cat)
                    <option value="{{ $cat }}" {{ old('category', $menu_item->category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Price (₹) *</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $menu_item->price ?? '') }}" placeholder="120" min="1" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Spice Level (1-5)</label>
                <select name="spice_level" class="form-control">
                    @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('spice_level', $menu_item->spice_level ?? 2) == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Mild','Medium','Spicy','Very Spicy','Extra Hot'][$i-1] }}
                    </option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                      rows="3" placeholder="Describe the dish — ingredients, taste, serving size..." required>{{ old('description', $menu_item->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Ingredients (comma-separated)</label>
            <input type="text" name="ingredients" class="form-control"
                   value="{{ old('ingredients', $menu_item->ingredients ?? '') }}"
                   placeholder="Sprouted moth beans, Farsan, Pav, Onions, Coriander">
        </div>

        <div class="form-group">
            <label>Item Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @if(isset($menu_item) && $menu_item->image)
                
            @endif
        </div>

        <div style="display:flex; gap:2rem; margin-bottom:1.5rem; flex-wrap:wrap;">
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.9rem; font-weight:600;">
                <input type="checkbox" name="is_available" value="1" {{ old('is_available', $menu_item->is_available ?? true) ? 'checked' : '' }} style="accent-color:var(--saffron);">
                Currently Available
            </label>
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.9rem; font-weight:600;">
                <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $menu_item->is_bestseller ?? false) ? 'checked' : '' }} style="accent-color:var(--saffron);">
                Mark as Best Seller ⭐
            </label>
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.9rem; font-weight:600;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $menu_item->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--saffron);">
                Featured on Homepage
            </label>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{ isset($menu_item) ? 'Update Item' : 'Add to Menu' }}
            </button>
            <a href="{{ route('admin.menu.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
