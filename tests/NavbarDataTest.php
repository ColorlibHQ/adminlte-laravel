<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Support\NavbarData;

class NavbarDataTest extends TestCase
{
    public function test_notifications_fall_back_to_demo_data_for_guests(): void
    {
        $notifications = NavbarData::notifications();

        $this->assertNotEmpty($notifications);
        $this->assertArrayHasKey('icon', $notifications[0]);
        $this->assertArrayHasKey('text', $notifications[0]);
        $this->assertArrayHasKey('time', $notifications[0]);
    }

    public function test_notification_count_falls_back_to_demo_count(): void
    {
        $this->assertSame(count(NavbarData::notifications()), NavbarData::notificationCount());
    }

    public function test_messages_fall_back_to_demo_data_for_guests(): void
    {
        $messages = NavbarData::messages();

        $this->assertNotEmpty($messages);
        $this->assertArrayHasKey('name', $messages[0]);
    }

    public function test_demo_data_respects_limit(): void
    {
        $this->assertLessThanOrEqual(2, count(NavbarData::notifications(2)));
    }
}
