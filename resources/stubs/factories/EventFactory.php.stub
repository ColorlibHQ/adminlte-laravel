<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', '+1 month');
        $end = fake()->dateTimeBetween($start, '+2 months');

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'start_at' => $start,
            'end_at' => $end,
            'all_day' => fake()->boolean(),
            'color' => fake()->hexColor(),
        ];
    }
}
