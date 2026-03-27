<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockAlertTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected string $seeder = DatabaseSeeder::class;

    public function test_low_stock_alert_appears_on_dashboard_when_quantity_is_below_minimum(): void
    {
        $admin = User::where('email', 'admin@mmv.com')->firstOrFail();
        $stock = Stock::where('name', 'Sprouted Moth Beans')->firstOrFail();

        $stock->update([
            'quantity' => 4,
            'min_quantity' => 5,
        ]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSeeText('Low Stock Alerts')
            ->assertSeeText('Sprouted Moth Beans')
            ->assertSeeText('4');
    }
}
