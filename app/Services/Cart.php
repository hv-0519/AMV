<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Collection;

class Cart
{
    private const SESSION_KEY = 'mmv_cart';

    // -------------------------------------------------------------------------
    // PUBLIC API
    // -------------------------------------------------------------------------

    /**
     * Get all cart items as a Collection.
     * Each item: { id, name, category, price, image, quantity, subtotal }
     */
    public function items(): Collection
    {
        return collect(session(self::SESSION_KEY, []));
    }

    /**
     * Add an item or increment its quantity.
     */
    public function add(int $menuItemId, int $quantity = 1): void
    {
        $item = MenuItem::available()->findOrFail($menuItemId);
        $cart = session(self::SESSION_KEY, []);

        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] += $quantity;
            $cart[$menuItemId]['subtotal']  = $cart[$menuItemId]['quantity'] * $item->price;
        } else {
            $cart[$menuItemId] = [
                'id'       => $item->id,
                'name'     => $item->name,
                'category' => $item->category,
                'price'    => (float) $item->price,
                'image'    => $item->image,
                'quantity' => $quantity,
                'subtotal' => (float) $item->price * $quantity,
            ];
        }

        session([self::SESSION_KEY => $cart]);
    }

    /**
     * Set absolute quantity for an item. Removes if quantity <= 0.
     */
    public function update(int $menuItemId, int $quantity): void
    {
        $cart = session(self::SESSION_KEY, []);

        if ($quantity <= 0) {
            unset($cart[$menuItemId]);
        } elseif (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] = $quantity;
            $cart[$menuItemId]['subtotal'] = $cart[$menuItemId]['price'] * $quantity;
        }

        session([self::SESSION_KEY => $cart]);
    }

    /**
     * Remove a single item entirely.
     */
    public function remove(int $menuItemId): void
    {
        $cart = session(self::SESSION_KEY, []);
        unset($cart[$menuItemId]);
        session([self::SESSION_KEY => $cart]);
    }

    /**
     * Empty the cart.
     */
    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * Total number of individual items (sum of quantities).
     */
    public function count(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    /**
     * Subtotal before tax.
     */
    public function subtotal(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    /**
     * GST amount (5%).
     */
    public function tax(): float
    {
        return round($this->subtotal() * 0.05, 2);
    }

    /**
     * Grand total including tax.
     */
    public function total(): float
    {
        return round($this->subtotal() + $this->tax(), 2);
    }

    /**
     * True if cart has at least one item.
     */
    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    /**
     * Check if a specific item is in the cart.
     */
    public function has(int $menuItemId): bool
    {
        return isset(session(self::SESSION_KEY, [])[$menuItemId]);
    }

    /**
     * Get quantity of a specific item (0 if not in cart).
     */
    public function quantityOf(int $menuItemId): int
    {
        return session(self::SESSION_KEY, [])[$menuItemId]['quantity'] ?? 0;
    }

    /**
     * Summary array for JSON responses.
     */
    public function summary(): array
    {
        return [
            'count'    => $this->count(),
            'subtotal' => $this->subtotal(),
            'tax'      => $this->tax(),
            'total'    => $this->total(),
            'items'    => $this->items()->values()->toArray(),
        ];
    }
}
