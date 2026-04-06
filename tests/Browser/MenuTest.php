<?php

namespace Tests\Browser;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MenuTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function createMenuItem(array $attributes): MenuItem
    {
        return MenuItem::query()->create(array_merge([
            'name' => 'Test Dish',
            'category' => 'Misal',
            'description' => 'Browser test menu item.',
            'price' => 120,
            'spice_level' => 2,
            'is_available' => true,
            'is_bestseller' => false,
            'is_featured' => false,
        ], $attributes));
    }

    public function test_menu_page_displays_available_items(): void
    {
        $this->createMenuItem(['name' => 'Special Misal']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/menu')
                ->assertSee('Our Menu')
                ->assertSee('Special Misal')
                ->assertSee('Add to Cart');
        });
    }

    public function test_menu_search_filters_results(): void
    {
        $this->createMenuItem(['name' => 'Kolhapuri Misal']);
        $this->createMenuItem([
            'name' => 'Masala Chai',
            'category' => 'Beverages',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/menu?search=Kolhapuri')
                ->assertSee('Kolhapuri Misal')
                ->assertDontSee('Masala Chai');
        });
    }

    public function test_unavailable_items_are_hidden_from_menu(): void
    {
        $this->createMenuItem([
            'name' => 'Visible Item',
            'is_available' => true,
        ]);
        $this->createMenuItem([
            'name' => 'Hidden Item',
            'is_available' => false,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/menu')
                ->assertSee('Visible Item')
                ->assertDontSee('Hidden Item');
        });
    }
}
