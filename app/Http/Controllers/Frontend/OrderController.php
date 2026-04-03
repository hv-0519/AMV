<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected function rememberTrackedOrder(Request $request, Order $order): void
    {
        $request->session()->put('last_tracked_order_id', $order->id);
    }

    protected function authorizeTrackedOrder(Request $request, Order $order): void
    {
        if (auth()->check()) {
            $user = $request->user();

            if (in_array($user->role, ['admin', 'staff'], true)) {
                return;
            }

            abort_unless($order->user_id === $user->id, 403);

            return;
        }

        abort_unless((int) $request->session()->get('last_tracked_order_id') === $order->id, 403);
    }

    public function index()
    {
        $menu_items = MenuItem::available()->get()->groupBy('category');

        return view('pages.order', compact('menu_items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_type' => 'required|in:dine-in,pickup,delivery',
            'payment_method' => 'required|in:cash,card,upi,online',
            'delivery_address' => 'required_if:order_type,delivery|nullable|string',
            'notes' => 'nullable|string|max:300',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1|max:20',

            // Guest info if not logged in
            'guest_name' => auth()->check() ? 'nullable' : 'required|string|max:100',
            'guest_email' => auth()->check() ? 'nullable' : 'required|email',
            'guest_phone' => auth()->check() ? 'nullable' : 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            $order_items_data = [];

            foreach ($request->items as $item) {
                $menu_item = MenuItem::findOrFail($item['id']);
                $subtotal = $menu_item->price * $item['quantity'];
                $total += $subtotal;

                $order_items_data[] = [
                    'menu_item_id' => $menu_item->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $menu_item->price,
                    'subtotal' => $subtotal,
                ];
            }

            $tax = $total * 0.05; // 5% tax

            $order = Order::create([
                'user_id' => auth()->id(),
                'guest_name' => $request->guest_name,
                'guest_email' => $request->guest_email,
                'guest_phone' => $request->guest_phone,
                'order_type' => $request->order_type,
                'status' => 'pending',
                'total_amount' => $total + $tax,
                'tax_amount' => $tax,
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ]);

            foreach ($order_items_data as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            DB::commit();
            $this->rememberTrackedOrder($request, $order);

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Order placed successfully! 🎉 Dil Bole Wow!!')
                ->with('flash_modal', 'order-success');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Something went wrong. Please try again.')
                ->with('flash_modal', 'order-error')
                ->withInput();
        }
    }

    public function latest(Request $request): RedirectResponse
    {
        $order = auth()->check()
            ? Order::query()
                ->where('user_id', $request->user()->id)
                ->latest('id')
                ->first()
            : Order::query()->find($request->session()->get('last_tracked_order_id'));

        if (! $order) {
            return redirect()->route('menu')
                ->with('error', 'No recent order was found to track yet.')
                ->with('flash_modal', 'error');
        }

        $this->rememberTrackedOrder($request, $order);

        return redirect()->route('order.confirmation', $order);
    }

    public function confirmation(Request $request, Order $order)
    {
        $this->authorizeTrackedOrder($request, $order);
        $this->rememberTrackedOrder($request, $order);
        $order->load('orderItems.menuItem');

        return view('pages.order-confirmation', compact('order'));
    }

    public function status(Request $request, Order $order): OrderResource
    {
        $this->authorizeTrackedOrder($request, $order);
        $this->rememberTrackedOrder($request, $order);
        $order->load('orderItems.menuItem');

        return new OrderResource($order);
    }
}
