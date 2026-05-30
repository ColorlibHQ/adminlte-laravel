<?php

namespace Database\Factories;

use App\Models\KanbanCard;
use App\Models\KanbanLane;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KanbanCard>
 */
class KanbanCardFactory extends Factory
{
    protected $model = KanbanCard::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lane_id' => KanbanLane::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'color' => fake()->randomElement(['primary', 'info', 'warning', 'success', 'danger']),
            'position' => fake()->numberBetween(0, 10),
        ];
    }
}
