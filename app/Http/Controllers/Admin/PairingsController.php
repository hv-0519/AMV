<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuItemPairing;
use Illuminate\Http\Request;

class PairingsController extends Controller
{
    /**
     * Show all menu items with their current pairings.
     */
    public function index()
    {
        $menu_items = MenuItem::with([
                'pairings' => fn ($q) => $q->orderBy('sort_order')->with('pairedItem'),
            ])
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('admin.pairings.index', compact('menu_items'));
    }

    /**
     * Store a new pairing via AJAX (POST /admin/pairings).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id'  => 'required|exists:menu_items,id',
            'paired_item_id' => [
                'required',
                'exists:menu_items,id',
                // Cannot pair an item with itself
                function ($attr, $value, $fail) use ($request) {
                    if ((int) $value === (int) $request->menu_item_id) {
                        $fail('An item cannot be paired with itself.');
                    }
                },
            ],
        ]);

        // Check for duplicate (either direction is fine to allow — admin chooses)
        $exists = MenuItemPairing::where('menu_item_id',  $validated['menu_item_id'])
                                  ->where('paired_item_id', $validated['paired_item_id'])
                                  ->exists();

        if ($exists) {
            return response()->json(['message' => 'This pairing already exists.'], 422);
        }

        // Sort order = current max + 1 for this source item
        $nextSort = MenuItemPairing::where('menu_item_id', $validated['menu_item_id'])
                                    ->max('sort_order') + 1;

        $pairing = MenuItemPairing::create([
            'menu_item_id'   => $validated['menu_item_id'],
            'paired_item_id' => $validated['paired_item_id'],
            'sort_order'     => $nextSort,
            'is_active'      => true,
        ]);

        $pairing->load('pairedItem');

        return response()->json([
            'message' => 'Pairing added.',
            'pairing' => $pairing,
        ]);
    }

    /**
     * Toggle active/inactive on a pairing.
     */
    public function toggle(MenuItemPairing $pairing)
    {
        $pairing->update(['is_active' => ! $pairing->is_active]);

        return response()->json([
            'message'   => $pairing->is_active ? 'Pairing activated.' : 'Pairing deactivated.',
            'is_active' => $pairing->is_active,
        ]);
    }

    /**
     * Delete a pairing.
     */
    public function destroy(MenuItemPairing $pairing)
    {
        $pairing->delete();

        return response()->json(['message' => 'Pairing removed.']);
    }

    /**
     * Reorder pairings for a given source item (drag-and-drop save).
     * Expects: { menu_item_id, ordered_ids: [1, 4, 2] }
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'ordered_ids'  => 'required|array',
            'ordered_ids.*' => 'integer|exists:menu_item_pairings,id',
        ]);

        foreach ($request->ordered_ids as $index => $pairingId) {
            MenuItemPairing::where('id', $pairingId)
                ->where('menu_item_id', $request->menu_item_id) // security: only own pairings
                ->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order saved.']);
    }
}
