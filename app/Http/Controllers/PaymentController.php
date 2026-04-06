<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // Show mock payment gateway page
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment_status === 'paid') {
            return redirect()->route('payment.success', $orderId);
        }

        return view('payment.payment', compact('order'));
    }

    // Process mock payment — 70% success, 30% failure
    public function process(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $method = $request->input('payment_method', 'upi');
        $upiId = $request->input('upi_id');
        $success = (rand(1, 10) <= 7);

        if ($success) {
            $order->update([
                'payment_method' => $method,
                'payment_status' => 'paid',
                'transaction_id' => 'TXN'.strtoupper(Str::random(12)),
                'upi_id' => $upiId ?? null,
                'status' => 'processing',
            ]);

            return redirect()->route('payment.success', $orderId);
        } else {
            $order->update([
                'payment_method' => $method,
                'payment_status' => 'failed',
            ]);

            return redirect()->route('payment.failed', $orderId);
        }
    }

    // Success page
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('payment.success', compact('order'));
    }

    // Failed page
    public function failed($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('payment.failed', compact('order'));
    }

    // Retry — go back to payment page
    public function retry($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['payment_status' => 'pending']);

        return redirect()->route('payment.show', $orderId);
    }
}
