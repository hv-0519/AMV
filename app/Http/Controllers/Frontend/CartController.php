<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * GET /cart
     * Return current cart summary as JSON.
     */
    public function index(Cart $cart)
    {
        return response()->json($cart->summary());
    }

    /**
     * POST /cart/add
     * Add item to cart or increment quantity.
     */
    public function add(Request $request, Cart $cart)
    {
        $request->validate([
            'menu_item_id' => 'required|integer|exists:menu_items,id',
            'quantity' => 'sometimes|integer|min:1|max:20',
        ]);

        Log::info('Cart add request received.', [
            'session_id' => $request->session()->getId(),
            'user_id' => $request->user()?->id,
            'payload' => $request->only(['menu_item_id', 'quantity']),
        ]);

        $cart->add(
            $request->menu_item_id,
            $request->input('quantity', 1)
        );

        $response = [
            'message' => 'Added to cart!',
            'cart' => $cart->summary(),
            'quantity' => $cart->quantityOf($request->menu_item_id),
        ];

        Log::info('Cart add response sent.', [
            'session_id' => $request->session()->getId(),
            'user_id' => $request->user()?->id,
            'response' => $response,
        ]);

        return response()->json($response);
    }

    /**
     * PATCH /cart/update
     * Set absolute quantity for an item.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'menu_item_id' => 'required|integer|exists:menu_items,id',
            'quantity' => 'required|integer|min:0|max:20',
        ]);

        $cart->update($request->menu_item_id, $request->quantity);

        return response()->json([
            'message' => 'Cart updated.',
            'cart' => $cart->summary(),
        ]);
    }

    /**
     * DELETE /cart/remove
     * Remove an item entirely.
     */
    public function remove(Request $request, Cart $cart)
    {
        $request->validate([
            'menu_item_id' => 'required|integer|exists:menu_items,id',
        ]);

        $cart->remove($request->menu_item_id);

        return response()->json([
            'message' => 'Item removed.',
            'cart' => $cart->summary(),
        ]);
    }

    /**
     * DELETE /cart/clear
     * Empty the entire cart.
     */
    public function clear(Cart $cart)
    {
        $cart->clear();

        return response()->json([
            'message' => 'Cart cleared.',
            'cart' => $cart->summary(),
        ]);
    }
}
