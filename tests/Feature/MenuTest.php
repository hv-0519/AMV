<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected string $seeder = DatabaseSeeder::class;

    public function test_menu_page_loads_and_displays_seeded_items(): void
    {
        $response = $this->get('/menu');

        $response->assertOk();
        $response->assertSeeText('Amdavadi Misal Pav');
        $response->assertSeeText('Cheese Blast Vadapav');
        $response->assertSeeText('Mango Lassi');
    }
}
