<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminLteMailboxSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            $users = User::factory()->count(3)->create();
        }

        $recipient = $users->first();

        foreach ($users->skip(1) as $sender) {
            foreach (range(1, 5) as $i) {
                Message::create([
                    'from_user_id' => $sender->id,
                    'to_user_id' => $recipient->id,
                    'subject' => fake()->sentence(4),
                    'body' => fake()->paragraphs(3, true),
                    'is_read' => fake()->boolean(30),
                    'is_starred' => fake()->boolean(20),
                ]);
            }
        }
    }
}
