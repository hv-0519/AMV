<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\MenuItemPairing;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    /**
     * Minimum number of co-occurrences in order history
     * before a frequency-based result is trusted.
     * Below this threshold we fall back to manual pairings.
     */
    private const FREQUENCY_THRESHOLD = 2;

    /**
     * How many recommendations to return.
     */
    private const LIMIT = 3;

    // -------------------------------------------------------------------------
    // PUBLIC API
    // -------------------------------------------------------------------------

    /**
     * Get recommendations for a single menu item.
     * Used on: menu card tag, order confirmation page (per item).
     *
     * Strategy:
     *   1. Try frequency-based (co-occurrence in real orders)
     *   2. Fall back to admin-defined manual pairings
     *   3. Fall back to same-category bestsellers
     *
     * @param  int|MenuItem  $menuItem
     * @return Collection<MenuItem>
     */
    public function forItem(int|MenuItem $menuItem): Collection
    {
        $item = $menuItem instanceof MenuItem
            ? $menuItem
            : MenuItem::findOrFail($menuItem);

        // 1. Frequency-based
        $frequency = $this->frequencyBased($item->id);
        if ($frequency->count() >= 1) {
            return $frequency;
        }

        // 2. Manual pairings
        $manual = $this->manualPairings($item->id);
        if ($manual->count() >= 1) {
            return $manual;
        }

        // 3. Same-category fallback
        return $this->categoryFallback($item);
    }

    /**
     * Get recommendations for a whole order (multiple items).
     * Used on: order confirmation page summary.
     *
     * Aggregates co-occurrence scores across all ordered items,
     * excludes items already in the order, deduplicates, and returns
     * the top N by combined score.
     *
     * @param  array<int>  $orderedItemIds   Array of menu_item_id values
     * @return Collection<MenuItem>
     */
    public function forOrder(array $orderedItemIds): Collection
    {
        if (empty($orderedItemIds)) {
            return collect();
        }

        $orderedItemIds = array_unique($orderedItemIds);

        // Aggregate frequency scores across all items in the order
        $rows = DB::table('order_items as oi1')
            ->join('order_items as oi2', function ($join) {
                $join->on('oi1.order_id', '=', 'oi2.order_id')
                     ->whereColumn('oi1.menu_item_id', '!=', 'oi2.menu_item_id');
            })
            ->join('menu_items as mi', 'oi2.menu_item_id', '=', 'mi.id')
            ->whereIn('oi1.menu_item_id', $orderedItemIds)
            ->whereNotIn('oi2.menu_item_id', $orderedItemIds)
            ->where('mi.is_available', true)
            ->select('oi2.menu_item_id', DB::raw('COUNT(*) as score'))
            ->groupBy('oi2.menu_item_id')
            ->orderByDesc('score')
            ->limit(self::LIMIT)
            ->get();

        if ($rows->count() >= 1) {
            $ids    = $rows->pluck('menu_item_id');
            $scores = $rows->pluck('score', 'menu_item_id');

            return MenuItem::whereIn('id', $ids)
                ->where('is_available', true)
                ->get()
                ->sortByDesc(fn ($m) => $scores[$m->id] ?? 0)
                ->values();
        }

        // Fallback: collect manual pairings for all items, deduplicate
        return $this->manualPairingsForMany($orderedItemIds);
    }


    /**
     * Bulk recommendations for the menu page.
     * Returns array of menu_item_id => MenuItem|null (top 1 per item, 2 queries total).
     *
     * @param  array<int>  $itemIds
     * @return array<int, MenuItem|null>
     */
    public function forMany(array $itemIds): array
    {
        if (empty($itemIds)) return [];

        $manualRows = MenuItemPairing::with("pairedItem")
            ->whereIn("menu_item_id", $itemIds)
            ->where("is_active", true)
            ->orderBy("sort_order")
            ->get()
            ->groupBy("menu_item_id");

        $freqRows = DB::table("order_items as oi1")
            ->join("order_items as oi2", function ($join) {
                $join->on("oi1.order_id", "=", "oi2.order_id")
                     ->whereColumn("oi1.menu_item_id", "!=", "oi2.menu_item_id");
            })
            ->join("menu_items as mi", "oi2.menu_item_id", "=", "mi.id")
            ->whereIn("oi1.menu_item_id", $itemIds)
            ->where("mi.is_available", true)
            ->select("oi1.menu_item_id as source_id", "oi2.menu_item_id as rec_id", DB::raw("COUNT(*) as co_count"))
            ->groupBy("oi1.menu_item_id", "oi2.menu_item_id")
            ->havingRaw("COUNT(*) >= ?", [self::FREQUENCY_THRESHOLD])
            ->get()
            ->groupBy("source_id");

        $allRecIds = collect();
        foreach ($freqRows  as $recs)     { $allRecIds = $allRecIds->merge($recs->pluck("rec_id")); }
        foreach ($manualRows as $pairings) { $allRecIds = $allRecIds->merge($pairings->pluck("paired_item_id")); }

        $recItems = MenuItem::whereIn("id", $allRecIds->unique())
            ->where("is_available", true)
            ->get()->keyBy("id");

        $result = [];
        foreach ($itemIds as $id) {
            if (isset($freqRows[$id]) && $freqRows[$id]->isNotEmpty()) {
                $top = $freqRows[$id]->sortByDesc("co_count")->first();
                $result[$id] = $recItems[$top->rec_id] ?? null;
            } elseif (isset($manualRows[$id]) && $manualRows[$id]->isNotEmpty()) {
                $pairedId = $manualRows[$id]->first()->paired_item_id;
                $result[$id] = $recItems[$pairedId] ?? null;
            } else {
                $result[$id] = null;
            }
        }
        return $result;
    }
    // -------------------------------------------------------------------------
    // PRIVATE STRATEGIES
    // -------------------------------------------------------------------------

    /**
     * Co-occurrence query for a single item.
     * "Which items most often appear in the same order as this one?"
     */
    private function frequencyBased(int $itemId): Collection
    {
        $rows = DB::table('order_items as oi1')
            ->join('order_items as oi2', function ($join) {
                $join->on('oi1.order_id', '=', 'oi2.order_id')
                     ->whereColumn('oi1.menu_item_id', '!=', 'oi2.menu_item_id');
            })
            ->join('menu_items as mi', 'oi2.menu_item_id', '=', 'mi.id')
            ->where('oi1.menu_item_id', $itemId)
            ->where('mi.is_available', true)
            ->select('oi2.menu_item_id', DB::raw('COUNT(*) as co_count'))
            ->groupBy('oi2.menu_item_id')
            ->havingRaw('COUNT(*) >= ?', [self::FREQUENCY_THRESHOLD])
            ->orderByDesc('co_count')
            ->limit(self::LIMIT)
            ->get();

        if ($rows->isEmpty()) {
            return collect();
        }

        $ids    = $rows->pluck('menu_item_id');
        $counts = $rows->pluck('co_count', 'menu_item_id');

        return MenuItem::whereIn('id', $ids)
            ->where('is_available', true)
            ->get()
            ->sortByDesc(fn ($m) => $counts[$m->id] ?? 0)
            ->values();
    }

    /**
     * Admin-defined manual pairings for a single item.
     */
    private function manualPairings(int $itemId): Collection
    {
        return MenuItemPairing::with('pairedItem')
            ->where('menu_item_id', $itemId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(self::LIMIT)
            ->get()
            ->pluck('pairedItem')
            ->filter(fn ($item) => $item && $item->is_available)
            ->values();
    }

    /**
     * Manual pairings aggregated across multiple items (for order-level recs).
     * Deduplicates and excludes already-ordered items.
     */
    private function manualPairingsForMany(array $orderedItemIds): Collection
    {
        return MenuItemPairing::with('pairedItem')
            ->whereIn('menu_item_id', $orderedItemIds)
            ->whereNotIn('paired_item_id', $orderedItemIds)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->pluck('pairedItem')
            ->filter(fn ($item) => $item && $item->is_available)
            ->unique('id')
            ->take(self::LIMIT)
            ->values();
    }

    /**
     * Last resort: return available bestsellers from the same category,
     * excluding the item itself.
     */
    private function categoryFallback(MenuItem $item): Collection
    {
        return MenuItem::where('category', $item->category)
            ->where('id', '!=', $item->id)
            ->where('is_available', true)
            ->orderByDesc('is_bestseller')
            ->limit(self::LIMIT)
            ->get();
    }
}
