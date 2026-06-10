<?php

namespace ColorlibHQ\AdminLte\Support;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Feeds the navbar dropdowns (notifications + messages) from real Laravel data
 * when the backing tables exist, and falls back to the config-driven demo data
 * otherwise. This keeps the package's navbar 1:1 with the AdminLTE HTML demo out
 * of the box, but makes it "real" the moment you scaffold notifications/mailbox.
 *
 * Table-existence checks are memoized per request so the navbar costs at most one
 * extra query, and everything is wrapped defensively so a missing table or a
 * pre-migration request can never break page rendering.
 */
class NavbarData
{
    private static ?bool $hasNotificationsTable = null;

    private static ?bool $hasMessagesTable = null;

    /**
     * Unread notifications for the navbar bell dropdown.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function notifications(int $limit = 5): array
    {
        $user = Auth::user();

        if ($user !== null && self::hasNotificationsTable() && method_exists($user, 'unreadNotifications')) {
            return $user->unreadNotifications()->latest()->limit($limit)->get()
                ->map(function (DatabaseNotification $n): array {
                    $createdAt = $n->getAttribute('created_at');

                    return [
                        'icon' => $n->data['icon'] ?? 'bi bi-bell-fill',
                        'text' => $n->data['message'] ?? ($n->data['title'] ?? __('adminlte.notifications')),
                        'time' => $createdAt instanceof Carbon ? $createdAt->diffForHumans() : '',
                        'url' => $n->data['url'] ?? null,
                    ];
                })->all();
        }

        return array_slice(self::demoNotifications(), 0, $limit);
    }

    public static function notificationCount(): int
    {
        $user = Auth::user();

        if ($user !== null && self::hasNotificationsTable() && method_exists($user, 'unreadNotifications')) {
            return $user->unreadNotifications()->count();
        }

        return (int) config('adminlte.navbar_notifications_count', count(self::demoNotifications()));
    }

    /**
     * Unread messages addressed to the current user (from the scaffolded mailbox).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function messages(int $limit = 5): array
    {
        $user = Auth::user();

        if ($user !== null && self::hasMessagesTable()) {
            $rows = DB::table('adminlte_messages as m')
                ->join('users as u', 'u.id', '=', 'm.from_user_id')
                ->where('m.to_user_id', $user->getAuthIdentifier())
                ->where('m.is_read', false)
                ->orderByDesc('m.created_at')
                ->limit($limit)
                ->get(['u.name', 'm.subject', 'm.created_at', 'm.id']);

            if ($rows->isNotEmpty()) {
                return $rows->map(fn ($m) => [
                    'name' => $m->name,
                    'text' => $m->subject,
                    'time' => Carbon::parse($m->created_at)->diffForHumans(),
                    'star' => 'secondary',
                    'id' => $m->id,
                    'img' => 'vendor/adminlte/img/user2-160x160.jpg',
                ])->all();
            }

            return [];
        }

        return array_slice(self::demoMessages(), 0, $limit);
    }

    public static function messageCount(): int
    {
        $user = Auth::user();

        if ($user !== null && self::hasMessagesTable()) {
            return (int) DB::table('adminlte_messages')
                ->where('to_user_id', $user->getAuthIdentifier())
                ->where('is_read', false)
                ->count();
        }

        return count(self::demoMessages());
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function demoNotifications(): array
    {
        /** @var array<int, array<string, mixed>> $items */
        $items = config('adminlte.navbar_notifications', [
            ['icon' => 'bi bi-envelope', 'text' => '4 new messages', 'time' => '3 mins'],
            ['icon' => 'bi bi-people-fill', 'text' => '8 friend requests', 'time' => '12 hours'],
            ['icon' => 'bi bi-file-earmark-fill', 'text' => '3 new reports', 'time' => '2 days'],
        ]);

        return $items;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function demoMessages(): array
    {
        /** @var array<int, array<string, mixed>> $items */
        $items = config('adminlte.navbar_messages', [
            ['name' => 'Brad Diesel', 'text' => 'Call me whenever you can...', 'time' => '4 Hours Ago', 'star' => 'danger', 'img' => 'vendor/adminlte/img/user1-128x128.jpg'],
            ['name' => 'John Pierce', 'text' => 'I got your message bro', 'time' => '4 Hours Ago', 'star' => 'secondary', 'img' => 'vendor/adminlte/img/user8-128x128.jpg'],
            ['name' => 'Nora Silvester', 'text' => 'The subject goes here', 'time' => '4 Hours Ago', 'star' => 'warning', 'img' => 'vendor/adminlte/img/user3-128x128.jpg'],
        ]);

        return $items;
    }

    private static function hasNotificationsTable(): bool
    {
        if (self::$hasNotificationsTable === null) {
            try {
                self::$hasNotificationsTable = Schema::hasTable('notifications');
            } catch (\Throwable) {
                self::$hasNotificationsTable = false;
            }
        }

        return self::$hasNotificationsTable;
    }

    private static function hasMessagesTable(): bool
    {
        if (self::$hasMessagesTable === null) {
            try {
                self::$hasMessagesTable = Schema::hasTable('adminlte_messages');
            } catch (\Throwable) {
                self::$hasMessagesTable = false;
            }
        }

        return self::$hasMessagesTable;
    }
}
