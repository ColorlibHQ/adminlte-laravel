<?php

namespace Database\Factories;

use App\Models\KanbanBoard;
use App\Models\KanbanLane;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KanbanLane>
 */
class KanbanLaneFactory extends Factory
{
    protected $model = KanbanLane::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'board_id' => KanbanBoard::factory(),
            'name' => fake()->randomElement(['Backlog', 'To Do', 'In Progress', 'Review', 'Done']),
            'position' => fake()->numberBetween(0, 10),
        ];
    }
}
