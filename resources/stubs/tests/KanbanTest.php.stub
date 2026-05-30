<?php

namespace Tests\Feature\AdminLte;

use App\Models\KanbanBoard;
use App\Models\KanbanLane;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanbanTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_kanban_board(): void
    {
        $this->get(route('adminlte.kanban.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_the_kanban_board(): void
    {
        $user = User::factory()->create();
        KanbanBoard::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('adminlte.kanban.index'))
            ->assertOk();
    }

    public function test_storing_a_card_returns_json_and_persists_it(): void
    {
        $user = User::factory()->create();
        $board = KanbanBoard::factory()->create(['user_id' => $user->id]);
        $lane = KanbanLane::factory()->create(['board_id' => $board->id]);

        $this->actingAs($user)
            ->postJson(route('adminlte.kanban.cards.store'), [
                'lane_id' => $lane->id,
                'title' => 'Implement feature',
                'color' => 'info',
            ])
            ->assertOk()
            ->assertJsonFragment(['title' => 'Implement feature']);

        $this->assertDatabaseHas('adminlte_kanban_cards', [
            'lane_id' => $lane->id,
            'title' => 'Implement feature',
        ]);
    }
}
