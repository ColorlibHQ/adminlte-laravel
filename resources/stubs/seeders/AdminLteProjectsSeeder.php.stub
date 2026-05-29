<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class AdminLteProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['planning', 'active', 'on_hold', 'completed'];

        foreach (range(1, 8) as $i) {
            $status = fake()->randomElement($statuses);

            Project::create([
                'name' => fake()->catchPhrase(),
                'description' => fake()->paragraph(),
                'status' => $status,
                'progress' => $status === 'completed' ? 100 : fake()->numberBetween(0, 95),
                'due_date' => fake()->dateTimeBetween('now', '+3 months'),
            ]);
        }
    }
}
