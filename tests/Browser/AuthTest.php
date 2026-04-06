<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_register(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('first_name', 'Test')
                ->type('last_name', 'User')
                ->type('email', 'testuser@amv.com')
                ->type('phone', '9876543210')
                ->type('password', 'password123')
                ->type('password_confirmation', 'password123')
                ->click('.btn-submit')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }

    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'login@amv.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitFor('#logoutTrigger', 10)
                ->click('#logoutTrigger')
                ->waitFor('#logoutConfirmBtn')
                ->click('#logoutConfirmBtn')
                ->waitForText('Login')
                ->assertSee('Login');
        });
    }

    public function test_forgot_password_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/forgot-password')
                ->assertSee('Reset Password')
                ->assertPresent('input[name="email"]');
        });
    }
}
