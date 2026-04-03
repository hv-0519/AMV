<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * GET /checkout
     * Show the checkout form with current cart contents.
     */
    public function index(Cart $cart)
    {
        if ($cart->count() === 0) {
            return redirect()->route('menu')
                ->with('error', 'Your cart is empty. Add some items first!')
                ->with('flash_modal', 'empty-cart');
        }

        return view('pages.checkout', [
            'cart_items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'tax' => $cart->tax(),
            'total' => $cart->total(),
        ]);
    }

    /**
     * POST /checkout
     * Place the order from cart contents.
     */
    public function store(Request $request, Cart $cart)
    {
        if ($cart->count() === 0) {
            return redirect()->route('menu')
                ->with('error', 'Your cart is empty.')
                ->with('flash_modal', 'empty-cart');
        }

        $request->validate([
            'order_type' => 'required|in:dine-in,pickup,delivery',
            'payment_method' => 'required|in:cash,card,upi,online',
            'delivery_address' => 'required_if:order_type,delivery|nullable|string|max:500',
            'notes' => 'nullable|string|max:300',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_type' => $request->order_type,
                'status' => 'pending',
                'total_amount' => $cart->total(),
                'tax_amount' => $cart->tax(),
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ]);

            foreach ($cart->items() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();
            $request->session()->put('last_tracked_order_id', $order->id);

            // Clear cart after successful order
            $cart->clear();

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Order placed successfully! 🎉 Dil Bole Wow!!')
                ->with('flash_modal', 'order-success');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }
}
