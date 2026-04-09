<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected function redirectAfterOrderCreation(Order $order): RedirectResponse
    {
        return $order->shouldRedirectToPaymentAfterCheckout()
            ? redirect()->route('payment.show', $order->id)
            : redirect()->route('order.confirmation', $order);
    }

    /**
     * GET /checkout
     * Show the checkout form with current cart contents.
     */
    public function index(Cart $cart)
    {
        $cart = session('cart', session('AMV_cart', []));
        if (empty($cart)) {
            return redirect()->route('menu')->with('info', 'Your cart is empty.');
        }

        try {
            $cartItems = collect($cart)->map(function ($item): array {
                $cartItem = is_array($item) ? $item : [];

                return [
                    'id' => (int) ($cartItem['id'] ?? 0),
                    'name' => strval($cartItem['name'] ?? ''),
                    'category' => strval($cartItem['category'] ?? ''),
                    'price' => (float) ($cartItem['price'] ?? 0),
                    'image' => is_scalar($cartItem['image'] ?? null) ? strval($cartItem['image']) : '',
                    'quantity' => (int) ($cartItem['quantity'] ?? 0),
                    'subtotal' => (float) ($cartItem['subtotal'] ?? 0),
                ];
            })->values();

            if ($cartItems->isEmpty()) {
                return redirect()->route('menu')->with('info', 'Your cart is empty.');
            }

            $subtotal = (float) $cartItems->sum('subtotal');
            $tax = round($subtotal * 0.05, 2);
            $total = round($subtotal + $tax, 2);
        } catch (\Exception $e) {
            Log::error('Page error: '.$e->getMessage());

            return redirect()->route('menu')
                ->with('error', 'We could not load your checkout right now. Please try again.');
        }

        return view('pages.checkout', [
            'cart_items' => $cartItems,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
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
            $request->session()->put('last_order_payment_method', $order->payment_method);

            // Clear cart after successful order
            $cart->clear();

            return $this->redirectAfterOrderCreation($order)
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
