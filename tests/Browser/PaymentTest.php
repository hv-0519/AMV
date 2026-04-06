<?php

namespace Tests\Browser;

use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function createOrder(array $attributes = []): Order
    {
        return Order::query()->create(array_merge([
            'guest_name' => 'Test User',
            'guest_email' => 'test@amv.com',
            'guest_phone' => '9876543210',
            'order_type' => 'delivery',
            'status' => 'pending',
            'total_amount' => 147.00,
            'tax_amount' => 22.47,
            'payment_status' => 'pending',
            'payment_method' => 'upi',
        ], $attributes));
    }

    public function test_upi_payment_page_loads_with_qr_and_countdown(): void
    {
        $order = $this->createOrder();

        $this->browse(function (Browser $browser) use ($order) {
            $browser->visit("/payment/{$order->id}")
                ->assertSee('AMV Pay')
                ->assertSee('Scan to Pay with UPI')
                ->assertPresent('img[alt="AMV UPI QR Code"]')
                ->assertPresent('#countdown')
                ->assertSee('QR visible for')
                ->assertAttribute('#upiPayBtn', 'disabled', 'true');
        });
    }

    public function test_card_payment_page_loads_with_card_fields(): void
    {
        $order = $this->createOrder(['payment_method' => 'card']);

        $this->browse(function (Browser $browser) use ($order) {
            $browser->visit("/payment/{$order->id}")
                ->click('#tab-btn-card')
                ->waitFor('#tab-card.active')
                ->assertPresent('input[name="card_number"]')
                ->assertPresent('input[name="card_name"]')
                ->assertPresent('input[name="card_expiry"]')
                ->assertPresent('input[name="card_cvv"]');
        });
    }

    public function test_paid_orders_redirect_to_success_page(): void
    {
        $order = $this->createOrder([
            'payment_status' => 'paid',
            'transaction_id' => 'TXNABCDEF123456',
        ]);

        $this->browse(function (Browser $browser) use ($order) {
            $browser->visit("/payment/{$order->id}")
                ->waitForText('Payment Successful')
                ->assertPathIs("/payment/{$order->id}/success")
                ->assertSee('TXNABCDEF123456');
        });
    }

    public function test_retry_route_returns_to_payment_page(): void
    {
        $order = $this->createOrder(['payment_status' => 'failed']);

        $this->browse(function (Browser $browser) use ($order) {
            $browser->visit("/payment/{$order->id}/retry")
                ->waitForText('AMV Pay')
                ->assertPathIs("/payment/{$order->id}");
        });
    }
}
