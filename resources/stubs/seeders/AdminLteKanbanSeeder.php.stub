<?php

namespace Database\Seeders;

use App\Models\KanbanBoard;
use App\Models\KanbanCard;
use App\Models\KanbanLane;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminLteKanbanSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $board = KanbanBoard::create([
            'user_id' => $user->id,
            'name' => 'Product Roadmap',
        ]);

        $lanes = ['To Do', 'In Progress', 'Review', 'Done'];
        $colors = ['primary', 'info', 'warning', 'success'];

        foreach ($lanes as $index => $laneName) {
            $lane = KanbanLane::create([
                'board_id' => $board->id,
                'name' => $laneName,
                'position' => $index,
            ]);

            foreach (range(1, fake()->numberBetween(2, 4)) as $pos) {
                KanbanCard::create([
                    'lane_id' => $lane->id,
                    'title' => fake()->sentence(3),
                    'description' => fake()->sentence(8),
                    'color' => $colors[$index],
                    'position' => $pos,
                ]);
            }
        }
    }
}
