@extends('layouts.admin')
@section('title', 'Best Sellers Showcase')

@section('content')
<div style="max-width:900px;">

    <div class="data-card-header" style="margin-bottom:1.5rem;">
        <div>
            <h2 style="font-size:1.3rem; font-weight:700; color:var(--dark);">⭐ Best Sellers Showcase</h2>
            <p style="color:#888; font-size:0.88rem; margin-top:0.3rem;">Manage the auto-scrolling carousel shown in the "Fan Favourites" section on the home page.</p>
        </div>
    </div>

    {{-- ── Carousel Speed ── --}}
    <div class="data-card" style="padding:1.5rem; margin-bottom:1.5rem;">
        <h3 style="font-size:1rem; font-weight:700; color:var(--dark); margin-bottom:1rem;">⏱️ Carousel Speed</h3>
        <form method="POST" action="{{ route('admin.best-sellers.interval') }}" style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
            @csrf
            <div style="display:flex; align-items:center; gap:0.8rem;">
                <label style="font-size:0.88rem; font-weight:600; color:#555;">Auto-scroll every</label>
                <input type="number" name="carousel_interval" value="{{ $interval }}" min="1" max="30"
                       style="width:80px; border:2px solid #ddd; border-radius:8px; padding:0.4rem 0.6rem; font-size:0.95rem; text-align:center;">
                <span style="font-size:0.88rem; color:#666;">seconds</span>
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Save Speed</button>
        </form>
    </div>

    {{-- ── Add New Item ── --}}
    <div class="data-card" style="padding:1.5rem; margin-bottom:1.5rem;">
        <h3 style="font-size:1rem; font-weight:700; color:var(--dark); margin-bottom:1rem;">➕ Add New Item</h3>
        <form method="POST" action="{{ route('admin.best-sellers.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="font-size:0.82rem; font-weight:600; color:#555; display:block; margin-bottom:0.3rem;">Dish Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Mumbaiya Misal Pav"
                           style="width:100%; border:2px solid #ddd; border-radius:8px; padding:0.5rem 0.8rem; font-size:0.9rem;">
                </div>
                <div>
                    <label style="font-size:0.82rem; font-weight:600; color:#555; display:block; margin-bottom:0.3rem;">Short Tag / Label</label>
                    <input type="text" name="tag" placeholder="e.g. SABKA BHAU"
                           style="width:100%; border:2px solid #ddd; border-radius:8px; padding:0.5rem 0.8rem; font-size:0.9rem;">
                </div>
                <div>
                    <label style="font-size:0.82rem; font-weight:600; color:#555; display:block; margin-bottom:0.3rem;">Rating (1-5) *</label>
                    <input type="number" name="rating" step="0.1" min="1" max="5" value="4.5" required
                           style="width:100%; border:2px solid #ddd; border-radius:8px; padding:0.5rem 0.8rem; font-size:0.9rem;">
                </div>
                <div>
                    <label style="font-size:0.82rem; font-weight:600; color:#555; display:block; margin-bottom:0.3rem;">Image (no background PNG recommended) *</label>
                    <input type="file" name="image" accept="image/*" required
                           style="width:100%; border:2px solid #ddd; border-radius:8px; padding:0.4rem 0.6rem; font-size:0.82rem;">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add to Showcase</button>
        </form>
    </div>

    {{-- ── Current Items ── --}}
    <div class="data-card" style="padding:1.5rem;">
        <h3 style="font-size:1rem; font-weight:700; color:var(--dark); margin-bottom:1rem;">📋 Current Items ({{ $items->count() }})</h3>
        @forelse($items as $item)
        <div style="display:flex; gap:1rem; align-items:center; padding:1rem 0; border-bottom:1px solid #f0ebe3; flex-wrap:wrap;">

            {{-- Image preview --}}
            <div style="width:80px; height:80px; background:#f5f0ea; border-radius:10px; flex-shrink:0; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" style="max-height:80px; max-width:80px; object-fit:contain;">
                @else
                    <i class="fas fa-image" style="color:#ccc; font-size:1.5rem;"></i>
                @endif
            </div>

            {{-- Info + edit form --}}
            <form method="POST" action="{{ route('admin.best-sellers.update', $item->id) }}" enctype="multipart/form-data" style="flex:1; min-width:260px;">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem; margin-bottom:0.5rem;">
                    <input type="text" name="name" value="{{ $item->name }}" required placeholder="Dish Name"
                           style="border:1.5px solid #ddd; border-radius:6px; padding:0.3rem 0.6rem; font-size:0.85rem;">
                    <input type="text" name="tag" value="{{ $item->tag }}" placeholder="Short Tag"
                           style="border:1.5px solid #ddd; border-radius:6px; padding:0.3rem 0.6rem; font-size:0.85rem;">
                    <input type="number" name="rating" step="0.1" min="1" max="5" value="{{ $item->rating }}" required
                           style="border:1.5px solid #ddd; border-radius:6px; padding:0.3rem 0.6rem; font-size:0.85rem;">
                    <input type="file" name="image" accept="image/*"
                           style="border:1.5px solid #ddd; border-radius:6px; padding:0.2rem 0.4rem; font-size:0.78rem;">
                </div>
                <button type="submit" class="btn btn-sm" style="background:#f0f0f0; color:#333; border:1.5px solid #ddd;">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>

            {{-- Actions --}}
            <div style="display:flex; flex-direction:column; gap:0.4rem;">
                <form method="POST" action="{{ route('admin.best-sellers.toggle', $item->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm"
                            style="background:{{ $item->is_active ? '#e8f5e9' : '#fff3e0' }}; color:{{ $item->is_active ? '#2e7d32' : '#e65100' }}; border:1.5px solid {{ $item->is_active ? '#a5d6a7' : '#ffcc80' }}; width:90px;">
                        {{ $item->is_active ? '✅ Active' : '⏸ Hidden' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.best-sellers.destroy', $item->id) }}" onsubmit="return confirm('Remove this item?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm" style="background:#ffebee; color:#c62828; border:1.5px solid #ef9a9a; width:90px;">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p style="color:#aaa; text-align:center; padding:2rem 0;">No items yet. Add your first best seller above! ☝️</p>
        @endforelse
    </div>

</div>
@endsection
