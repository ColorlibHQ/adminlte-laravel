<?php

namespace Tests\Feature\AdminLte;

use App\Models\User;
use ColorlibHQ\AdminLte\Support\ActivityLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        ActivityLogger::flushTableCache();
    }

    public function test_guests_are_redirected_from_the_activity_log(): void
    {
        $this->get(route('adminlte.activity.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_the_activity_log(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.activity.index'))
            ->assertOk();
    }

    public function test_the_logger_records_an_activity_row(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        ActivityLogger::log('test.event', 'Something happened', ['foo' => 'bar']);

        $this->assertDatabaseHas('activity_log', [
            'user_id' => $user->id,
            'event' => 'test.event',
            'description' => 'Something happened',
        ]);
    }
}
