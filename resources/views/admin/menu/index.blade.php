@extends('layouts.admin')
@section('title', 'Manage Menu')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>🍽️ All Menu Items</h3>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Item</a>
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
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= $item->spice_level ? '#FF6B00' : '#ddd' }}">🌶️</span>
                    @endfor
                </td>
                <td>
                    @if($item->is_available)
                        <span class="badge badge-success">Available</span>
                    @else
                        <span class="badge badge-danger">Unavailable</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.menu.edit', $item->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this item?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#aaa; padding:2rem;">No menu items found. <a href="{{ route('admin.menu.create') }}">Add one now →</a></td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
