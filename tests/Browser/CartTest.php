<?php

namespace Tests\Browser;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CartTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function createMenuItem(): MenuItem
    {
        return MenuItem::query()->create([
            'name' => 'Misal Pav',
            'category' => 'Misal',
            'description' => 'Fresh test item for browser checkout.',
            'price' => 120,
            'spice_level' => 3,
            'is_available' => true,
            'is_bestseller' => false,
            'is_featured' => false,
        ]);
    }

    public function test_order_page_loads_with_checkout_fields(): void
    {
        $this->createMenuItem();

        $this->browse(function (Browser $browser) {
            $browser->visit('/order')
                ->assertPresent('#orderForm')
                ->assertPresent('select[name="payment_method"]')
                ->assertPresent('#placeOrderBtn');
        });
    }

    public function test_cash_pickup_orders_redirect_to_tracking(): void
    {
        $item = $this->createMenuItem();

        $this->browse(function (Browser $browser) use ($item) {
            $browser->visit('/order')
                ->script("changeQty({$item->id}, 1, 'Misal Pav', 120);");

            $browser->pause(300)
                ->type('guest_name', 'Cash Pickup Guest')
                ->type('guest_email', 'cashpickup@example.com')
                ->type('guest_phone', '9876543210')
                ->select('payment_method', 'cash')
                ->click('#placeOrderBtn')
                ->waitForText('Order Confirmed!')
                ->assertPathBeginsWith('/order/confirmation')
                ->assertSee('Pay Now');
        });
    }

    public function test_upi_orders_redirect_to_payment(): void
    {
        $item = $this->createMenuItem();

        $this->browse(function (Browser $browser) use ($item) {
            $browser->visit('/order')
                ->script("changeQty({$item->id}, 1, 'Misal Pav', 120);");

            $browser->pause(300)
                ->type('guest_name', 'UPI Guest')
                ->type('guest_email', 'upi@example.com')
                ->type('guest_phone', '9876543210')
                ->select('payment_method', 'upi')
                ->click('#placeOrderBtn')
                ->waitForText('AMV Pay')
                ->assertPathBeginsWith('/payment')
                ->assertSee('Scan to Pay with UPI');
        });
    }
}
