<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected string $seeder = DatabaseSeeder::class;

    public function test_guest_can_place_an_order_and_it_is_saved(): void
    {
        $menuItem = MenuItem::where('name', 'Amdavadi Misal Pav')->firstOrFail();

        $response = $this->postJson('/api/orders', [
            'guest_name' => 'Guest Customer',
            'guest_email' => 'guest@example.com',
            'guest_phone' => '9999999999',
            'order_type' => 'pickup',
            'payment_method' => 'cash',
            'items' => [
                [
                    'id' => $menuItem->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.status', 'pending');

        $this->assertDatabaseHas('orders', [
            'guest_name' => 'Guest Customer',
            'guest_email' => 'guest@example.com',
            'status' => 'pending',
            'payment_method' => 'cash',
        ]);

        $this->assertDatabaseHas('order_items', [
            'menu_item_id' => $menuItem->id,
            'quantity' => 2,
        ]);
    }
}
