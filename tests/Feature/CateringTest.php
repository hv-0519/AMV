<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CateringTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected string $seeder = DatabaseSeeder::class;

    public function test_catering_form_submission_saves_a_request_record(): void
    {
        $response = $this->post('/catering', [
            'name' => 'Event Planner',
            'email' => 'planner@example.com',
            'phone' => '9876543210',
            'event_date' => now()->addWeek()->toDateString(),
            'event_type' => 'Corporate Lunch',
            'guests_count' => 75,
            'location' => 'Mumbai',
            'message' => 'Need a spicy live counter.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('catering_requests', [
            'name' => 'Event Planner',
            'email' => 'planner@example.com',
            'event_type' => 'Corporate Lunch',
            'guests_count' => 75,
            'location' => 'Mumbai',
        ]);
    }
}
