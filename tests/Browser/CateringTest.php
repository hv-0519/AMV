<?php

namespace Tests\Browser;

use App\Models\CateringRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CateringTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_catering_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/catering')
                ->assertSee('Catering')
                ->assertPresent('form');
        });
    }

    public function test_catering_form_submits(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/catering')
                ->assertPresent('input[name="name"]')
                ->assertPresent('input[name="phone"]')
                ->assertPresent('input[name="email"]')
                ->assertPresent('select[name="event_type"]')
                ->assertPresent('input[name="event_date"]')
                ->assertPresent('input[name="guests_count"]')
                ->assertPresent('input[name="location"]')
                ->assertPresent('textarea[name="message"]')
                ->assertPresent('.btn-submit');
        });
    }

    public function test_admin_can_view_catering_requests(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        CateringRequest::query()->create([
            'name' => 'Event Person',
            'email' => 'event@example.com',
            'phone' => '9876543210',
            'event_date' => '2026-06-20',
            'event_type' => 'Wedding',
            'guests_count' => 120,
            'location' => 'Ahmedabad',
            'message' => 'Need a large setup.',
            'status' => 'new',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/catering')
                ->assertSee('Event Person')
                ->assertSee('Wedding');
        });
    }
}
