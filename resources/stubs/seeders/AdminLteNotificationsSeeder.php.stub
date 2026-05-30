<?php

namespace Database\Seeders;

use App\Models\User;
use App\Notifications\AdminLteDemoNotification;
use Illuminate\Database\Seeder;

class AdminLteNotificationsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->first();

        if (! $user) {
            return;
        }

        $demo = [
            ['Welcome aboard', 'Your AdminLTE dashboard is ready to use.', 'bi bi-stars', null],
            ['New message', 'You have a new message in your mailbox.', 'bi bi-envelope-fill', null],
            ['Report generated', 'The monthly sales report is available.', 'bi bi-file-earmark-bar-graph-fill', null],
            ['Server notice', 'Scheduled maintenance completed successfully.', 'bi bi-hdd-network-fill', null],
        ];

        foreach ($demo as [$title, $message, $icon, $url]) {
            $user->notify(new AdminLteDemoNotification($title, $message, $icon, $url));
        }
    }
}
