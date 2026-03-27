@extends('layouts.admin')
@section('title', 'Manage Menu')

@push('styles')
<style>
    .spice-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.28rem;
    }
    .spice-emoji {
        font-size: 0.98rem;
        line-height: 1;
        transition: opacity 0.2s ease;
    }
    .spice-value {
        margin-left: 0.45rem;
        font-size: 0.78rem;
        font-weight: 700;
        color: #7a6250;
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>🍽️ All Menu Items</h3>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary js-crud-modal" data-modal-title="Add Menu Item"><i class="fas fa-plus"></i> Add New Item</a>
    </div>

    <!-- Filter Tabs -->
    <div style="display:flex; gap:0.5rem; margin-bottom:1.5rem; flex-wrap:wrap;">
        <a href="{{ route('admin.menu.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline' }}">All</a>
        @foreach(['Misal','Vadapav','Poha','Beverages','Thali','Snacks','Desserts'] as $cat)
        <a href="{{ route('admin.menu.index', ['category' => $cat]) }}" class="btn btn-sm {{ request('category') == $cat ? 'btn-primary' : 'btn-outline' }}">{{ $cat }}</a>
        @endforeach
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Category</th>
                <th>Price</th>
                <th>Spice Level</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menu_items ?? [] as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <div>
                        <strong>{{ $item->name }}</strong>
                        @if($item->is_bestseller) <span class="badge badge-warning" style="font-size:0.65rem;">⭐ Best Seller</span> @endif
                    </div>
                    <small style="color:#aaa;">{{ Str::limit($item->description, 50) }}</small>
                </td>
                <td><span class="badge badge-info">{{ $item->category }}</span></td>
                <td><strong style="color:var(--saffron);">₹{{ $item->price }}</strong></td>
                <td>
                    <div class="spice-indicator" aria-label="Spice level {{ (int) $item->spice_level }} out of 5">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="spice-emoji" style="opacity: {{ $i <= (int) $item->spice_level ? '1' : '0.2' }};">🌶️</span>
                        @endfor
                        <span class="spice-value">{{ (int) $item->spice_level }}/5</span>
                    </div>
                </td>
                <td>
                    @if($item->is_available)
                        <span class="badge badge-success">Available</span>
                    @else
                        <span class="badge badge-danger">Unavailable</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.menu.edit', $item->id) }}" class="btn btn-outline btn-sm js-crud-modal" data-modal-title="Edit Menu Item"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" style="display:inline" class="js-crud-delete" data-confirm="Delete this menu item?" data-success="Menu item deleted.">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#aaa; padding:2rem;">No menu items found. <a href="{{ route('admin.menu.create') }}" class="js-crud-modal" data-modal-title="Add Menu Item">Add one now →</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
