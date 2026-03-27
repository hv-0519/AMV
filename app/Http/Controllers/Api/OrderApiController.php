<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderApiController extends Controller
{
    /**
     * Place a new order and return the persisted record.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $order = DB::transaction(function () use ($validated, $request): Order {
            $items = collect($validated['items']);
            $menuItems = MenuItem::available()
                ->whereIn('id', $items->pluck('id'))
                ->get()
                ->keyBy('id');

            $subtotal = 0;

            $order = Order::create([
                'user_id' => $request->user()?->id,
                'guest_name' => $request->user() ? null : $validated['guest_name'],
                'guest_email' => $request->user() ? null : $validated['guest_email'],
                'guest_phone' => $request->user() ? null : $validated['guest_phone'],
                'order_type' => $validated['order_type'],
                'status' => 'pending',
                'total_amount' => 0,
                'tax_amount' => 0,
                'delivery_address' => $validated['delivery_address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
            ]);

            $items->each(function (array $item) use ($menuItems, $order, &$subtotal): void {
                $menuItem = $menuItems->get($item['id']);

                if (! $menuItem) {
                    abort(Response::HTTP_NOT_FOUND, 'One or more menu items are unavailable.');
                }

                $lineSubtotal = (float) $menuItem->price * $item['quantity'];
                $subtotal += $lineSubtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $menuItem->price,
                    'subtotal' => $lineSubtotal,
                ]);
            });

            $taxAmount = round($subtotal * 0.05, 2);

            $order->update([
                'tax_amount' => $taxAmount,
                'total_amount' => round($subtotal + $taxAmount, 2),
            ]);

            return $order->fresh(['orderItems.menuItem', 'user']);
        });

        return response()->json([
            'data' => (new OrderResource($order))->resolve(),
        ], Response::HTTP_CREATED);
    }

    /**
     * Return the authenticated user's order details.
     */
    public function show(Request $request, Order $order): OrderResource
    {
        abort_unless($order->user_id === $request->user()?->id, Response::HTTP_NOT_FOUND);

        return new OrderResource($order->loadMissing(['orderItems.menuItem', 'user']));
    }
}
