<?php

namespace Tests\Feature\AdminLte;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_calendar(): void
    {
        $this->get(route('adminlte.calendar.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_the_calendar(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.calendar.index'))
            ->assertOk();
    }

    public function test_the_feed_returns_json_events_for_the_user(): void
    {
        $user = User::factory()->create();
        Event::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->getJson(route('adminlte.calendar.feed'))
            ->assertOk()
            ->assertHeader('content-type', 'application/json')
            ->assertJsonCount(1);
    }

    public function test_an_authenticated_user_can_store_an_event(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('adminlte.calendar.store'), [
                'title' => 'Team Meeting',
                'start_at' => now()->toDateTimeString(),
                'end_at' => now()->addHour()->toDateTimeString(),
                'all_day' => false,
                'color' => '#0d6efd',
            ])
            ->assertOk()
            ->assertJsonFragment(['title' => 'Team Meeting']);

        $this->assertDatabaseHas('adminlte_events', [
            'user_id' => $user->id,
            'title' => 'Team Meeting',
        ]);
    }
}
