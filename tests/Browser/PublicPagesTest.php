<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PublicPagesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_home_page_loads_with_main_navigation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Dil Bole Wow')
                ->assertSeeLink('Menu')
                ->assertSeeLink('About')
                ->assertSeeLink('Contact');
        });
    }

    public function test_about_contact_and_gallery_pages_load(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about')
                ->assertSee('Our Story')
                ->visit('/contact')
                ->assertSee('Get in Touch')
                ->assertPresent('form')
                ->visit('/gallery')
                ->assertSee('Our Gallery')
                ->assertPresent('img');
        });
    }

    public function test_contact_form_submits_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->type('name', 'Contact Tester')
                ->type('email', 'contact@test.com')
                ->type('phone', '9876543210')
                ->type('message', 'This is a test message from Dusk.')
                ->click('.btn-submit')
                ->waitForText('Message Sent')
                ->assertSee('Thank you for reaching out');
        });
    }
}
