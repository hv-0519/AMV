<?php

namespace Tests\Browser;

use App\Models\FranchiseEnquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FranchiseTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_franchise_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/franchise')
                ->assertSee('Franchise')
                ->assertPresent('form');
        });
    }

    public function test_franchise_form_submits(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/franchise')
                ->type('name', 'Investor Test')
                ->type('phone', '9988776655')
                ->type('email', 'investor@test.com')
                ->type('city', 'Surat')
                ->type('state', 'Gujarat')
                ->select('investment_capacity', '₹10L – ₹20L (Express Outlet)')
                ->type('message', 'Interested in expansion opportunities.')
                ->click('.btn-submit')
                ->waitForText('Enquiry Received')
                ->assertSee('Franchise enquiry received');
        });
    }

    public function test_admin_can_view_franchise_enquiries(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        FranchiseEnquiry::query()->create([
            'name' => 'Investor ABC',
            'email' => 'investorabc@example.com',
            'phone' => '9988776655',
            'city' => 'Vadodara',
            'state' => 'Gujarat',
            'investment_capacity' => '₹10L – ₹20L (Express Outlet)',
            'message' => 'Ready to discuss.',
            'status' => 'new',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/franchise')
                ->assertSee('Investor ABC')
                ->assertSee('Vadodara');
        });
    }
}
