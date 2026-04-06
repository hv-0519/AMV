<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function createAdmin(): User
    {
        return User::factory()->create([
            'email' => 'admin@amv.com',
            'password' => bcrypt('admin12345'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_login_and_view_dashboard(): void
    {
        $this->createAdmin();

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'admin@amv.com')
                ->type('password', 'admin12345')
                ->click('.btn-submit')
                ->waitForText('Total Orders')
                ->assertPathBeginsWith('/admin')
                ->assertSee('Revenue')
                ->assertSee('Menu Items');
        });
    }

    public function test_admin_can_open_the_users_directory(): void
    {
        $admin = $this->createAdmin();
        User::factory()->create([
            'name' => 'Visible Customer',
            'email' => 'visible@example.com',
            'role' => 'customer',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Visible Customer');
        });
    }
}
