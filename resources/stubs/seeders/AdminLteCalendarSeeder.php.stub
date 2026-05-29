<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminLteCalendarSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $colors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0'];

        foreach (range(1, 12) as $i) {
            $start = now()->addDays(fake()->numberBetween(-10, 30))->setTime(fake()->numberBetween(8, 17), 0);

            Event::create([
                'user_id' => $user->id,
                'title' => fake()->randomElement([
                    'Team Meeting', 'Deployment', 'Client Call', 'Code Review',
                    'Sprint Planning', 'Design Workshop', 'Retrospective',
                ]),
                'start_at' => $start,
                'end_at' => (clone $start)->addHours(fake()->numberBetween(1, 3)),
                'all_day' => fake()->boolean(20),
                'color' => fake()->randomElement($colors),
            ]);
        }
    }
}
