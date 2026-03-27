@extends('layouts.admin')
@section('title', 'Recommendation Pairings')

@push('styles')
<style>
    /* ── Page layout ── */
    .pairings-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    /* ── Category nav panel ── */
    .cat-nav {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
        position: sticky;
        top: 1.5rem;
    }
    .cat-nav-header {
        padding: 1rem 1.25rem 0.75rem;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: #9a7659;
        border-bottom: 1px solid #f0ebe3;
    }
    .cat-nav-item {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.7rem 1.25rem;
        cursor: pointer;
        font-size: 0.88rem;
        font-weight: 500;
        color: #4e3b2d;
        border-left: 3px solid transparent;
        transition: background 0.15s, border-color 0.15s, color 0.15s;
        text-decoration: none;
    }
    .cat-nav-item:hover   { background: #FFF3E0; }
    .cat-nav-item.active  { background: #FFF3E0; border-left-color: var(--saffron); color: var(--saffron); font-weight: 700; }
    .cat-nav-item .cat-count {
        margin-left: auto;
        background: #f0ebe3;
        color: #9a7659;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.1rem 0.5rem;
        border-radius: 20px;
    }
    .cat-nav-item.active .cat-count { background: rgba(255,107,0,0.15); color: var(--saffron); }

    /* ── Main panel ── */
    .pairing-category { display: none; }
    .pairing-category.active { display: block; }

    /* ── Item row ── */
    .item-row {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        margin-bottom: 1rem;
        overflow: hidden;
        border: 1px solid #f0ebe3;
    }
    .item-row-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.25rem;
        cursor: pointer;
        user-select: none;
    }
    .item-row-header:hover { background: #fffaf5; }
    .item-name {
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .item-meta { font-size: 0.75rem; color: #aaa; font-weight: 400; }
    .pairing-count-badge {
        font-size: 0.72rem;
        font-weight: 700;
        background: #FFF3E0;
        color: var(--saffron);
        border: 1.5px solid rgba(255,107,0,0.2);
        padding: 0.18rem 0.65rem;
        border-radius: 20px;
        white-space: nowrap;
    }
    .expand-arrow {
        color: #ccc;
        transition: transform 0.2s;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
    .item-row.expanded .expand-arrow { transform: rotate(180deg); }

    .item-row-body {
        display: none;
        padding: 0 1.25rem 1.25rem;
        border-top: 1px solid #f5f0ea;
    }
    .item-row.expanded .item-row-body { display: block; }

    /* ── Pairings list ── */
    .pairings-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-top: 0.85rem;
        min-height: 32px;
    }
    .pairing-chip {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.6rem 0.9rem;
        background: #fafafa;
        border: 1px solid #eee;
        border-radius: 10px;
        font-size: 0.85rem;
        transition: box-shadow 0.15s;
    }
    .pairing-chip.inactive { opacity: 0.45; }
    .pairing-chip .drag-handle {
        cursor: grab;
        color: #ccc;
        font-size: 0.8rem;
        flex-shrink: 0;
    }
    .pairing-chip .drag-handle:active { cursor: grabbing; }
    .pairing-chip .chip-name { flex: 1; font-weight: 600; color: #4e3b2d; }
    .pairing-chip .chip-cat  { font-size: 0.72rem; color: #aaa; }
    .pairing-chip .chip-price { font-size: 0.82rem; font-weight: 700; color: var(--saffron); white-space: nowrap; }

    .chip-actions { display: flex; gap: 0.4rem; flex-shrink: 0; }
    .chip-btn {
        width: 28px; height: 28px;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        font-size: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s, transform 0.15s;
    }
    .chip-btn:hover { transform: scale(1.08); }
    .chip-btn-toggle { background: #E8F5E9; color: #2E7D32; }
    .chip-btn-toggle.is-inactive { background: #FFF8E1; color: #F57F17; }
    .chip-btn-delete { background: #FFEBEE; color: #B22222; }

    /* ── Add pairing row ── */
    .add-pairing-row {
        display: flex;
        gap: 0.6rem;
        align-items: center;
        margin-top: 0.85rem;
        padding-top: 0.85rem;
        border-top: 1px dashed #eee;
    }
    .add-pairing-select {
        flex: 1;
        padding: 0.55rem 0.9rem;
        border: 1.5px solid #eee;
        border-radius: 10px;
        font-size: 0.85rem;
        font-family: 'Poppins', sans-serif;
        color: #4e3b2d;
        background: #fff;
        appearance: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .add-pairing-select:focus { outline: none; border-color: var(--saffron); }
    .add-pairing-btn {
        flex-shrink: 0;
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 0.55rem 1rem;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: background 0.2s, transform 0.15s;
    }
    .add-pairing-btn:hover { background: var(--deep-red); transform: translateY(-1px); }
    .add-pairing-btn:disabled { background: #ccc; cursor: not-allowed; transform: none; }

    .empty-pairings {
        font-size: 0.8rem;
        color: #bbb;
        text-align: center;
        padding: 0.75rem;
        font-style: italic;
    }

    /* ── Toast ── */
    #pairingToast {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        background: #1e1107;
        color: #fff;
        padding: 0.75rem 1.2rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        z-index: 9999;
        transform: translateY(12px);
        opacity: 0;
        transition: opacity 0.25s, transform 0.25s;
        pointer-events: none;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    #pairingToast.show { opacity: 1; transform: translateY(0); }
    #pairingToast.toast-success .toast-icon::before { content: '✅'; }
    #pairingToast.toast-error   .toast-icon::before { content: '❌'; }

    @media (max-width: 900px) {
        .pairings-layout { grid-template-columns: 1fr; }
        .cat-nav { position: static; display: flex; overflow-x: auto; border-radius: 10px; }
        .cat-nav-header { display: none; }
        .cat-nav-item { flex-shrink: 0; border-left: none; border-bottom: 3px solid transparent; }
        .cat-nav-item.active { border-bottom-color: var(--saffron); border-left-color: transparent; }
    }
</style>
@endpush

@section('content')

{{-- Page header --}}
<div class="data-card" style="margin-bottom:1.5rem;">
    <div class="data-card-header">
        <div>
            <h3>🔗 Recommendation Pairings</h3>
            <p style="font-size:0.8rem; color:#aaa; margin-top:0.2rem;">
                Manually define which items to recommend together. The system auto-learns from order history once enough data exists.
            </p>
        </div>
    </div>
</div>

<div class="pairings-layout">

    {{-- Category nav --}}
    <nav class="cat-nav" aria-label="Categories">
        <div class="cat-nav-header">Categories</div>
        @foreach($menu_items as $category => $items)
        @php
            $icons = ['Misal'=>'🍲','Vadapav'=>'🥙','Poha'=>'🌾','Beverages'=>'🥛','Thali'=>'🍱','Snacks'=>'🌮','Desserts'=>'🍮','Combos'=>'🎁'];
            $totalPairings = $items->sum(fn($i) => $i->pairings->count());
        @endphp
        <a class="cat-nav-item {{ $loop->first ? 'active' : '' }}"
           data-cat="{{ Str::slug($category) }}"
           href="#{{ Str::slug($category) }}">
            {{ $icons[$category] ?? '🍽️' }} {{ $category }}
            <span class="cat-count">{{ $totalPairings }}</span>
        </a>
        @endforeach
    </nav>

    {{-- Main content --}}
    <div id="pairingsMain">
        @foreach($menu_items as $category => $items)
        @php $allItems = $menu_items->flatten(); @endphp
        <div class="pairing-category {{ $loop->first ? 'active' : '' }}" id="{{ Str::slug($category) }}">
            @foreach($items as $item)
            <div class="item-row" id="item-row-{{ $item->id }}" data-item-id="{{ $item->id }}">
                <div class="item-row-header" onclick="toggleRow({{ $item->id }})">
                    <div class="item-name">
                        {{ $item->name }}
                        <span class="item-meta">₹{{ $item->price }}</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <span class="pairing-count-badge" id="badge-{{ $item->id }}">
                            {{ $item->pairings->count() }} {{ Str::plural('pairing', $item->pairings->count()) }}
                        </span>
                        <i class="fas fa-chevron-down expand-arrow"></i>
                    </div>
                </div>
                <div class="item-row-body">
                    {{-- Existing pairings --}}
                    <div class="pairings-list" id="pairings-list-{{ $item->id }}"
                         data-item-id="{{ $item->id }}">
                        @forelse($item->pairings as $pairing)
                        <div class="pairing-chip {{ $pairing->is_active ? '' : 'inactive' }}"
                             data-pairing-id="{{ $pairing->id }}"
                             draggable="true">
                            <i class="fas fa-grip-vertical drag-handle"></i>
                            <span class="chip-name">{{ $pairing->pairedItem->name }}</span>
                            <span class="chip-cat">{{ $pairing->pairedItem->category }}</span>
                            <span class="chip-price">₹{{ $pairing->pairedItem->price }}</span>
                            <div class="chip-actions">
                                <button class="chip-btn chip-btn-toggle {{ $pairing->is_active ? '' : 'is-inactive' }}"
                                        title="{{ $pairing->is_active ? 'Deactivate' : 'Activate' }}"
                                        onclick="togglePairing({{ $pairing->id }}, this)">
                                    <i class="fas {{ $pairing->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                </button>
                                <button class="chip-btn chip-btn-delete"
                                        title="Remove pairing"
                                        onclick="deletePairing({{ $pairing->id }}, {{ $item->id }}, this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @empty
                        <p class="empty-pairings" id="empty-{{ $item->id }}">No pairings yet — add one below.</p>
                        @endforelse
                    </div>

                    {{-- Add new pairing --}}
                    <div class="add-pairing-row">
                        <select class="add-pairing-select" id="select-{{ $item->id }}">
                            <option value="">— Select item to pair with —</option>
                            @foreach($allItems->where('id', '!=', $item->id) as $other)
                            <option value="{{ $other->id }}"
                                {{ $item->pairings->pluck('paired_item_id')->contains($other->id) ? 'disabled' : '' }}>
                                {{ $other->name }} ({{ $other->category }}) — ₹{{ $other->price }}
                            </option>
                            @endforeach
                        </select>
                        <button class="add-pairing-btn"
                                onclick="addPairing({{ $item->id }}, this)">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>

{{-- Toast --}}
<div id="pairingToast">
    <span class="toast-icon"></span>
    <span id="toastMsg"></span>
</div>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ── Collapse / expand ──────────────────────────────────────────
function toggleRow(itemId) {
    document.getElementById('item-row-' + itemId).classList.toggle('expanded');
}

// ── Category nav ──────────────────────────────────────────────
document.querySelectorAll('.cat-nav-item').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const cat = link.dataset.cat;

        document.querySelectorAll('.cat-nav-item').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.pairing-category').forEach(p => p.classList.remove('active'));

        link.classList.add('active');
        document.getElementById(cat).classList.add('active');

        // Collapse all rows when switching category
        document.querySelectorAll('.item-row').forEach(r => r.classList.remove('expanded'));
    });
});

// ── Add pairing ───────────────────────────────────────────────
async function addPairing(itemId, btn) {
    const select = document.getElementById('select-' + itemId);
    const pairedId = select.value;
    if (!pairedId) { showToast('Select an item first.', 'error'); return; }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    try {
        const res = await fetch('{{ route("admin.pairings.store") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ menu_item_id: itemId, paired_item_id: pairedId }),
        });
        const data = await res.json();

        if (!res.ok) { showToast(data.message || 'Error.', 'error'); return; }

        // Remove empty state
        const empty = document.getElementById('empty-' + itemId);
        if (empty) empty.remove();

        // Append chip to list
        const list = document.getElementById('pairings-list-' + itemId);
        list.insertAdjacentHTML('beforeend', buildChip(data.pairing));

        // Disable option in select
        select.querySelector(`option[value="${pairedId}"]`).disabled = true;
        select.value = '';

        // Update badge
        updateBadge(itemId);
        updateCatCount(itemId);

        showToast(data.message, 'success');
    } catch (err) {
        showToast('Something went wrong.', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plus"></i> Add';
    }
}

function buildChip(pairing) {
    const p = pairing.paired_item;
    return `
    <div class="pairing-chip" data-pairing-id="${pairing.id}" draggable="true">
        <i class="fas fa-grip-vertical drag-handle"></i>
        <span class="chip-name">${p.name}</span>
        <span class="chip-cat">${p.category}</span>
        <span class="chip-price">₹${p.price}</span>
        <div class="chip-actions">
            <button class="chip-btn chip-btn-toggle" title="Deactivate"
                    onclick="togglePairing(${pairing.id}, this)">
                <i class="fas fa-eye"></i>
            </button>
            <button class="chip-btn chip-btn-delete" title="Remove"
                    onclick="deletePairing(${pairing.id}, ${pairing.menu_item_id}, this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>`;
}

// ── Toggle active ─────────────────────────────────────────────
async function togglePairing(pairingId, btn) {
    try {
        const res = await fetch(`/admin/pairings/${pairingId}/toggle`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
        });
        const data = await res.json();
        if (!res.ok) { showToast(data.message, 'error'); return; }

        const chip = btn.closest('.pairing-chip');
        const icon = btn.querySelector('i');

        if (data.is_active) {
            chip.classList.remove('inactive');
            btn.classList.remove('is-inactive');
            btn.title = 'Deactivate';
            icon.className = 'fas fa-eye';
        } else {
            chip.classList.add('inactive');
            btn.classList.add('is-inactive');
            btn.title = 'Activate';
            icon.className = 'fas fa-eye-slash';
        }
        showToast(data.message, 'success');
    } catch {
        showToast('Something went wrong.', 'error');
    }
}

// ── Delete pairing ────────────────────────────────────────────
async function deletePairing(pairingId, itemId, btn) {
    if (!confirm('Remove this pairing?')) return;

    try {
        const res = await fetch(`/admin/pairings/${pairingId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF },
        });
        const data = await res.json();
        if (!res.ok) { showToast(data.message, 'error'); return; }

        const chip = btn.closest('.pairing-chip');

        // Re-enable the option in the select
        const pairedName = chip.querySelector('.chip-name').textContent.trim();
        const select = document.getElementById('select-' + itemId);
        select.querySelectorAll('option').forEach(opt => {
            if (opt.textContent.startsWith(pairedName)) opt.disabled = false;
        });

        chip.remove();

        // Show empty state if no chips left
        const list = document.getElementById('pairings-list-' + itemId);
        if (!list.querySelector('.pairing-chip')) {
            list.insertAdjacentHTML('beforeend',
                `<p class="empty-pairings" id="empty-${itemId}">No pairings yet — add one below.</p>`);
        }

        updateBadge(itemId);
        updateCatCount(itemId);
        showToast(data.message, 'success');
    } catch {
        showToast('Something went wrong.', 'error');
    }
}

// ── Badge helpers ─────────────────────────────────────────────
function updateBadge(itemId) {
    const list  = document.getElementById('pairings-list-' + itemId);
    const count = list.querySelectorAll('.pairing-chip').length;
    const badge = document.getElementById('badge-' + itemId);
    badge.textContent = count + (count === 1 ? ' pairing' : ' pairings');
}

function updateCatCount(itemId) {
    const row     = document.getElementById('item-row-' + itemId);
    const catDiv  = row.closest('.pairing-category');
    const total   = catDiv.querySelectorAll('.pairing-chip').length;
    const catSlug = catDiv.id;
    const navItem = document.querySelector(`.cat-nav-item[data-cat="${catSlug}"] .cat-count`);
    if (navItem) navItem.textContent = total;
}

// ── Drag-and-drop reorder ─────────────────────────────────────
let dragSrc = null;

document.addEventListener('dragstart', e => {
    const chip = e.target.closest('.pairing-chip');
    if (!chip) return;
    dragSrc = chip;
    chip.style.opacity = '0.4';
});

document.addEventListener('dragend', e => {
    const chip = e.target.closest('.pairing-chip');
    if (chip) chip.style.opacity = '';
    dragSrc = null;
});

document.addEventListener('dragover', e => {
    const chip = e.target.closest('.pairing-chip');
    if (!chip || chip === dragSrc) return;
    e.preventDefault();
    const list = chip.closest('.pairings-list');
    const chips = [...list.querySelectorAll('.pairing-chip')];
    const dragIdx = chips.indexOf(dragSrc);
    const overIdx = chips.indexOf(chip);
    if (dragIdx < overIdx) list.insertBefore(dragSrc, chip.nextSibling);
    else list.insertBefore(dragSrc, chip);
});

document.addEventListener('drop', async e => {
    e.preventDefault();
    if (!dragSrc) return;
    const list   = dragSrc.closest('.pairings-list');
    const itemId = list.dataset.itemId;
    const ids    = [...list.querySelectorAll('.pairing-chip')].map(c => +c.dataset.pairingId);

    await fetch('{{ route("admin.pairings.reorder") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ menu_item_id: +itemId, ordered_ids: ids }),
    });
});

// ── Toast ─────────────────────────────────────────────────────
let toastTimer;
function showToast(msg, type = 'success') {
    const toast = document.getElementById('pairingToast');
    document.getElementById('toastMsg').textContent = msg;
    toast.className = `show toast-${type}`;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}
</script>
@endpush
