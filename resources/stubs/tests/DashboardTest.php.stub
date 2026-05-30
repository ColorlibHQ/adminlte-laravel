<?php

namespace Tests\Feature\AdminLte;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_dashboard(): void
    {
        $this->get(route('adminlte.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_sees_the_dashboard_with_stats(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.dashboard'))
            ->assertOk()
            // The users stat box reflects real data (at least the acting user).
            ->assertSee(__('adminlte.users'));
    }
}
