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
    .menu-row-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        flex-wrap: wrap;
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

    <div class="table-responsive">
    <table class="mobile-essential-table">
        <thead>
            <tr>
                <th class="hide-mobile">#</th>
                <th>Item</th>
                <th class="hide-mobile">Category</th>
                <th class="hide-mobile">Price</th>
                <th class="hide-mobile">Spice Level</th>
                <th class="hide-mobile">Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menu_items ?? [] as $item)
            <tr>
                <td class="hide-mobile">{{ $item->id }}</td>
                <td>
                    <div>
                        <strong>{{ $item->name }}</strong>
                        @if($item->is_bestseller) <span class="badge badge-warning hide-mobile" style="font-size:0.65rem;">⭐ Best Seller</span> @endif
                    </div>
                    <small class="hide-mobile" style="color:#aaa;">{{ Str::limit($item->description, 50) }}</small>
                </td>
                <td class="hide-mobile"><span class="badge badge-info">{{ $item->category }}</span></td>
                <td class="hide-mobile"><strong style="color:var(--saffron);">₹{{ $item->price }}</strong></td>
                <td class="hide-mobile">
                    <div class="spice-indicator" aria-label="Spice level {{ (int) $item->spice_level }} out of 5">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="spice-emoji" style="opacity: {{ $i <= (int) $item->spice_level ? '1' : '0.2' }};">🌶️</span>
                        @endfor
                        <span class="spice-value">{{ (int) $item->spice_level }}/5</span>
                    </div>
                </td>
                <td class="hide-mobile">
                    @if($item->is_available)
                        <span class="badge badge-success">Available</span>
                    @else
                        <span class="badge badge-danger">Unavailable</span>
                    @endif
                </td>
                <td>
                    <div class="menu-row-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="openModal(@js([
                            'title' => $item->name,
                            'details' => [
                                'ID' => (string) $item->id,
                                'Name' => $item->name,
                                'Description' => $item->description ?: '—',
                                'Category' => $item->category,
                                'Price' => '₹' . $item->price,
                                'Spice Level' => ((int) $item->spice_level) . '/5',
                                'Status' => $item->is_available ? 'Available' : 'Unavailable',
                                'Best Seller' => $item->is_bestseller ? 'Yes' : 'No',
                            ],
                            'editUrl' => route('admin.menu.edit', $item->id),
                            'deleteUrl' => route('admin.menu.destroy', $item->id),
                            'deleteConfirm' => 'Delete this menu item?',
                            'deleteSuccess' => 'Menu item deleted.',
                        ]))"><i class="fas fa-eye"></i> View</button>
                        <a href="{{ route('admin.menu.edit', $item->id) }}" class="btn btn-outline btn-sm js-crud-modal hide-mobile" data-modal-title="Edit Menu Item"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" style="display:inline" class="js-crud-delete hide-mobile" data-confirm="Delete this menu item?" data-success="Menu item deleted.">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#aaa; padding:2rem;">No menu items found. <a href="{{ route('admin.menu.create') }}" class="js-crud-modal" data-modal-title="Add Menu Item">Add one now →</a></td></tr>
            @endforelse
        </tbody>
    </table>
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
        <a href="${escapeRowModalHtml(data.editUrl)}" class="btn btn-outline js-crud-modal" data-modal-title="Edit Menu Item" onclick="closeModal()"><i class="fas fa-edit"></i> Edit</a>
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
