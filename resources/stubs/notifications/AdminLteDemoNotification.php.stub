<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * A simple database notification rendered by the AdminLTE navbar bell dropdown
 * and the notifications index page. Use it as a template for your own:
 *
 *     $user->notify(new AdminLteDemoNotification(
 *         title: 'Welcome',
 *         message: 'Your account is ready.',
 *         icon: 'bi bi-check-circle',
 *         url: route('dashboard'),
 *     ));
 */
class AdminLteDemoNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $message,
        public string $icon = 'bi bi-bell-fill',
        public ?string $url = null,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'url' => $this->url,
        ];
    }
}
